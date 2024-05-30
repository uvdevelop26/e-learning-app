<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import Anuncio from "../../Components/Anuncio.vue";
import Modal from "../../Components/Modal.vue";
import AnuncioTareas from "../../Components/AnuncioTareas.vue";
import Tareas from "../../Components/Tareas.vue";
import TextInput from "../../Components/TextInput.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const props = defineProps({
    anunciosYtareas: Array,
    errors: Object,
    clase_id: Number,
});

const anunciosTareas = ref(props.anunciosYtareas);
const newAnunciosYtareas = ref(
    anunciosTareas.value.anuncios.concat(anunciosTareas.value.tareas)
);
const showAddTareas = ref(false);
const editorRef = ref(null);
const uploadedFiles = ref([]);

const form = useForm({
    /* datos de la tarea */
    titulo: "",
    instruccion: "",
    fecha_entrega: "",
    hora_entrega: "",
    puntos: "",
    unidade_id: props.anunciosYtareas.id,
    /* datos de los materiales */
    nombre: [],
    url: [],
    materiable_id: "",
    materiable_type: "",
});

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
        form.titulo = "";
        props.errors.titulo = "";
        props.errors.fecha_entrega = "";
        form.puntos = "";
        form.fecha_entrega = "";
        form.hora_entrega = "";
        uploadedFiles.value = [];
        form.url = [];

        showAddTareas.value = false;
    }, 300);
};

function updatedata() {
    anunciosTareas.value = props.anunciosYtareas;
    newAnunciosYtareas.value = anunciosTareas.value.anuncios.concat(
        anunciosTareas.value.tareas
    );
    sortArray();
}

const getFileData = (myFile) => {
    const name = myFile.files[0].name;
    const file = myFile.files[0];

    if (name.endsWith(".pdf")) {
        uploadedFiles.value.push({ extension: "pdf", data: file });
        form.url.push(file);
    } else if (
        name.endsWith(".jpeg") ||
        name.endsWith(".jpg") ||
        name.endsWith(".png") ||
        name.endsWith(".gif")
    ) {
        uploadedFiles.value.push({ extension: "picture", data: file });
        form.url.push(file);
    } else if (
        name.endsWith(".doc") ||
        name.endsWith(".docx") ||
        name.endsWith(".xls") ||
        name.endsWith(".xlsx") ||
        name.endsWith(".ppt") ||
        name.endsWith(".pptx")
    ) {
        uploadedFiles.value.push({ extension: "office", data: file });
        form.url.push(file);
    } else {
        console.log(file);
    }
};

const deleteFile = (index) => {
    uploadedFiles.value.splice(index, 1);
    form.url.splice(index, 1);
};

const submit = () => {
    const materiableType = "App\\Models\\Tarea";

    form.materiable_type = materiableType;

    form.post(route("tareas.store"), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            cancelOperation();
            updatedata();
        },
    });
};

const newpost = () => {
    setTimeout(() => {
        updatedata();
    }, 600);
};

const updateanuncios = () => {
    setTimeout(() => {
        updatedata();
    }, 600);
};

const updatetarea = () => {
    setTimeout(() => {
        updatedata();
    }, 600);
};

const sortArray = () => {
    newAnunciosYtareas.value.sort((a, b) => {
        const dateA = new Date(a.created_at);
        const dateB = new Date(b.created_at);
        return dateA - dateB;
    });
};

onMounted(() => {
    updatedata();
});
</script>
<template>
    <AppLayout>
        <Head :title="`Unidad ${anunciosYtareas.numero}`" />

        <template #header>
            <h2 class="font-semibold font-mono flex justify-between items-center">
                <span class="text-xl text-primary">
                    Unidad Número {{ anunciosYtareas.numero }} -
                    {{ anunciosYtareas.tema }}
                </span>
                <button
                    @click="showAddTareas = !showAddTareas"
                    class="text-sm text-primary italic hover:text-opacity-90 hover:underline">
                    + Agregar Tarea
                </button>
            </h2>
        </template>
        <div class="py-9 px-4 lg:px-8 max-w-7xl">
            <!-- content -->
            <div class="mt-6 flex flex-col gap-6 lg:flex-row max-w-6xl mx-auto">
                <div class="w-full flex flex-col gap-6">
                    <editor-wrapper
                        :title="$page.props.userRole.role === 'alumno' 
                        ? 'Publica en la Clase' 
                        : 'Anuncia algo a tu clase'"
                        :unidade="anunciosYtareas"
                        :errors="errors"
                        @newpost="newpost"
                    />
                    <template
                        v-for="(data, index) in newAnunciosYtareas"
                        :key="index">
                        <component
                            v-if="data.instruccion"
                            :data="data"
                            :clase_id="props.clase_id"
                            :unidade_id="props.anunciosYtareas.id"
                            :is="Tareas"
                            :errors="errors"
                            @updatetarea="updatetarea"
                        />
                        <component
                            v-else
                            :data="data"
                            :is="Anuncio"
                            :errors="errors"
                            :unidade_id="anunciosYtareas.id"
                            @updateanuncios="updateanuncios"
                        />
                    </template>
                </div>
            </div>
        </div>
        <modal :show="showAddTareas">
            <template #headerModal>
                <h3 class="px-2 text-xl text-primary font-bold">
                    Agregar Tarea
                </h3>
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
                    <!-- upload materiales -->
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
                    <!-- show materiales uploaded -->
                    <ul class="flex py-2 flex-wrap gap-3">
                        <li
                            v-for="(files, index) in uploadedFiles"
                            :key="index"
                            class="flex items-center h-12 border rounded-xl overflow-hidden">
                            <div
                                class="flex h-full px-3 justify-center items-center gap-2 border-r">
                                <span
                                    class="text-xs lowercase font-bold text-primary">
                                    {{ files.data.name }}
                                </span>
                                <icon
                                    :name="files.extension"
                                    class="w-4 h-4 fill-primary"
                                />
                            </div>
                            <div
                                class="w-10 h-full flex items-center justify-center">
                                <button
                                    class="h-full w-full flex justify-center items-center hover:bg-gray-100"
                                    type="button"
                                    @click="deleteFile(index)">
                                    <icon
                                        name="close"
                                        class="w-2 fill-primary"
                                    />
                                </button>
                            </div>
                        </li>
                    </ul>
                    <!-- other inputs -->
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
                                'bg-gray-400 focus:bg-gray-400':
                                    form.processing,
                                'bg-primary hover:bg-orange-400':
                                    !form.processing,
                            }"
                            :disabled="form.processing"
                            type="submit">
                            Agregar Tarea
                        </button>
                    </div>
                </form>
            </template>
        </modal>
    </AppLayout>
</template>
