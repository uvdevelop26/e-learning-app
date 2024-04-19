<script setup>
import Icon from "./Icon.vue";
import Dropdown from "./Dropdown.vue";
import Comentarios from "./Comentarios.vue";
//import Materiales from "./Materiales.vue";
import Modal from "./Modal.vue";
import TextInput from "./TextInput.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { ref, getCurrentInstance, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    data: Object,
    clase_id: Number,
    errors: Object,
});

//reactive variables and objects
const open = ref(false);
const openModal = ref(false);
const { emit } = getCurrentInstance();
const { auth } = usePage().props;
const uploadedFiles = ref(props.data.materiales.slice());

//quill editor options
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

//handle open and close modal
const setOpenModal = () => {
    form.id = props.data.id;
    form.titulo = props.data.titulo;
    form.descripcion = props.data.descripcion;
    form.user_id = auth.user.id;
    form.anunciable_id = props.clase_id;
    uploadedFiles.value = props.data.materiales.slice();
    /* anunciable type */
    /* nombre */
    /* url*/
    setTimeout(() => {
        openModal.value = true;
    }, 300);
};

const sortMateriales = () => {
    props.data.materiales.sort((a, b) => {
        if (
            getFileType(a.nombre) == "picture" &&
            getFileType(b.nombre) !== "picture"
        ) {
            return -1;
        } else if (
            getFileType(a.nombre) !== "picture" &&
            getFileType(b.nombre) == "picture"
        ) {
            return 1;
        } else {
            return 0;
        }
    });
};

const cancelProcess = () => {
    openModal.value = false;
    props.errors.titulo = "";
    uploadedFiles.value = props.data.materiales.slice();
    form.nombre = [];
    form.url = [];
};

//handle files

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

const imageUrl = (url) => {
    return "/" + url.replace("public/", "storage/");
};

const deleteFile = (index) => {
    uploadedFiles.value.splice(index, 1);
    // form.url.splice(index, 1);
};

const getFileData = (myFile) => {
    const file = myFile.files[0];
    /* charge the fake array */
    uploadedFiles.value.push(file);
    //form.url.push(file);

    /* console.log(uploadedFiles.value)
    console.log(form.url) */
};

//Update and delete Anuncios
const form = useForm({
    _method: "PUT",
    id: props.data.id,
    titulo: props.data.titulo,
    descripcion: props.data.descripcion,
    user_id: auth.user.id,
    anunciable_id: props.clase_id,
    anunciable_type: "",
    nombre: [],
    url: [],
});

const update = () => {
    const newFiles = uploadedFiles.value.filter((item) => item.name);
    const oldFiles = uploadedFiles.value.filter((item) => item.id);

    form.url = newFiles;
    form.nombre = oldFiles;

    form.post(route("anuncios.update", form), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            cancelProcess();
            emit("updateanuncios");
            sortMateriales();
            uploadedFiles.value = props.data.materiales.slice();
            
        },
    });
};

const deleteAnuncio = () => {
    router.delete(route("anuncios.destroy", props.data.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updateanuncios");
        },
    });
};

//emitting custom events
const updateanuncios = () => {
    emit("updateanuncios");
};

//onMounted function
onMounted(() => {
    sortMateriales();
});
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
                            class="inline-block text-left py-2 font-bold w-full h-full text-primary hover:underline"
                            @click="setOpenModal()">
                            Editar
                        </button>
                        <button
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button"
                            @click="deleteAnuncio()">
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
        <!-- materiales section -->
        <div class="pt-4 flex flex-col gap-4" v-if="data.materiales">
            <div v-for="materiale in data.materiales" :key="materiale.id">
                <!-- show images -->
                <figure
                    v-if="getFileType(materiale.nombre) == 'picture'"
                    class="h-48 rounded-2xl border overflow-hidden md:h-64 lg:h-[28.5rem]">
                    <img
                        :src="imageUrl(materiale.url)"
                        :alt="materiale.nombre"
                        class="object-cover w-full h-full"
                    />
                </figure>
                <!-- show pdf's -->
                <div
                    class="h-14 border rounded-2xl overflow-hidden hover:bg-gray-100"
                    v-else-if="getFileType(materiale.nombre) == 'pdf'">
                    <a
                        href=""
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
                        href=""
                        class="w-full h-full px-2 flex items-center gap-2 hover:underline">
                        <Icon name="office" class="w-4 h-4 fill-primary" />
                        <span class="font-bold text-sm text-primary">{{
                            materiale.nombre
                        }}</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- comments sectios -->
        <Comentarios
            class="mt-3 border-t"
            :comentarios="data.comentarios"
            :anuncio_id="data.id"
            @updateanuncios="updateanuncios"
        />
    </div>
    <!-- modal -->
    <Modal :show="openModal">
        <template #headerModal>
            <h3 class="text-lg">Editar Anuncio</h3>
        </template>
        <template #bodyModal>
            <form @submit.prevent="update">
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
                    contentType="text"
                />
                <div class="py-2 border-t-3 flex gap-3 items-center">
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
                </div>
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
                <!-- options -->
                <div class="pt-4 border-t-2 flex justify-between">
                    <button
                        class="inline-block px-8 py-2 text-red-500 hover:underline"
                        type="button"
                        @click="cancelProcess()">
                        Cancelar
                    </button>
                    <button
                        class="px-6 py-3 rounded text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-orange-400 focus:bg-orange-400"
                        :class="{
                            'bg-gray-400': form.processing,
                            'bg-primary': !form.processing,
                        }"
                        type="submit"
                        :disabled="form.processing">
                        Actualizar
                    </button>
                </div>
            </form>
        </template>
    </Modal>
</template>
