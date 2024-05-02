<script setup>
import { format } from "date-fns";
import Dropdown from "./Dropdown.vue";
import Comentarios from "./Comentarios.vue";
import Modal from "./Modal.vue";
import Icon from "./Icon.vue";
import { useForm } from "@inertiajs/vue3";
import { QuillEditor } from "@vueup/vue-quill";
import TextInput from "./TextInput.vue";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { ref, onMounted, getCurrentInstance } from "vue";

const props = defineProps({
    tarea: Object,
    errors: Object
});

const open = ref(false);
const openModal = ref(false);
const uploadedFiles = ref(props.tarea.materiales.slice());

const options = {
    placeholder: "Escribe el contenido...",
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            [{ header: [2, 3, 4, 5, 6, false] }],
        ],
    },
};


const form = useForm({
    /* datos de la tarea */
    _method: "PUT",
    id: "",
    titulo: "",
    instruccion: "",
    fecha_entrega: "",
    hora_entrega: "",
    puntos: "",
    unidade_id: "",
    /* datos de los materiales */
    nombre: [],
    url: [],
    materiable_id: "",
    materiable_type: "",
});

const getFileType = (filename) => {
    if (filename.endsWith(".pdf")) {
        return "pdf";
    } else if (
        filename.endsWith(".jpeg") ||
        filename.endsWith(".jpg") ||
        filename.endsWith(".png") ||
        filename.endsWith(".gif")
    ) {
        return "picture";
    } else if (
        filename.endsWith(".doc") ||
        filename.endsWith(".docx") ||
        filename.endsWith(".xls") ||
        filename.endsWith(".xlsx") ||
        filename.endsWith(".ppt") ||
        filename.endsWith(".pptx")
    ) {
        return "office";
    }
};

const deleteFile = (index) => {
    uploadedFiles.value.splice(index, 1);
    // form.url.splice(index, 1);
};

const setOpenModal = () => {

    form.id = props.tarea.id;
    form.titulo = props.tarea.titulo;
    form.instruccion = props.tarea.instruccion;
    form.fecha_entrega = props.tarea.fecha_entrega;
    form.hora_entrega = props.tarea.hora_entrega;
    form.puntos = props.tarea.puntos;
    form.unidade_id = props.tarea.unidade_id;

    uploadedFiles.value = props.tarea.materiales.slice();

    setTimeout(() => {
        openModal.value = true;
    }, 300);
};

const cancelOperation = () => {
    openModal.value = false;
    props.errors.titulo = "";
    props.errors.fecha_entrega = "";
    uploadedFiles.value = props.tarea.materiales.slice();
    form.nombre = [];
    form.url = [];
};

const getFileData = (myFile) => {
    const file = myFile.files[0];
    uploadedFiles.value.push(file);
};

const update = () => {
    const newFiles = uploadedFiles.value.filter((item) => item.name);
    const oldFiles = uploadedFiles.value.filter((item) => item.id);
    const materiableId = props.tarea.id;
    const materiableType = 'App\\Models\\Tarea';

    form.url = newFiles;
    form.nombre = oldFiles;
    form.materiable_id = materiableId;
    form.materiable_type = materiableType;

    form.post(route("tareas.update", form), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            cancelOperation();
           /*  emit("updateanuncios"); */
            uploadedFiles.value = props.tarea.materiales.slice();
        },
    });

};



</script>
<template>
    <div class="w-full p-4 rounded-xl border shadow bg-white group">
        <!-- text info and options -->
        <div class="flex items-center justify-between gap-4">
            <div class="w-full">
                <div class="flex flex-col py-4 justify-between">
                    <h3 class="text-xl font-bold">
                        {{ tarea.titulo }}
                    </h3>
                    <div
                        class="text-sm leading-6"
                        v-html="tarea.instruccion">
                    </div>
                    <div class="pt-4 flex justify-between">
                        <span class="text-sm capitalize italic text-primary font-bold">Fecha limite: {{ tarea.fecha_entrega }}</span>
                        <span class="text-sm capitalize italic text-primary font-bold">{{ tarea.puntos }} puntos</span>
                    </div>
                </div>
            </div>
            <dropdown
                class="self-start"
                v-if="$page.props.userRole.role.rol !== 'alumno'">
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
                            @click="setOpenModal()">
                            Editar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
        <!-- materiales -->
        <div class="pt-4 flex flex-col gap-4" v-if="tarea.materiales">
            <div v-for="materiale in tarea.materiales" :key="materiale.id">
                <!-- show images -->
                <div
                    v-if="getFileType(materiale.nombre) == 'picture'"
                    class="h-14 border rounded-2xl overflow-hidden hover:bg-gray-100">
                    <a
                        :href="route('materiales.download', materiale.id)"
                        target="_blank"
                        tabindex="-1"
                        class="w-full h-full px-2 flex items-center gap-2 hover:underline">
                        <Icon name="picture" class="w-4 h-4 fill-primary" />
                        <span class="font-bold text-sm text-primary">
                            {{ materiale.nombre }}
                        </span>
                    </a>
                </div>
                <!-- show pdf's -->
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
                <!-- show documents -->
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
        </div>

        <!-- comentario -->
        <Comentarios :comentarios="tarea.comentarios" :tarea_id="tarea.id" />
    </div>
    <Modal :show="openModal">
        <template #headerModal>
            <h3 class="px-2 text-xl text-primary font-bold">Editar Tarea</h3>
        </template>
        <template #bodyModal>
            <form @submit.prevent="update">
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
                <!-- upload elements -->
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
                        class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100">
                        <icon name="link" class="w-4 h-4 fill-primary" />
                    </button>
                </div>
                <!-- show uploaded elements -->
                <ul class="flex py-2 flex-wrap gap-3">
                    <li
                        v-for="(files, index) in uploadedFiles"
                        :key="index"
                        class="flex items-center h-12 border rounded-xl overflow-hidden">
                        <div
                            class="flex h-full px-3 justify-center items-center gap-2 border-r"
                            v-if="files.nombre">
                            <span
                                class="text-xs lowercase font-bold text-primary">
                                {{ files.nombre }}
                            </span>
                            <icon
                                :name="getFileType(files.nombre)"
                                class="w-4 h-4 fill-primary"
                            />
                        </div>
                        <div
                            class="flex h-full px-3 justify-center items-center gap-2 border-r"
                            v-else>
                            <span
                                class="text-xs lowercase font-bold text-primary">
                                {{ files.name }}
                            </span>
                            <icon
                                :name="getFileType(files.name)"
                                class="w-4 h-4 fill-primary"
                            />
                        </div>
                        <div
                            class="w-10 h-full flex items-center justify-center">
                            <button
                                class="h-full w-full flex justify-center items-center hover:bg-gray-100"
                                type="button"
                                @click="deleteFile(index)">
                                <icon name="close" class="w-2 fill-primary" />
                            </button>
                        </div>
                    </li>
                </ul>
                <div
                    class="py-2 flex flex-wrap gap-3 items-center justify-between lg:justify-start">
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
                        type="button">
                        Cancelar
                    </button>
                    <button
                        class="px-6 py-3 rounded text-white text-sm leading-4 font-bold whitespace-nowrap"
                        :class="{
                            'bg-gray-400 focus:bg-gray-400': form.processing,
                            'bg-primary hover:bg-orange-400': !form.processing,
                        }"
                        :disabled="form.processing"
                        type="submit">
                        Editar Tarea
                    </button>
                </div>
            </form>
        </template>
    </Modal>
</template>
