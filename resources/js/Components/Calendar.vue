<script setup>
import { onMounted, ref } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

const props = defineProps({
    tareas: Array,
});

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

/* const handleDateSelect = (selectInfo) => {
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
}; */

/* const handleEventClick = (clickInfo) => {
    if (
        confirm(
            `Está seguro que desea eliminar el evento '${clickInfo.event.title}'`
        )
    ) {
        clickInfo.event.remove();
    }
}; */

const handleEvents = (events) => {
    currentEvents.value = events;
};

const convertirTareasAEventos = () => {
    let eventos = [];
    const tareas = props.tareas;

    if (tareas.length !== 0) {
        tareas.forEach((tarea) => {
            const unidades = tarea.unidades;
            unidades.forEach((unidad) => {
                unidad.tareas.forEach((item) => {
                    if (item.length !== 0) {
                        const fechaInicio = item.fecha_entrega + "T" + (item.hora_entrega || "00:00");
                        eventos.push({
                            id: item.id,
                            title: item.titulo,
                            start: fechaInicio,
                        });
                    } else {
                        eventos = null;
                    }
                });
            });
        });
    }else{
        eventos = null
    }

    return eventos;
};

const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    initialView: "dayGridMonth",
    initialEvents: INITIAL_EVENTS,
    editable: false,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    /* select: handleDateSelect, */
    /* eventClick: handleEventClick, */
    eventsSet: handleEvents,
    events: convertirTareasAEventos(),
});

const handleWeekendsToggle = () => {
    calendarOptions.value.weekends = !calendarOptions.value.weekends;
};

//onMounted(convertirTareasAEventos);
</script>
<template>
    <div
        class="flex flex-col gap-4 min-h-full text-sm lg:flex-row-reverse lg:text-base"
    >
        <div class="p-8 lg:flex-grow bg-white rounded-2xl shadow-md">
            <FullCalendar class="demo-app-calendar" :options="calendarOptions">
                <template v-slot:eventContent="arg">
                    <span class="text-xs italic">{{ arg.event.title }}</span>
                </template>
            </FullCalendar>
        </div>
        <div
            class="px-4 pt-14 leading-6 bg-gradient-to-tr from-primary via-secondary to-secondary text-white rounded-2xl lg:w-[28%]"
        >
            <section class="pb-14 text-sm">
                <h2 class="font-bold underline">Instrucciones</h2>
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
            <section class="pb-14 text-sm">
                <label class="font-bold underline">
                    <input
                        type="checkbox"
                        :checked="calendarOptions.weekends"
                        @change="handleWeekendsToggle"
                    />
                    Alternar fines de semana.
                </label>
            </section>
            <section class="pb-14 text-sm">
                <h2 class="font-bold underline">
                    Todos los Eventos ({{ currentEvents.length }})
                </h2>
                <ul class="list-disc list-inside">
                    <li v-for="event in currentEvents" :key="event.id">
                        <span class="inline-block mr-2">{{ event.title }}</span>
                        <span class="inline-block">{{ event.startStr }}</span>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</template>
