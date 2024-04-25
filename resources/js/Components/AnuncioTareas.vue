<script setup>
import { format } from "date-fns";
import Dropdown from "./Dropdown.vue";
import Comentarios from "./Comentarios.vue";
import Icon from "./Icon.vue";
import { ref, onMounted, getCurrentInstance } from "vue";

const props = defineProps({
    tarea: Object,
});

const { emit } = getCurrentInstance();
const formattedDate = ref(
    format(new Date(props.tarea.created_at), "dd-MM-yyyy")
);
const formattedEntregaDate = ref(
    format(new Date(props.tarea.fecha_entrega), "dd-MM-yyyy")
);

const updateanuncios = () => {
    emit("updateanuncios");
};
</script>
<template>
    <div class="w-full p-4 rounded-xl border shadow bg-white group">
        <!-- text info and options -->
        <div class="flex items-center justify-between gap-4">
            <div class="w-full">
                <div class="flex py-4 justify-between">
                    <h3 class="text-xl font-bold">
                        {{ tarea.titulo }}
                    </h3>
                    <div class="text-xs text-gray-400 italic">
                        {{ formattedDate }}
                    </div>
                </div>
                <div class="flex flex-col gap-3 pb-2">
                    <span class="inline-block text-xs">Total Puntos: {{ tarea.puntos }}</span>
                    <span class="inline-block text-xs text-red-500">Fecha de Entrega: {{ formattedEntregaDate }}</span>
                    <span></span>
                </div>
                <div
                    class="text-sm leading-6"
                    v-html="tarea.instruccion"
                    ref="dataDescripcion"
                ></div>
            </div>
            <dropdown class="self-start">
                <template #trigger>
                    <div class="text-right">
                        <button
                            :open="open"
                            class="flex pb-2 justify-center items-center h-7 w-7 rounded-full hover:bg-indigo-100 focus:bg-indigo-100"
                        >
                            <icon
                                name="trigger"
                                class="inline-block w-[0.18rem] h-[0.18rem] fill-primary"
                            />
                        </button>
                    </div>
                </template>
                <template #content>
                    <div class="p-3">
                        <button
                            class="inline-block text-left py-2 font-bold w-full h-full text-primary hover:underline"
                            @click="setOpenModal()"
                        >
                            Editar
                        </button>
                        <button
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button"
                            @click="deleteAnuncio()"
                        >
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
        <!-- materiales section -->
        <!-- <div class="pt-4 flex flex-col gap-4" v-if="data.materiales">
            <div v-for="materiale in data.materiales" :key="materiale.id">
            
                <figure
                    v-if="getFileType(materiale.nombre) == 'picture'"
                    class="h-48 rounded-2xl border overflow-hidden md:h-64 lg:h-[28.5rem]">
                    <img
                        :src="imageUrl(materiale.url)"
                        :alt="materiale.nombre"
                        class="object-cover w-full h-full"
                    />
                </figure>
              
                <div
                    class="h-14 border rounded-2xl overflow-hidden hover:bg-gray-100"
                    v-else-if="getFileType(materiale.nombre) == 'pdf'">
                    <a
                        :href="route('materiales.download', materiale.id)"
                        target="_blank"
                        tabindex="-1"
                        class="w-full h-full px-2 flex items-center gap-2 hover:underline">
                        <Icon name="pdf" class="w-4 h-4 fill-primary" />
                        <span class="font-bold text-sm text-primary">
                            {{ materiale.nombre }}
                        </span>
                    </a>
                </div>
       
                <div
                    v-else-if="getFileType(materiale.nombre) == 'office'"
                    class="h-14 border rounded-2xl overflow-hidden hover:bg-gray-100">
                    <a
                        :href="route('materiales.download', materiale.id)"
                        target="_blank"
                        tabindex="-1"
                        class="w-full h-full px-2 flex items-center gap-2 hover:underline">
                        <Icon name="office" class="w-4 h-4 fill-primary" />
                        <span class="font-bold text-sm text-primary">{{
                            materiale.nombre
                        }}</span>
                    </a>
                </div>
            </div>
        </div> -->
        <Comentarios
            class="mt-3 border-t"
            :comentarios="tarea.comentarios"
            :tarea_id="tarea.id"
            @updateanuncios="updateanuncios"
        />
    </div>
</template>
