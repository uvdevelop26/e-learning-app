<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    title: String,
});

const open = ref(false);

const clases = computed(() => {
    return open.value ? "bg-white" : "bg-white hover:shadow-md cursor-pointer";
});

const cancelOperation = () => {
    setTimeout(() => {
        open.value = false
    }, 300);
};
</script>
<template>
    <div
        class="w-full p-4 rounded-xl border shadow group"
        :class="clases"
        @click="open = true"
    >
        <label
            class="block py-2 text-sm italic cursor-pointer group-hover:text-primary"
            v-if="!open"
        >
            {{ title }}
        </label>
        <div v-if="open">
            <slot name="content" />
            <div class="py-2 border-t-2 flex justify-between">
                <button
                    class="inline-block px-8 py-2 text-red-500 hover:underline"
                    @click="cancelOperation"
                    >
                    Cancelar
                </button>
                <button
                    class="inline-block px-8 py-2 bg-primary rounded-md text-white font-bold hover:bg-orange-400"
                >
                    Enviar
                </button>
            </div>
        </div>
    </div>
</template>
