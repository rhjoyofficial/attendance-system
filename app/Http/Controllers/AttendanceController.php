<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $classes = ClassRoom::all();
        } elseif ($user->isTeacher()) {
            $teacher = $user->teacher;
            $classes = $teacher ? ClassRoom::where('id', $teacher->class_id)->get() : collect();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('attendance.index', compact('classes'));
    }

    public function fetchStudents(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        $students = Student::with('user')
            ->where('class_id', $request->class_id)
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'roll_number' => $student->roll_number,
                    'name' => $student->user->name,
                ];
            });

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:Present,Absent',
            'remarks' => 'nullable|array',
        ]);

        $teacherId = auth()->user()->teacher ? auth()->user()->teacher->id : null;

        foreach ($request->status as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'class_id' => $request->class_id,
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'teacher_id' => $teacherId,
                    'status' => $status,
                    'remarks' => $request->remarks[$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance marked successfully.');
    }

    public function report()
    {
        $user = auth()->user();
        $reportData = [];

        if ($user->isAdmin()) {
            // Admin sees all classes
            $classes = ClassRoom::with(['attendances', 'students'])->get();

            foreach ($classes as $class) {
                $totalStudents = $class->students->count();
                $presentToday = $class->attendances()->whereDate('date', today())->where('status', 'Present')->count();
                $absentToday = $class->attendances()->whereDate('date', today())->where('status', 'Absent')->count();

                $reportData[] = [
                    'class' => $class,
                    'total_students' => $totalStudents,
                    'present_today' => $presentToday,
                    'absent_today' => $absentToday,
                    'attendance_rate' => $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 2) : 0,
                ];
            }
        } elseif ($user->isTeacher()) {
            // Teacher sees only their class
            $teacher = $user->teacher;

            if ($teacher && $teacher->classRoom) {
                $class = $teacher->classRoom;
                $totalStudents = $class->students->count();
                $presentToday = $class->attendances()->whereDate('date', today())->where('status', 'Present')->count();
                $absentToday = $class->attendances()->whereDate('date', today())->where('status', 'Absent')->count();

                $reportData[] = [
                    'class' => $class,
                    'total_students' => $totalStudents,
                    'present_today' => $presentToday,
                    'absent_today' => $absentToday,
                    'attendance_rate' => $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 2) : 0,
                ];
            }
        }

        return view('attendance.report', compact('reportData'));
    }

    public function myAttendance()
    {
        $user = auth()->user();

        if (!$user->isStudent()) {
            abort(403, 'Unauthorized');
        }

        $student = $user->student;
        $attendances = $student->attendances()->with('classRoom')->latest()->paginate(10);

        $stats = [
            'total' => $student->attendances()->count(),
            'present' => $student->attendances()->where('status', 'Present')->count(),
            'absent' => $student->attendances()->where('status', 'Absent')->count(),
            'percentage' => $student->attendances()->count() > 0
                ? round(($student->attendances()->where('status', 'Present')->count() / $student->attendances()->count()) * 100, 1)
                : 0,
        ];

        return view('attendance.my', compact('attendances', 'stats'));
    }
}
