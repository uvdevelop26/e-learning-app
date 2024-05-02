<script setup>
import TextInput from "./TextInput.vue";
import Icon from "./Icon.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { ref, getCurrentInstance } from "vue";
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import Modal from "./Modal.vue";

const props = defineProps({
    title: String,
    clase: Array,
    unidade: Array,
    errors: Object,
});

const open = ref(false);
const openModal = ref(false);
const editorRef = ref(null);
const { auth } = usePage().props;
const { emit } = getCurrentInstance();
const uploadedFiles = ref([]);

const form = useForm({
    titulo: "",
    descripcion: "",
    user_id: auth.user.id,
    anunciable_id: "",
    anunciable_type: "",
    nombre: [],
    url: [],
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
        form.titulo = "";
        open.value = false;
        props.errors.titulo = "";
        uploadedFiles.value = [];
        form.url = [];
    }, 300);
};

/* handle files */
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

/* submit form */
const submit = () => {
    const anunciableId =
        props.clase === null || props.clase == undefined
            ? props.unidade.id
            : props.clase.id;
    const anunciableType =
        props.clase === null || props.clase == undefined
            ? "App\\Models\\Unidade"
            : "App\\Models\\Clase";

    form.anunciable_id = anunciableId;
    form.anunciable_type = anunciableType;

    form.post(route("anuncios.store"), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            emit("newpost");
            cancelOperation();
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
                            class="pb-3 w-full"
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
                            contentType="html"
                        />
                        <!-- upload materiales -->
                        <div class="py-2 border-t-3 flex gap-3 items-center">
                            <label
                                for="upload"
                                class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100">
                                <icon
                                    name="upload"
                                    class="w-4 h-4 fill-primary"
                                />
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
                                @click="openModal = true">
                                <icon
                                    name="link"
                                    class="w-4 h-4 fill-primary"
                                />
                            </button>
                        </div>
                        <!-- show materiales -->
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
                        <!-- options -->
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
                                Publicar
                            </button>
                        </div>
                    </form>
                </div>
            </transition>
        </div>
    </div>
    <Modal :show="openModal">
        <!-- <template #headerModal>
            <h3 class="text-lg">Agregar Materiales</h3>
        </template>
        <template #bodyModal>
            <div class="h-40 flex justify-center items-center gap-3">
                <label for="file" class="flex items-center gap-2 bg-primary justify-center w-32 h-9 rounded-lg cursor-pointer hover:bg-orange-400  relative">
                    <span class="text-white font-bold">Examinar</span>
                    <input type="file" id="file" class="absolute opacity-0 -z-20" @change="getFileData($event.target)">
                    <icon name="upload" class="w-4 h-4 fill-white"  />
                </label>
                <div>
                    <span class="font-bold text-primary">{{ dataFilename }}</span>
                </div>
            </div>
        </template> -->
    </Modal>
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
