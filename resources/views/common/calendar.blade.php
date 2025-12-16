@extends('layouts.app')

@section('title', 'Calendar')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Calendar</h1>
            <p class="mt-1 text-sm text-gray-600">View important dates and events</p>
        </div>
        <div class="flex items-center space-x-4">
            <button
                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/90 text-white font-medium rounded-lg hover:from-primary/90 hover:to-primary transition">
                <i class="fas fa-plus mr-2"></i> Add Event
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div id="calendar"></div>
    </div>

    @push('styles')
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    @endpush

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: [
                        @if (auth()->user()->isStudent())
                            {
                                title: 'Math Class',
                                start: '{{ now()->format('Y-m-d') }}T09:00:00',
                                end: '{{ now()->format('Y-m-d') }}T10:30:00',
                                backgroundColor: '#ea2f30',
                                borderColor: '#ea2f30'
                            },
                        @endif {
                            title: 'Staff Meeting',
                            start: '{{ now()->addDay()->format('Y-m-d') }}T14:00:00',
                            end: '{{ now()->addDay()->format('Y-m-d') }}T15:00:00',
                            backgroundColor: '#b16130',
                            borderColor: '#b16130'
                        }
                    ],
                    eventClick: function(info) {
                        alert('Event: ' + info.event.title);
                    }
                });
                calendar.render();
            });
        </script>
    @endpush
@endsection
