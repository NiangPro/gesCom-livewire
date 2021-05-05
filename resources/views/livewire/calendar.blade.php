<div>
    <div class="card">
        <div class="card-body p-5" id='calendar-container' wire:ignore>
            <div id='calendar'></div>
        </div>
    </div>
</div>

@section('js')
    <script>
        document.addEventListener('livewire:load', function () {
            const Calendar = FullCalendar.Calendar;
            const calendarEl = document.getElementById('calendar');
            const calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: 'fr',
                events: JSON.parse(`<?php echo $events; ?>`),
            });
            calendar.render();
        });
    </script>
@endsection
