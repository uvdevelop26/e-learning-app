<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "../Components/Card.vue";
import { Head, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const props = defineProps({
    clasesActivas: Array,
});

const showClases = ref(null);

/* 
const getUserRole = async () => {
    try {
        const data = await fetch("http://127.0.0.1:8000/dashboard/users");
        if (!data.ok) {
            throw Error("data not available");
        }
        const response = data.json();
        return response;
    } catch (error) {
        console.log(error.message);
    }
};


onMounted(async () => {
    try {
        const data = await getUserRole();
        showClases.value = data;
    } catch (error) {
        console.error("Error fetching user role:", error);
    }
}); */
</script>

<template>
    <AppLayout>
        <Head title="Dashboard" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 flex items-center">
                <span class="mr-3 text-primary">Dashboard</span>
            </h2>
        </template>
        <!-- body -->
        <div class="py-12 px-4 bg-gray-100 lg:px-8 max-w-7xl">
            <div class="w-full overflow-x-auto">
                <div
                    class="py-4 px-4 flex flex-wrap items-center justify-center md:justify-start gap-6">
                    <!-- <template v-for="clase in showClases" :key="clase.id">
                        <Card>
                            <template #cardHeader>
                                <Link
                                    class="inline-block pb-4 w-full group"
                                    :href="route('clases.show', clase.id)">
                                    <span
                                        class="block text-3xl text-white font-bold capitalize group-hover:underline">
                                         {{ clase.materia.nombre }}
                                    </span>
                                    <span
                                        class="block text-md font-md text-white">
                                        {{ clase.codigo }}
                                    </span>
                                </Link>
                            </template>
                            <template #cardFooter>
                                <div
                                    class="h-full flex px-4 items-center justify-between">
                                    <span
                                        class="text-xs font-bold text-primary italic capitalize">
                                         {{ clase.estado.estado }}
                                    </span>
                                    <span class="text-xs text-gray-400 italic">
                                         {{ clase.alumnos.length }}
                                        Participante/s
                                    </span>
                                </div>
                            </template>
                        </Card>
                    </template> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
