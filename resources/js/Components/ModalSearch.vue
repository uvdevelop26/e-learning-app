<script setup>
import { computed, onMounted, onUnmounted, watch, ref } from "vue";
import TextInput from "./TextInput.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "2xl",
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    title: {
        type: String,
        default: String,
    },
    placeholder: {
        type: String,
        default: String,
    },

});

const body = ref(null)

defineExpose({
    body
});

const emit = defineEmits(["close"]);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = null;
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit("close");
    }
    // Emitir evento cuando el modal se cierra
    emit("modalClosed");

};

const closeOnEscape = (e) => {
    if (e.key === "Escape" && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        sm: "sm:max-w-sm",
        md: "sm:max-w-md",
        lg: "sm:max-w-lg",
        xl: "sm:max-w-xl",
        "2xl": "sm:max-w-2xl",
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
                scroll-region>
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div
                        v-show="show"
                        class="fixed inset-0 transform transition-all"
                        @click="close">
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </transition>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        v-show="show"
                        class="mb-6 p-4 py-4 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
                        :class="maxWidthClass">
                        <div class="py-4 border-b">
                            <h2 class="font-bold"> Seleccionar {{ title }}</h2>
                        </div>
                        <input 
                        type="search" 
                        class="w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm"
                        :placeholder="placeholder">
                        <div>
                            <slot name="result" />
                        </div>
                        <div class="py-4 flex justify-between">
                            <button class="inline-block px-2 py-1 text-red-500 hover:underline">Cancelar</button>
                            <button class="inline-block px-4 py-1 bg-primary text-white font-bold rounded-md hover:bg-secondary">Enviar</button>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
