@extends('layouts.app')

@section('title', 'Audit Logs')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Logs</h1>
            <p class="mt-1 text-sm text-gray-600">System activity and user actions</p>
        </div>
        <div>
            <button onclick="window.print()"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-print mr-2"></i> Print
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Timestamp
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Details
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            IP Address
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2">
                                        <span class="text-primary text-xs font-semibold">
                                            {{ strtoupper(substr($log->user->name ?? 'S', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-900">
                                        {{ $log->user->name ?? 'System' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if (str_contains(strtolower($log->action), 'create')) bg-attendance-green/10 text-attendance-green
                                    @elseif(str_contains(strtolower($log->action), 'update')) bg-attendance-blue/10 text-attendance-blue
                                    @elseif(str_contains(strtolower($log->action), 'delete')) bg-attendance-red/10 text-attendance-red
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ Str::limit($log->details, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-history text-4xl mb-4"></i>
                                    <p class="text-lg">No audit logs found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
