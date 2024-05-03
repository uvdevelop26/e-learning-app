<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Comentarios from "../../Components/Comentarios.vue";
import AnuncioTareas from "../../Components/AnuncioTareas.vue";
import Entregas from "../../Components/Entregas.vue";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import Unidades from "../../Components/Unidades.vue";
import TextArea from "../../Components/TextArea.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    tareaYmateriales: Array,
    errors: Object,
});

const entregas = ref(props.tareaYmateriales.entregas);
const entregasUser = ref(null);
const { auth } = usePage().props;

const updatetareas = ()=>{
    entregas.value = props.tareaYmateriales.entregas
}

/* 

onMounted(filterTareaUser); */


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
                <Entregas
                    :tarea_id="tareaYmateriales.id"
                    :errors="errors"
                    :entregas="entregas"
                    @updatetareas="updatetareas"
                />
            </div>
        </div>
    </AppLayout>
</template>
