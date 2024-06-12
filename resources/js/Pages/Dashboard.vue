<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Icon from "../Components/Icon.vue";
import UndrawTeacher from "../Components/UndrawTeacher.vue";
import Calendar from "../Components/Calendar.vue";
import { Head } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { getUserRoleArray } from "../data/handleAuthRoles";

const props = defineProps({
    clasesActivas: Array,
    user: Array,
    userTareas: Array,
});

const { props: pageProps } = usePage();
const userRoleArray = ref(getUserRoleArray(pageProps, props));


</script>

<template>
    <AppLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2
                class="font-semibold text-xl text-primary font-mono flex items-center gap-4">
                <div
                    class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
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
                    <div v-if="userRoleArray[0]">
                        <h3
                            class="text-2xl font-bold font-mono text-white lg:text-4xl">
                            Bienvenido {{ userRoleArray[0].persona.nombre }}
                            {{ userRoleArray[0].persona.apellido }}
                        </h3>
                        <p class="font-bold font-mono text-white italic">
                            {{ user.email}}
                        </p>
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
