@extends('layouts.app')

@section('title', 'Audit Log Details')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Log Details</h1>
            <p class="mt-1 text-sm text-gray-600">Detailed view of system activity</p>
        </div>
        <div>
            <a href="{{ route('audit-logs.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Logs
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="space-y-6">
                    <!-- Action Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <span
                                class="px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                                @if (str_contains(strtolower($auditLog->action), 'create')) bg-attendance-green/10 text-attendance-green
                                @elseif(str_contains(strtolower($auditLog->action), 'update')) bg-attendance-blue/10 text-attendance-blue
                                @elseif(str_contains(strtolower($auditLog->action), 'delete')) bg-attendance-red/10 text-attendance-red
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $auditLog->action }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $auditLog->created_at->format('F j, Y \a\t g:i A') }}
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">User Information</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="text-primary font-semibold">
                                    {{ strtoupper(substr($auditLog->user->name ?? 'S', 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $auditLog->user->name ?? 'System' }}</p>
                                <p class="text-sm text-gray-500">{{ $auditLog->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Action Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $auditLog->details }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Technical Details -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">Technical Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-500">Log ID</dt>
                        <dd class="text-sm text-gray-900 font-mono">{{ $auditLog->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">User ID</dt>
                        <dd class="text-sm text-gray-900">{{ $auditLog->user_id ?? 'System' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">IP Address</dt>
                        <dd class="text-sm text-gray-900 font-mono">{{ $auditLog->ip_address }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Created At</dt>
                        <dd class="text-sm text-gray-900">{{ $auditLog->created_at->format('Y-m-d H:i:s') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Time Since</dt>
                        <dd class="text-sm text-gray-900">{{ $auditLog->created_at->diffForHumans() }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('audit-logs.index') }}"
                        class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-list mr-2"></i> View All Logs
                    </a>
                    <button onclick="window.print()"
                        class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-print mr-2"></i> Print Details
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
