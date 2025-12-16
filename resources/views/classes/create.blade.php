@extends('layouts.app')

@section('title', 'Create New Class')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Class</h1>
            <p class="mt-1 text-sm text-gray-600">Add a new class to the system</p>
        </div>
        <div>
            <a href="{{ route('classes.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Classes
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Class Name -->
                <div>
                    <label for="class_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Class Name <span class="text-attendance-red">*</span>
                    </label>
                    <input type="text" id="class_name" name="class_name" value="{{ old('class_name') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('class_name') border-attendance-red @enderror"
                        placeholder="e.g., Grade 10 A">
                    @error('class_name')
                        <p class="mt-1 text-sm text-attendance-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section and Subject -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 mb-1">
                            Section
                        </label>
                        <input type="text" id="section" name="section" value="{{ old('section') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('section') border-attendance-red @enderror"
                            placeholder="e.g., A, B, C">
                        @error('section')
                            <p class="mt-1 text-sm text-attendance-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                            Subject (Optional)
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('subject') border-attendance-red @enderror"
                            placeholder="e.g., Mathematics">
                        @error('subject')
                            <p class="mt-1 text-sm text-attendance-red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('classes.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-primary to-primary/90 text-white font-medium rounded-lg hover:from-primary/90 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                        Create Class
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
