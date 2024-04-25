<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Comentarios from "../../Components/Comentarios.vue";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import Anuncio from "../../Components/Anuncio.vue";
import Unidades from "../../Components/Unidades.vue";
import TextArea from "../../Components/TextArea.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";


const props = defineProps({
    tarea: Array,
});
</script>
<template>
    <AppLayout>
        <Head title="tarea" />
        <template #header>
            <h2 class="font-semibold text-xl flex justify-between items-center">
                <span class="text-primary">
                    {{ tarea.titulo }}
                </span>
            </h2>
        </template>
        <!-- body -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <!-- header class info -->
            <div class="mt-6 flex flex-col gap-6 lg:flex-row">
                <div class="flex gap-6 items-center lg:flex-col lg:items-end">
                    <div
                        class="w-full p-4 rounded-xl border shadow bg-white group max-w-3xl">
                        
                        <p
                            class="leading-6"
                            v-html="tarea.instruccion"
                        ></p>
                        <div class="py-4 text-gray-500 border-b-2 text-sm text-end italic">
                            Plazo de Entrega
                            <span> {{ tarea.fecha_entrega }}</span> -
                            {{ tarea.hora_entrega }}
                        </div>
                        <Comentarios :comentarios="tarea.comentarios" :tarea_id="tarea.id" />
                    </div>                  
                </div>
            </div>
        </div>
    </AppLayout>
</template>
