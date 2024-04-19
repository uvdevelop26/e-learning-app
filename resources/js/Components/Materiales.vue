<script setup>
import { ref, onMounted } from "vue";
import Icon from "./Icon.vue";

const props = defineProps({
    materiales: Array,
});

const materialesNew = ref(props.materiales);




onMounted(() => {
    materialesNew.value.sort((a, b) => {
        // Si 'a' es una foto y 'b' no lo es, colocamos 'a' antes que 'b'
        if (
            (a.nombre.endsWith(".jpeg") ||
                a.nombre.endsWith(".jpg") ||
                a.nombre.endsWith(".png") ||
                a.nombre.endsWith(".gif")) &&
            !(
                b.nombre.endsWith(".jpeg") ||
                b.nombre.endsWith(".jpg") ||
                b.nombre.endsWith(".png") ||
                b.nombre.endsWith(".gif")
            )
        ) {
            return -1;
        }
        // Si 'b' es una foto y 'a' no lo es, colocamos 'b' antes que 'a'
        else if (
            !(
                a.nombre.endsWith(".jpeg") ||
                a.nombre.endsWith(".jpg") ||
                a.nombre.endsWith(".png") ||
                a.nombre.endsWith(".gif")
            ) &&
            (b.nombre.endsWith(".jpeg") ||
                b.nombre.endsWith(".jpg") ||
                b.nombre.endsWith(".png") ||
                b.nombre.endsWith(".gif"))
        ) {
            return 1;
        }
        // En todos los demás casos, mantenemos el orden original
        else {
            return 0;
        }
    });
});
</script>
<template>
    <!-- <div class="pt-4 flex flex-col gap-4">
        <div v-for="materiale in materialesNew" :key="materiale.id">
        
            <figure
                v-if="isImage(materiale)"
                class="h-48 rounded-2xl border overflow-hidden md:h-64 lg:h-[28.5rem]">
                <img
                    :src="imageUrl(materiale.url)"
                    :alt="materiale.nombre"
                    class="object-cover w-full h-full"
                />
            </figure>
        
            <div
                v-else-if="isPdf(materiale)"
                class="h-14  border rounded-2xl overflow-hidden">
                <a href="" class="w-full h-full px-2 flex items-center gap-2 hover:bg-gray-100">
                    <Icon name="pdf" class="w-4 h-4" />
                    <span class="font-bold text-sm hover:underline">{{ materiale.nombre }}</span>   
                </a>
            </div>
        
            <div
                v-else-if="isOffice(materiale)"
                class="h-14  border rounded-2xl overflow-hidden">
                <a href="" class="w-full h-full px-2 flex items-center gap-2 group hover:bg-gray-100">
                    <Icon name="office" class="w-4 h-4" />
                    <span class="font-bold text-sm hover:underline">{{ materiale.nombre }}</span>  
                </a>
            </div>
        </div>
    </div> -->
</template>
