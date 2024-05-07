<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import AnuncioTareas from "../../Components/AnuncioTareas.vue";
import Entregas from "../../Components/Entregas.vue";
import Modal from "../../Components/Modal.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    tareaYmateriales: Array,
    clase_id: Number,
    unidade_id: Number,
    errors: Object,
});

const entregas = ref(props.tareaYmateriales.entregas);

const updatetareas = () => {
    entregas.value = props.tareaYmateriales.entregas;
};
</script>
<template>
    <AppLayout>
        <Head title="tarea" />
        <template #header>
            <h2 class="font-semibold text-xl flex justify-between items-center">
                <span class="text-primary">
                    Actividad - {{ tareaYmateriales.titulo }}
                </span>
            </h2>
        </template>
        <!-- body -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl mx-auto">
            <!-- header class info -->
            <div
                class="mt-6 h-full flex flex-col gap-6 lg:flex-row md:items-start">
                <AnuncioTareas :tarea="tareaYmateriales" :errors="errors" />

                <div class="flex flex-col items-start gap-6 lg:w-2/5">
                    <Entregas
                        :tarea_id="tareaYmateriales.id"
                        :errors="errors"
                        :entregas="entregas"
                        @updatetareas="updatetareas"
                    />
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group">
                        <Link
                            :href="
                                route('clases.unidades.tareas.entregas.show', {
                                    clase: props.clase_id,
                                    unidad: props.unidade_id,
                                    tarea: tareaYmateriales.id,
                                })"
                            class="absolute top-0 left-0 right-0 bottom-0"
                            tabindex="-1">
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2">
                                <span
                                    class="block pb-3 group-hover:text-primary">
                                    Ver Entregas
                                </span>
                                <icon
                                    name="homework"
                                    class="w-6 h-6 mx-auto fill-black group-hover:fill-primary"
                                />
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
