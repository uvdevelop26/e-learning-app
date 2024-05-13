<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "../Components/Card.vue";
import { Head, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import UndrawTeacher from "../Components/UndrawTeacher.vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";

const props = defineProps({
    clasesActivas: Array,
    user: Array
});

const calendarOptions = {
    plugins: [dayGridPlugin],
    initialView: "dayGridMonth",
    weekends: true,
    events: [{ title: "Meeting", start: new Date() }],
};




</script>

<template>
    <AppLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2 class="font-semibold text-xl flex justify-between items-center">
                <span class="mr-3 text-primary">Dashboard</span>
            </h2>
        </template>
        <!-- body -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="w-full flex flex-col gap-6 lg:flex-row lg:gap-3">
                <!-- welcome header -->
                <header
                    class="h-56 w-full p-2 flex flex-col items-center bg-gradient-to-tr from-primary via-secondary to-secondary text-center rounded-2xl overflow-hidden md:h-72 lg:h-80 lg:flex-row lg:justify-center">
                    <div v-if="user.alumnos.length !== 0">
                        <h1 class="text-2xl font-bold text-white lg:text-4xl">
                           Bienvenido {{ user.alumnos[0].persona.nombre }}
                        </h1>
                        <p class="font-bold text-white lg:text-xl italic">
                            Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
                            amet.
                        </p>
                    </div>
                    <div v-if="user.docentes.length !== 0">
                        <h1 class="text-2xl font-bold text-white lg:text-4xl">
                           Bienvenido Prof. {{ user.docentes[0].persona.nombre }}
                        </h1>
                        <p class="font-bold text-white lg:text-xl italic">
                            Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
                            amet.
                        </p>
                    </div>
                    <UndrawTeacher class="w-40 h-32 lg:w-56 lg:h-60" />
                </header>
            </div>
            <!-- calendar -->
            <div class="mt-6">
                <FullCalendar
                    class="demo-app-calendar"
                    :options="calendarOptions">
                    <template v-slot:eventContent="arg">
                        <b>{{ arg.timeText }}</b>
                        <i>{{ arg.event.title }}</i>
                    </template>
                </FullCalendar>
            </div>
        </div>
    </AppLayout>
</template>
