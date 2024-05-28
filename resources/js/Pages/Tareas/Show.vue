<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import AnuncioTareas from "../../Components/AnuncioTareas.vue";
import Entregas from "../../Components/Entregas.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getFileType } from "../../data/handleFiles";
import { format } from "date-fns";

const props = defineProps({
    tareaYmateriales: Array,
    clase_id: Number,
    unidade_id: Number,
    errors: Object,
});

const entregas = ref(props.tareaYmateriales.entregas);
const devoluciones = ref([]);
const { auth } = usePage().props;

const updatetareas = () => {
    entregas.value = props.tareaYmateriales.entregas;
};

const filterDevoluciones = () => {
    devoluciones.value = entregas.value
        .filter((item) => item.user_id === auth.user.id)
        .flatMap((item) => item.devoluciones);
};

onMounted(filterDevoluciones);
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
                <!-- anuncio tarea -->
                <AnuncioTareas :tarea="tareaYmateriales" :errors="errors" />

                <!-- entrega component and show entregas link -->
                <div class="flex flex-col items-start gap-6 lg:w-2/5">
                    <Entregas
                        :tarea_id="tareaYmateriales.id"
                        :errors="errors"
                        :entregas="entregas"
                        @updatetareas="updatetareas"
                        v-if="$page.props.userRole.role === 'alumno'"
                    />
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group"
                        v-if="$page.props.userRole.role == 'docente'">
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
                    <!-- devoluciones -->
                    <template
                        v-for="(devolucione, index) in devoluciones"
                        :key="devolucione.id">
                        <div
                            v-if="devoluciones.length"
                            class="w-full p-4 rounded-xl border shadow bg-white group">
                            <h3 class="flex items-center flex-wrap">
                                <span class="text-lg font-bold mr-2">Devolución</span>
                                <span class="text-xs text-gray-500">
                                    {{
                                        format(
                                            new Date(devolucione.created_at),
                                            "dd-MM-yyyy"
                                        )
                                    }}
                                </span>
                            </h3>
                            <ul class="text-sm">
                                <li class="py-1">
                                    <span class="font-bold underline mr-2">Puntos Logrados:</span>
                                    {{ devolucione.puntos }}
                                </li>
                                <li class="py-1">
                                    <span class="font-bold underline mr-2">Estado:</span>
                                    <span v-if="devolucione.devuelto == 1">
                                        Completado
                                    </span>
                                    <span v-else="devolucione.devuelto">
                                        Pendiente
                                    </span>
                                </li>
                                <li class="py-1">
                                    <span class="font-bold underline mr-2">Recomendaciones:</span>
                                    <div
                                        v-html="devolucione.recomendacion"></div>
                                </li>
                                <li class="py-1">
                                    <span class="font-bold underline mr-2">Material:</span>
                                    <div
                                        v-for="materiales in devolucione.materiales"
                                        :key="materiales.id">
                                        <a
                                            class="flex gap-1 cursor-pointer"
                                            :href="route('materialeTareas.download', materiales.id)"
                                            target="_blank">
                                            <span
                                                class="text-xs lowercase font-bold text-primary hover:underline">
                                                {{ materiales.nombre }}
                                            </span>
                                            <icon :name="getFileType(materiales.nombre)"
                                                class="w-4 h-4 fill-primary"
                                            />
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
