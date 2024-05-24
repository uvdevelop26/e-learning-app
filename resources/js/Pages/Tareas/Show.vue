<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import AnuncioTareas from "../../Components/AnuncioTareas.vue";
import Entregas from "../../Components/Entregas.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getFileType } from "../../data/handleFiles";
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
                        v-if="$page.props.userRole.role === 'docente'">
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
                         v-for="(entregaDev, index) in entregasDevoluciones" 
                         :key="entregaDev.id">
                         <div 
                            v-if="entregasDevoluciones.length" 
                            class="w-full p-4 rounded-xl border shadow bg-white group">
                            <h3 class="flex items-center flex-wrap">
                                <span class="text-lg font-bold mr-2">Devolución</span>
                                <span class="text-xs text-gray-500">{{ entregaDev.created_at }}</span>
                            </h3>
                            <div>
                                <ul class="text-sm">
                                    <li class="py-2">
                                        <span class="font-bold underline mr-2">Puntos Logrados:</span>
                                        {{ entregaDev.puntaje }}
                                    </li>
                                    <li class="py-2 flex flex-col">  
                                        <div v-for="devoluciones in entregaDev.devoluciones" :key="devoluciones.id" 
                                             class="flex flex-col">
                                            <span class="font-bold underline mr-2">Estado:</span>
                                            <span v-if="devoluciones.devuelto == 1">
                                                 Completado, &nbsp;
                                            </span>
                                            <span v-else="devoluciones.devuelto">
                                                Pendiente, &nbsp;
                                            </span>
                                            <span class="font-bold underline mr-2">Recomendaciones:</span>
                                            <div v-html="devoluciones.recomendacion"></div>
                                            <span class="font-bold underline mr-2">Material:</span>
                                            <div  
                                                v-for="materiales in devoluciones.materiales"
                                                :key="materiales.id">
                                                <a class="flex gap-1 cursor-pointer"  
                                                :href="route('materialeTareas.download', materiales.id)"
                                                target="_blank">
                                                    <span
                                                        class="text-xs lowercase font-bold text-primary hover:underline">
                                                        {{ materiales.nombre }}
                                                    </span>
                                                    <icon
                                                        :name="getFileType(materiales.nombre)"
                                                        class="w-4 h-4 fill-primary"
                                                    />
                                                </a>
                                            </div>
                                        </div>
                                        
                                    </li>
                                </ul>
                            </div>

                         </div>
                        
                    </template>
                    <!-- <div
                        class="w-full p-4 rounded-xl border shadow bg-white group"
                        v-if="$page.props.userRole.role.rol === 'alumno' ">
                        <h3 class="text-xl font-bold">Devolución</h3>
                        <div
                            v-for="entregaDev in entregasDevoluciones"
                            :key="entregaDev.id"
                            class="py-2">
                            <span class="font-bold underline">
                                Puntos logrados:
                            </span>
                            &nbsp;
                            <span>{{ entregaDev.puntaje }}</span>
                            <div
                                v-for="devoluciones in entregaDev.devoluciones"
                                :key="devoluciones.id">
                       
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
                          
                                
                             
                                <div
                                    v-for="materiales in devoluciones.materiales"
                                    :key="materiales.id">
                                    <div
                                        class="flex items-center h-12 w-full border rounded-xl overflow-hidden">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
