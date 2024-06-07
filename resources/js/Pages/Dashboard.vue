<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Icon from "../Components/Icon.vue"
import { Head, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import UndrawTeacher from "../Components/UndrawTeacher.vue";
import Calendar from "../Components/Calendar.vue"

const props = defineProps({
    clasesActivas: Array,
    user: Array,
    userTareas: Array
});

</script>

<template>
    <AppLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2 class="font-semibold text-xl text-primary font-mono flex items-center gap-4">
                <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                    <Icon name="dashboard" class="w-3 h-3 fill-white" />
                </div> 
                Dashboard
            </h2>
        </template>
        <!-- body -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="w-full flex flex-col gap-6 lg:flex-row lg:gap-3">
                <!-- welcome header -->
                <header
                    class="h-56 w-full p-2 flex flex-col items-center bg-gradient-to-tr from-primary via-secondary to-secondary text-center rounded-2xl overflow-hidden md:h-72 lg:h-80 lg:flex-row lg:justify-center">
                    <div v-if="user.alumnos.length !== 0">
                        <h3 class="text-2xl font-bold font-mono text-white lg:text-4xl">
                            Bienvenido {{ user.alumnos[0].persona.nombre }}
                        </h3>
                    </div>
                    <div v-if="user.docentes.length !== 0">
                        <h3 class="text-2xl font-bold font-mono text-white lg:text-4xl">
                            Bienvenido Prof.
                            {{ user.docentes[0].persona.nombre }}
                        </h3>
                    </div>
                    <div v-if="user.administradores.length !== 0">
                        <h3 class="text-2xl font-bold font-mono text-white lg:text-4xl">
                            Bienvenido Admin.
                            {{ user.administradores[0].persona.nombre }}
                        </h3>
                    </div>
                    <UndrawTeacher class="w-40 h-32 lg:w-56 lg:h-60" />
                </header>
            </div>
            <!-- calendar -->
            <div class="mt-6">
                <Calendar :tareas="userTareas" />
            </div>
        </div>
    </AppLayout>
</template>
