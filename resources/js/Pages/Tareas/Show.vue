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
const entregasDevoluciones = ref([]);
const { auth } = usePage().props;

const updatetareas = () => {
    entregas.value = props.tareaYmateriales.entregas;
};

const getFileType = (filename) => {
    if (filename.endsWith(".pdf")) {
        return "pdf";
    } else if (
        filename.endsWith(".jpeg") ||
        filename.endsWith(".jpg") ||
        filename.endsWith(".png") ||
        filename.endsWith(".gif")
    ) {
        return "picture";
    } else if (
        filename.endsWith(".doc") ||
        filename.endsWith(".docx") ||
        filename.endsWith(".xls") ||
        filename.endsWith(".xlsx") ||
        filename.endsWith(".ppt") ||
        filename.endsWith(".pptx")
    ) {
        return "office";
    }
};

const filterDevoluciones = () => {
    entregasDevoluciones.value = entregas.value.filter(
        (item) => item.user_id == auth.user.id
    );
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
                class="mt-6 h-full flex flex-col gap-6 lg:flex-row md:items-start"
            >
                <!-- anuncio tarea -->
                <AnuncioTareas :tarea="tareaYmateriales" :errors="errors" />

                <!-- entrega component and show entregas link -->
                <div class="flex flex-col items-start gap-6 lg:w-2/5">
                    <Entregas
                        :tarea_id="tareaYmateriales.id"
                        :errors="errors"
                        :entregas="entregas"
                        @updatetareas="updatetareas"
                        v-if="$page.props.userRole.role.rol === 'alumno'"
                    />
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group"
                        v-if="$page.props.userRole.role.rol == 'docente'"
                    >
                        <Link
                            :href="
                                route('clases.unidades.tareas.entregas.show', {
                                    clase: props.clase_id,
                                    unidad: props.unidade_id,
                                    tarea: tareaYmateriales.id,
                                })
                            "
                            class="absolute top-0 left-0 right-0 bottom-0"
                            tabindex="-1"
                        >
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2"
                            >
                                <span
                                    class="block pb-3 group-hover:text-primary"
                                >
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
                    <div
                        class="w-full p-4 rounded-xl border shadow bg-white group"
                        v-if="$page.props.userRole.role.rol === 'alumno' "
                    >
                        <h3 class="text-xl font-bold">Devolución</h3>
                        <div
                            v-for="entregaDev in entregasDevoluciones"
                            :key="entregaDev.id"
                            class="py-2"
                        >
                            <span class="font-bold underline">
                                Puntos logrados:
                            </span>
                            &nbsp;
                            <span>{{ entregaDev.puntaje }}</span>
                            <div
                                v-for="devoluciones in entregaDev.devoluciones"
                                :key="devoluciones.id"
                            >
                                <!-- info -->
                                <div>
                                    <span class="font-bold underline">
                                        Estado:
                                    </span>
                                    &nbsp;
                                    <span v-if="devoluciones.devuelto == 1">
                                        Completado
                                    </span>
                                    <span v-else="devoluciones.devuelto">
                                        Pendiente
                                    </span>
                                </div>
                                <!-- recomendation -->
                                <div
                                    v-html="devoluciones.recomendacion"
                                    class="py-2"
                                ></div>
                                <!-- material -->
                                <div
                                    v-for="materiales in devoluciones.materiales"
                                    :key="materiales.id"
                                >
                                    <div
                                        class="flex items-center h-12 w-full border rounded-xl overflow-hidden"
                                    >
                                        <div
                                            class="flex h-full w-full overflow-hidden px-3 justify-between items-center gap-2 border-r"
                                            
                                        >
                                            <span
                                                class="text-xs lowercase font-bold text-primary"
                                            >
                                                {{ materiales.nombre }}
                                            </span>
                                            <icon
                                                :name="
                                                    getFileType(materiales.nombre)
                                                "
                                                class="w-4 h-4 fill-primary"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
