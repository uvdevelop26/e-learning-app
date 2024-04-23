<script setup>
import { format } from "date-fns";
import { ref, onMounted } from "vue";

const props = defineProps({
    tarea: Object,
});

const formattedDate = ref(
    format(new Date(props.tarea.created_at), "dd-MM-yyyy")
);
</script>
<template>
    <div class="w-full p-4 rounded-xl border shadow bg-white group">
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
                <div
                    class="text-sm leading-6"
                    v-html="tarea.instruccion"
                    ref="dataDescripcion"
                ></div>
            </div>
        </div>
    </div>
</template>
