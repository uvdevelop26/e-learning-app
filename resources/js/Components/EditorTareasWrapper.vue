<script setup>
import { ref } from "vue";
import TextInput from "./TextInput.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import Icon from "./Icon.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    title: String,
    unidade_id: Number,
    errors: Object,
});

const open = ref(false);
const editorRef = ref(null);
const form = useForm({
    titulo: "",
    instruccion: "",
    fecha_entrega: "",
    hora_entrega: "",
    puntos: "",
    unidade_id: props.unidade_id,
});

/* quill editor options */
const options = {
    placeholder: "Escribe el contenido...",
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            [{ header: [2, 3, 4, 5, 6, false] }],
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
        open.value = false;
        form.titulo = "";
        props.errors.titulo = "";
        props.errors.fecha_entrega = "";
        form.puntos = "";
        (form.fecha_entrega = ""), (form.hora_entrega = "");

        /*     
        uploadedFiles.value = [];
        form.url = []; */
    }, 300);
};

const submit = () => {
    form.post(route("tareas.store"), {
        preserveScroll: true,
        /* forceFormData: true, */
        onSuccess: () => {
            /*  emit("newpost"); */
            cancelOperation();
        },
    });
};
</script>
<template>
    <div
        class="bg-white w-full p-4 rounded-xl border shadow group"
        @click="open = true">
        <transition name="show-label">
            <label
                class="block py-2 text-sm italic cursor-pointer group-hover:text-primary"
                v-if="!open">
                {{ title }}
            </label>
        </transition>
        <transition name="show-form">
            <div v-if="open">
                <form @submit.prevent="submit">
                    <text-input
                        class="pb-3 w-full"
                        id="titulo"
                        placeholder="Ingresa el título del Anuncio"
                        label="Título"
                        min="0"
                        max="100"
                        v-model="form.titulo"
                        :error="errors.titulo"
                    />
                    <QuillEditor
                        theme="snow"
                        :options="options"
                        style="height: 120px"
                        ref="editorRef"
                        contentType="html"
                        v-model:content="form.instruccion"
                        :error="errors.instruccion"
                    />
                    <div class="py-2 flex gap-3 items-center">
                        <label
                            for="upload"
                            class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100">
                            <icon name="upload" class="w-4 h-4 fill-primary" />
                            <input
                                type="file"
                                id="upload"
                                class="opacity-0 absolute -z-10"
                                accept=".pdf, .jpeg, .jpg, .png, .gif, .doc, .docx, .xls, .xlsx, .ppt, .pptx"
                                @change="getFileData($event.target)"
                            />
                        </label>
                        <button
                            type="button"
                            class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100"
                        >
                            <icon name="link" class="w-4 h-4 fill-primary" />
                        </button>
                    </div>
                    <div
                        class="py-2 flex flex-wrap gap-3 items-center justify-between"
                    >
                        <text-input
                            class="pb-3 w-full lg:w-[30%]"
                            id="puntaje"
                            type="number"
                            placeholder="Puntos Asignados"
                            label="Puntos"
                            v-model="form.puntos"
                            :error="errors.puntos"
                        />
                        <text-input
                            class="pb-3 w-full lg:w-[30%]"
                            id="fecha_entrega"
                            type="date"
                            label="Fecha Entrega"
                            v-model="form.fecha_entrega"
                            :error="errors.fecha_entrega"
                        />
                        <text-input
                            class="pb-3 w-full lg:w-[30%]"
                            id="hora_entrega"
                            type="time"
                            label="Hora Entrega"
                            v-model="form.hora_entrega"
                            :error="errors.hora_entrega"
                        />
                    </div>
                    <div class="pt-4 border-t-2 flex justify-between">
                        <button
                            class="inline-block px-8 py-2 text-red-500 hover:underline"
                            @click="cancelOperation()"
                            type="button"
                        >
                            Cancelar
                        </button>
                        <button
                            class="px-6 py-3 rounded text-white bg-primary text-sm leading-4 font-bold whitespace-nowrap"
                            type="submit"
                        >
                            <!--   :class="{
                                    'bg-gray-400 focus:bg-gray-400':
                                        form.processing,
                                    'bg-primary hover:bg-orange-400':
                                        !form.processing,
                                }"
                                :disabled="form.processing" -->
                            Agregar Tarea
                        </button>
                    </div>
                </form>
            </div>
        </transition>
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
