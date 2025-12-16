@extends('layouts.app')

@section('title', 'Teachers Management')

@section('header')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Teachers Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all teachers in the system</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('teachers.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-primary/90 text-white font-medium rounded-lg hover:from-primary/90 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                <i class="fas fa-plus mr-2"></i> Add New Teacher
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if ($teachers->isEmpty())
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 bg-accent/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-tie text-accent text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No teachers found</h3>
                <p class="text-gray-500 mb-6">Get started by adding your first teacher.</p>
                <a href="{{ route('teachers.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-primary/90 text-white font-medium rounded-lg hover:from-primary/90 hover:to-primary">
                    <i class="fas fa-plus mr-2"></i> Add Teacher
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teacher
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assigned Class
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($teachers as $teacher)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-tie text-accent"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $teacher->user->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $teacher->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent/10 text-accent">
                                        {{ $teacher->subject ?: 'Not specified' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($teacher->classRoom)
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-2">
                                                <i class="fas fa-chalkboard-teacher text-primary text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-900">{{ $teacher->classRoom->class_name }}</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        {{ $teacher->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('teachers.edit', $teacher) }}"
                                            class="text-primary hover:text-primary/80 transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-attendance-red hover:text-attendance-red/80 transition-colors"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($teachers->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $teachers->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
