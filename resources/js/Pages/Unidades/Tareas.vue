<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import EditorTareasWrapper from "../../Components/EditorTareasWrapper.vue";
import Icon from "../../Components/Icon.vue";
import { Link, Head } from "@inertiajs/vue3";
import AnuncioTareas from "../../Components/AnuncioTareas.vue";

const props = defineProps({
    tareas: Array,
    unidade_id: Number,
    errors: Object,
});
</script>
<template>
    <AppLayout>
        <Head title="tareas" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center"
            >
                <span> Tareas de la Unidad </span>
            </h2>
        </template>

        <div class="py-9 px-4 lg:px-8 max-w-7xl">
            <!-- content -->
            <div class="mt-6 flex flex-col gap-6 lg:flex-row">
                <!-- options -->
                <div class="flex gap-6 items-center lg:flex-col lg:items-start">
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group"
                    >
                        <Link
                            class="absolute top-0 left-0 right-0 bottom-0 cursor-pointer"
                            tabindex="-1"
                        >
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2"
                            >
                                <span
                                    class="block pb-3 group-hover:text-primary"
                                >
                                    Tareas
                                </span>
                                <icon
                                    name="homework"
                                    class="w-6 h-6 mx-auto fill-black group-hover:fill-primary"
                                />
                            </div>
                        </Link>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-6">
                    <editor-tareas-wrapper
                        title="Agregar tarea..."
                        :unidade_id="unidade_id"
                        :errors="errors"
                    />
                    <anuncio-tareas v-for="tarea in tareas" :key="tarea.id" :tarea="tarea" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
