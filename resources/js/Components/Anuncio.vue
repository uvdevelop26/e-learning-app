<script setup>
import Icon from "./Icon.vue";
import Dropdown from "./Dropdown.vue";
import Comentarios from "./Comentarios.vue"
import { ref, getCurrentInstance } from "vue";

const props = defineProps({
    data: Object,
});

const open = ref(false);
const { emit } = getCurrentInstance();

const updatecomments = ()=>{
    emit('updatecomments');

}

</script>
<template>
    <div class="w-full p-4 rounded-xl border shadow bg-white group">
        <!-- header data -->
        <div class="flex items-center justify-between gap-4">
            <div class="w-full">
                <h3 class="py-1 font-bold uppercase">
                    {{ data.titulo }}
                </h3>
                <p class="text-sm">{{ data.descripcion }}</p>
            </div>
            <dropdown class="self-start">
                <template #trigger>
                    <div class="text-right">
                        <button
                            :open="open"
                            class="flex pb-2 justify-center items-center h-7 w-7 rounded-full hover:bg-indigo-100 focus:bg-indigo-100">
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
                            class="inline-block text-left py-2 font-bold w-full h-full text-primary hover:underline">
                            Editar
                        </button>
                        <button
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button">
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
        <!-- comments sectios -->
        <Comentarios 
            class="mt-3 border-t" 
            :comentarios="data.comentarios"
            :anuncio_id="data.id"
            @updatecomments="updatecomments"
        />
    </div>
</template>
