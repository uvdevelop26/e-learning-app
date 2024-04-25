<script setup>
import { ref, getCurrentInstance } from "vue";
import Dropdown from "./Dropdown.vue";
import TextInput from "./TextInput.vue";
import TextArea from "./TextArea.vue";
import Modal from "./Modal.vue";
import Icon from "./Icon.vue";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { format } from "date-fns";
import { router } from "@inertiajs/vue3";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const props = defineProps({
    data: Object,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: "",
    titulo: "",
    instruccion: "",
    fecha_entrega: "",
    hora_entrega: "",
    puntos: "",
    unidade_id: "",
});

const open = ref(false);
const openModal = ref(false);
const formattedDate = ref(
    format(new Date(props.data.fecha_entrega), "dd-MM-yyyy")
);
const { emit } = getCurrentInstance();

const options = {
    placeholder: "Escribe el contenido...",
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            [{ header: [2, 3, 4, 5, 6, false] }],
        ],
    },
};

const setOpenModal = () => {
    form.id = props.data.id;
    form.titulo = props.data.titulo;
    form.instruccion = props.data.instruccion;
    form.fecha_entrega = props.data.fecha_entrega;
    form.hora_entrega = props.data.hora_entrega;
    form.puntos = props.data.puntos;
    form.unidade_id = props.data.unidade_id;

    openModal.value = true;
};

const cancelOperation = () => {
    openModal.value = false;
    props.errors.titulo = "";
    props.errors.fecha_entrega = "";
};

const submit = () => {
    form.post(route("tareas.update", form), {
        preserveScroll: true,
        onSuccess: () => {
            cancelOperation();
            emit("updatetarea");
        },
    });
};

const deleteTarea = () => {
    router.delete(route("tareas.destroy", props.data.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updatetarea");
        },
    });
};
</script>

<template>
    <div
        class="w-full p-4 rounded-xl border shadow bg-white group hover:shadow-md"
    >
        <div class="flex items-center justify-between gap-4">
            <!-- data -->
            <div class="w-full">
                <h3 class="font-bold uppercase">
                    <Link
                        :href="route('tareas.show', data.id)"
                        class="block py-2 group-hover:text-primary">
                        Tarea {{ data.titulo }} - Fecha entrega
                        {{ data.fecha_entrega }}
                    </Link>
                </h3>
            </div>
            <!-- dropdown -->
            <dropdown>
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
                            class="inline-block text-left py-2 font-bold w-full h-full text-primary hover:underline"
                            @click="setOpenModal()"
                        >
                            Editar
                        </button>
                        <button
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button"
                            @click="deleteTarea()"
                        >
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
    </div>
    <!-- Modal -->
    <Modal :show="openModal">
        <template #headerModal>
            <h3 class="px-2 text-xl text-primary font-bold">Editar Tarea</h3>
        </template>
        <template #bodyModal>
            <form @submit.prevent="submit">
                <text-input
                    class="pb-3 w-full"
                    id="titulo"
                    placeholder="Ingresa el título de la Tarea"
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
                        class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100"
                    >
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
                    class="py-2 flex flex-wrap gap-3 items-center justify-between lg:justify-start"
                >
                    <text-input
                        class="pb-3 w-full lg:w-72"
                        id="puntaje"
                        type="number"
                        placeholder="Puntos Asignados"
                        label="Puntos"
                        v-model="form.puntos"
                        :error="errors.puntos"
                    />
                    <text-input
                        class="pb-3 w-full lg:w-72"
                        id="fecha_entrega"
                        type="date"
                        label="Fecha Entrega"
                        v-model="form.fecha_entrega"
                        :error="errors.fecha_entrega"
                    />
                    <text-input
                        class="pb-3 w-full lg:w-72"
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
                        class="px-6 py-3 rounded text-white text-sm leading-4 font-bold whitespace-nowrap"
                        :class="{
                            'bg-gray-400 focus:bg-gray-400': form.processing,
                            'bg-primary hover:bg-orange-400': !form.processing,
                        }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        Editar Tarea
                    </button>
                </div>
            </form>
        </template>
    </Modal>
</template>
