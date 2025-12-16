@extends('layouts.app')

@section('title', 'Mark Attendance')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mark Attendance</h1>
            <p class="mt-1 text-sm text-gray-600">Take attendance for today's class</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-2 bg-primary/10 text-primary rounded-lg">
                <i class="fas fa-calendar-day mr-2"></i>
                <span>{{ now()->format('F j, Y') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div x-data="attendanceApp()">
            <!-- Class Selection -->
            <div class="mb-6">
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Select Class <span class="text-attendance-red">*</span>
                </label>
                <div class="flex space-x-4">
                    <select id="class_id" x-model="selectedClass" @change="fetchStudents()"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        <option value="">Select a class...</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->class_name }} {{ $class->section ? '(' . $class->section . ')' : '' }}
                            </option>
                        @endforeach
                    </select>

                    <button @click="fetchStudents()" :disabled="!selectedClass"
                        :class="!selectedClass ? 'bg-gray-300 cursor-not-allowed' :
                            'bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary'"
                        class="px-6 py-3 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                        Load Students
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                <p class="mt-2 text-gray-600">Loading students...</p>
            </div>

            <!-- Attendance Form -->
            <form x-show="students.length > 0" @submit.prevent="submitAttendance" method="POST"
                action="{{ route('attendance.store') }}">
                @csrf
                <input type="hidden" name="class_id" :value="selectedClass">
                <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roll No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Remarks
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="(student, index) in students" :key="student.id">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900" x-text="student.roll_number"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-attendance-blue/10 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user-graduate text-attendance-blue text-xs"></i>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900" x-text="student.name"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" :name="'status[' + student.id + ']'" value="Present"
                                                    x-model="student.status"
                                                    class="text-attendance-green focus:ring-attendance-green">
                                                <span class="ml-2 text-sm text-gray-700">Present</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" :name="'status[' + student.id + ']'" value="Absent"
                                                    x-model="student.status"
                                                    class="text-attendance-red focus:ring-attendance-red">
                                                <span class="ml-2 text-sm text-gray-700">Absent</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" :name="'remarks[' + student.id + ']'"
                                            x-model="student.remarks" placeholder="Optional remarks"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 mt-6">
                    <button type="button" @click="markAll('Present')"
                        class="px-4 py-2 bg-attendance-green/10 text-attendance-green font-medium rounded-lg hover:bg-attendance-green/20 transition">
                        Mark All Present
                    </button>
                    <button type="button" @click="markAll('Absent')"
                        class="px-4 py-2 bg-attendance-red/10 text-attendance-red font-medium rounded-lg hover:bg-attendance-red/20 transition">
                        Mark All Absent
                    </button>
                    <button type="submit" :disabled="submitting"
                        :class="submitting ? 'bg-gray-300 cursor-not-allowed' :
                            'bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary'"
                        class="px-6 py-2 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                        <span x-show="!submitting">Submit Attendance</span>
                        <span x-show="submitting">Submitting...</span>
                    </button>
                </div>
            </form>

            <!-- Empty State -->
            <div x-show="!loading && students.length === 0 && selectedClass" class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No students found</h3>
                <p class="text-gray-500">This class has no students enrolled.</p>
            </div>
        </div>
    </div>

    <script>
        function attendanceApp() {
            return {
                selectedClass: '',
                students: [],
                loading: false,
                submitting: false,

                fetchStudents() {
                    if (!this.selectedClass) return;

                    this.loading = true;
                    this.students = [];

                    fetch('{{ route('attendance.fetch') }}?class_id=' + this.selectedClass)
                        .then(response => response.json())
                        .then(data => {
                            this.students = data.map(student => ({
                                ...student,
                                status: 'Present', // Default status
                                remarks: ''
                            }));
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to load students. Please try again.');
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                },

                markAll(status) {
                    this.students.forEach(student => {
                        student.status = status;
                    });
                },

                submitAttendance() {
                    this.submitting = true;

                    // The form will submit normally via Laravel
                    // This function just handles the UI state
                    setTimeout(() => {
                        this.submitting = false;
                    }, 1000);
                }
            }
        }
    </script>
@endsection
