<script setup>
import { defineComponent, ref } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

let eventGuid = 0;
let todayStr = new Date().toISOString().replace(/T.*$/, "");
const currentEvents = ref([]);

const createEventId = () => {
    return String(eventGuid++);
};
const INITIAL_EVENTS = [
    {
        id: createEventId(),
        title: "Evento del día",
        start: todayStr,
    },
    {
        id: createEventId(),
        title: "Evento de hora",
        start: todayStr + "T12:00:00",
    },
];

const handleDateSelect = (selectInfo) => {
    let title = prompt("Ingresa un nuevo envento");
    let calendarApi = selectInfo.view.calendar;

    calendarApi.unselect(); // clear date selection

    if (title) {
        calendarApi.addEvent({
            id: createEventId(),
            title,
            start: selectInfo.startStr,
            end: selectInfo.endStr,
            allDay: selectInfo.allDay,
        });
    }
};

const handleEventClick = (clickInfo) => {
    if (
        confirm(
            `Está seguro que desea eliminar el evento '${clickInfo.event.title}'`
        )
    ) {
        clickInfo.event.remove();
    }
};

const handleEvents = (events) => {
    currentEvents.value = events;
};

const calendarOptions = {
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    initialView: "dayGridMonth",
    initialEvents: INITIAL_EVENTS,
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    select: handleDateSelect,
    eventClick: handleEventClick,
    eventsSet: handleEvents,
};

const handleWeekendsToggle = () => {
    calendarOptions.weekends = !calendarOptions.weekends;
};
</script>
<template>
    <div class="flex flex-col gap-4 min-h-full text-sm lg:flex-row-reverse lg:text-base">
        <div class="p-8 lg:flex-grow">
            <FullCalendar class="demo-app-calendar" :options="calendarOptions">
                <template v-slot:eventContent="arg">
                    <b>{{ arg.timeText }}</b>
                    <i>{{ arg.event.title }}</i>
                </template>
            </FullCalendar>
        </div>
        <div class="p-4 leading-6 bg-gradient-to-tr from-primary via-indigo-800 to-secondary text-white rounded-2xl lg:w-[28%]">
            <section class="pb-14">
                <h2 class="font-bold text-lg underline">Instrucciones</h2>
                <ul>
                    <li>
                        * Selecciona fechas y se te pedirá que crees un nuevo
                        evento.
                    </li>
                    <li>
                        * Arrastra, suelta y ajusta el tamaño de los eventos.
                    </li>
                    <li>* Click en el evento para eliminar.</li>
                </ul>
            </section>
            <section class="pb-14">
                <label class="font-bold underline">
                    <input
                        type="checkbox"
                        :checked="calendarOptions.weekends"
                        @change="handleWeekendsToggle"
                    />
                    Alternar fines de semana.
                </label>
            </section>
            <section class="pb-14">
                <h2 class="font-bold underline">Todos los Eventos ({{ currentEvents.length }})</h2>
                <ul>
                    <li v-for="event in currentEvents" :key="event.id">
                      *
                        <b>{{ event.startStr }}</b>
                        <i>{{ event.title }}</i>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</template>
