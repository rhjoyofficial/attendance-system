@extends('layouts.app')

@section('title', 'Classes Management')

@section('header')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Classes Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all classes in the system</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('classes.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-primary/90 text-white font-medium rounded-lg hover:from-primary/90 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                <i class="fas fa-plus mr-2"></i> Add New Class
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if ($classes->isEmpty())
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 bg-primary/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-primary text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No classes found</h3>
                <p class="text-gray-500 mb-6">Get started by creating your first class.</p>
                <a href="{{ route('classes.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-primary/90 text-white font-medium rounded-lg hover:from-primary/90 hover:to-primary">
                    <i class="fas fa-plus mr-2"></i> Create Class
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Class Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Section
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teacher
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Students
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($classes as $class)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-chalkboard-teacher text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $class->class_name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $class->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $class->section ? 'bg-attendance-blue/10 text-attendance-blue' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $class->section ?: 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $class->subject ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($class->teacher)
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-accent/10 flex items-center justify-center mr-2">
                                                <i class="fas fa-user-tie text-accent text-xs"></i>
                                            </div>
                                            <span
                                                class="text-sm text-gray-900">{{ $class->teacher->user->name ?? 'N/A' }}</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-graduate text-attendance-blue mr-2"></i>
                                        <span>{{ $class->students->count() }} students</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('classes.edit', $class) }}"
                                            class="text-primary hover:text-primary/80 transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this class?');">
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

            @if ($classes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $classes->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
