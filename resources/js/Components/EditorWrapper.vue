<script setup>
import TextInput from "./TextInput.vue";
import Icon from "./Icon.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { ref, getCurrentInstance } from "vue";
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    title: String,
    clase: Array,
    errors: Object,
});

const open = ref(false);
const editorRef = ref(null);
const { auth } = usePage().props;
const { emit } = getCurrentInstance();

const form = useForm({
    titulo: "",
    descripcion: "",
    user_id: auth.user.id,
    anunciable_id: props.clase.id,
    anunciable_type: "",
});

const options = {
    placeholder: "Escribe el contenido...",
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
        ],
    },
};

const cancelOperation = () => {
    setTimeout(() => {
        if (editorRef.value) {
            const quill = editorRef.value.getQuill();
            if (quill) {
                quill.setText("");
            }
        }
        form.titulo = "";
        open.value = false
    }, 300);
};

const submit = () => {
    form.post(route("anuncios.store"), {
        preserveScroll: true,
        onSuccess: () => {
            cancelOperation();
            emit('updateanuncios');
        },
    });
};
</script>
<template>
    <div>
        <div
            class="bg-white w-full p-4 rounded-xl border shadow group"
            @click="open = true">
            <!-- label header -->
            <transition name="show-label">
                <label
                    class="block py-2 text-sm italic cursor-pointer group-hover:text-primary"
                    v-if="!open">
                    {{ title }}
                </label>
            </transition>
            <!-- form -->
            <transition name="show-form">
                <div v-if="open">
                    <form @submit.prevent="submit">
                        <text-input
                            class="pb-3 pr-6 w-full"
                            id="titulo"
                            placeholder="Ingresa el título del Anuncio"
                            v-model="form.titulo"
                            :error="errors.titulo"
                        />
                        <QuillEditor
                            theme="snow"
                            :options="options"
                            style="height: 120px"
                            ref="editorRef"
                            v-model:content="form.descripcion"
                        />
                        <div class="py-2 border-t-3">
                            <label
                                for="imagen"
                                class="flex justify-center items-center w-11 h-11 rounded-full cursor-pointer bg-indigo-100">
                                <icon
                                    name="upload"
                                    class="w-4 h-4 fill-primary"
                                />
                                <input
                                    type="file"
                                    id="imagen"
                                    class="opacity-0 absolute -z-10"
                                />
                            </label>
                        </div>
                        <!-- options -->
                        <div class="pt-4 border-t-2 flex justify-between">
                            <button
                                class="inline-block px-8 py-2 text-red-500 hover:underline"
                                @click="cancelOperation()">
                                Cancelar
                            </button>
                            <button
                                class="inline-block px-8 py-2 bg-primary rounded-md text-white font-bold hover:bg-orange-400"
                                type="submit">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </transition>
        </div>
    </div>
</template>
<style scoped>
/* transition show form */
.show-form-enter-from {
    max-height: 0px;
    overflow: hidden;
}

.show-form-enter-to {
    max-height: 1000px;
    overflow: visible;
}

.show-form-enter-active,
.show-form-leave-active {
    transition: all 600ms ease;
}

.show-form-leave-from {
    max-height: 1000px;
    overflow: visible;
}

.show-form-leave-to {
    max-height: 0px;
    overflow: hidden;
}

/* transition show form */
.show-label-enter-from {
    opacity: 0;
}

.show-label-enter-to {
    opacity: 1;
}

.show-label-enter-active,
.show-label-leave-active {
    transition: all 200ms ease;
}

.show-label-leave-from {
    opacity: 1;
}

.show-label-leave-to {
    opacity: 0;
}
</style>
