@extends('layouts.app')

@section('title', 'Notifications')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
            <p class="mt-1 text-sm text-gray-600">Stay updated with system alerts</p>
        </div>
        <div>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-check-double mr-2"></i> Mark All as Read
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <!-- Notification Filters -->
        <div class="border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex space-x-4">
                    <button class="px-4 py-2 bg-primary text-white font-medium rounded-lg">
                        All
                    </button>
                    <button class="px-4 py-2 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition">
                        Unread
                    </button>
                    <button class="px-4 py-2 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition">
                        Important
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-gray-200">
            @for ($i = 1; $i <= 10; $i++)
                <div class="p-6 hover:bg-gray-50 transition {{ $i <= 3 ? 'bg-primary/5' : '' }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @if ($i == 1)
                                <div class="w-10 h-10 bg-attendance-green/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-attendance-green"></i>
                                </div>
                            @elseif($i == 2)
                                <div class="w-10 h-10 bg-attendance-red/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle text-attendance-red"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-attendance-blue/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-info-circle text-attendance-blue"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">
                                    @if ($i == 1)
                                        Attendance Marked Successfully
                                    @elseif($i == 2)
                                        System Maintenance Alert
                                    @else
                                        New Student Registered
                                    @endif
                                </p>
                                <span class="text-xs text-gray-500">
                                    {{ now()->subHours($i)->diffForHumans() }}
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600">
                                @if ($i == 1)
                                    Your attendance for today has been successfully marked. You were marked present.
                                @elseif($i == 2)
                                    System maintenance scheduled for tomorrow from 2:00 AM to 4:00 AM.
                                @else
                                    A new student, John Doe, has been registered in Grade 10 A.
                                @endif
                            </p>
                            @if ($i <= 3)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary mt-2">
                                    <i class="fas fa-circle mr-1" style="font-size: 6px;"></i> New
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Load More -->
        <div class="px-6 py-4 border-t border-gray-200 text-center">
            <button
                class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                Load More Notifications
            </button>
        </div>
    </div>
@endsection
