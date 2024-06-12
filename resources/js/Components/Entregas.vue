<script setup>
import Icon from "./Icon.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted, getCurrentInstance } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getFileType } from "../data/handleFiles";

const props = defineProps({
    entregas: Array,
    tarea_id: Number,
    errors: Object,
});

const uploadedFiles = ref([]);
const { auth } = usePage().props;
const entregasUser = ref(props.entregas);
const { emit } = getCurrentInstance();
const completedState = ref(false);
const entregasFiltered = ref(null);
const uploadedFileUpdate = ref(null);
const devuelto = ref(0)

const form = useForm({
    /* entregas data */
    completado: "",
    tarea_id: "",
    user_id: "",
    /* materiale_tarea data */
    url: [],
    nombre: [],
    materiable_id: "",
    materiable_type: "",
});

const formEdit = useForm({
    _method: "PUT",
    /* entregas data */
    id: "",
    completado: "",
    tarea_id: "",
    user_id: "",
    /* materiale_tarea data */
    url: [],
    nombre: [],
    materiable_id: "",
    materiable_type: "",
});

/* handle component state */
const filterEntregas = () => {
    entregasUser.value = props.entregas;
   
    entregasFiltered.value = props.entregas.filter(
        (item) => item.user_id === auth.user.id
    );

    if (entregasFiltered.value.length) {
        completedState.value = true;

        uploadedFileUpdate.value = entregasFiltered.value[0].materiales.slice();

        formEdit.completado = entregasFiltered.value[0].completado;

        if(entregasFiltered.value[0].devoluciones.length !== 0){
            const stateDevuelto =  entregasFiltered.value[0].devoluciones[0].devuelto;
            devuelto.value = stateDevuelto
        }
    } else {
        completedState.value = false;
    }
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

const getFileDataUpdate = (myFile) => {
    const file = myFile.files[0];
    uploadedFileUpdate.value.push(file);
};


const deleteFile = (index) => {
    uploadedFiles.value.splice(index, 1);
    form.url.splice(index, 1);
};

const deletetoUpdate = (index) => {
    uploadedFileUpdate.value.splice(index, 1);
};

/* submit and update forms */
const submit = () => {
    const tareaId = props.tarea_id;
    const userId = auth.user.id;
    const materiableType = "App\\Models\\Entrega";

    form.tarea_id = tareaId;
    form.user_id = userId;
    form.materiable_type = materiableType;

    form.post(route("entregas.store"), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            emit("updatetareas");
            setTimeout(() => {
                filterEntregas();
                uploadedFiles.value = [];
                form.url = [];
                form.completado = "";
            }, 200);
        },
    });
};

const update = () => {
    const tareaId = props.tarea_id;
    const userId = auth.user.id;
    const materiableType = "App\\Models\\Entrega";
    const materiableId = entregasFiltered.value[0].id;
    const newFiles = uploadedFileUpdate.value.filter((item) => item.name);
    const oldFiles = uploadedFileUpdate.value.filter((item) => item.id);

    formEdit.id = entregasFiltered.value[0].id;
    formEdit.tarea_id = tareaId;
    formEdit.user_id = userId;
    /* materiales */
    formEdit.url = newFiles;
    formEdit.nombre = oldFiles;
    formEdit.materiable_id = materiableId;
    formEdit.materiable_type = materiableType;

    formEdit.post(route("entregas.update", formEdit), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            emit("updatetareas");
            setTimeout(() => {
                filterEntregas();
            }, 200);
        },
    });
};

onMounted(filterEntregas);
</script>
<template>
    <div class="w-full max-w-sm p-4 rounded-xl border shadow bg-white group">
        <!-- text info and options -->
        <div class="flex items-center justify-between gap-4">
            <div class="w-full">
                <div class="flex py-4 justify-between items-end">
                    <h3 class="text-xl font-bold font-mono">Tu trabajo</h3>
                    <div class="text-sm leading-6 font-bold">
                        <span v-if="completedState" class="text-green-500">
                            Entregado
                        </span>
                        <span v-else class="text-red-500">Sin Entregar</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- submit tarea for the first time -->
        <form @submit.prevent="submit" v-if="!completedState">
            <div class="flex flex-col gap-4">
                <div class="h-9 rounded-lg overflow-hidden">
                    <label
                        for="upload"
                        class="flex justify-center items-center gap-2 w-full h-full border cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100">
                        <icon name="plus" class="w-4 h-4 fill-primary" />
                        <input
                            type="file"
                            id="upload"
                            class="opacity-0 absolute -z-10"
                            accept=".pdf, .jpeg, .jpg, .png, .gif, .doc, .docx, .xls, .xlsx, .ppt, .pptx"
                            @change="getFileData($event.target)"
                        />
                        <span class="text-sm font-bold">
                            Añadir Entrega
                        </span>
                    </label>
                </div>
                <!-- uploaded files -->
                <ul
                    class="flex py-2 flex-wrap gap-3"
                    v-if="uploadedFiles.length">
                    <li
                        v-for="(files, index) in uploadedFiles"
                        :key="index"
                        class="flex items-center h-12 w-full border rounded-xl overflow-hidden">
                        <div
                            class="flex h-full w-full overflow-hidden px-3 justify-center items-center gap-2 border-r">
                            <div
                                class="flex h-full w-full items-center overflow-hidden text-xs lowercase font-bold text-primary">
                                {{ files.data.name }}
                            </div>
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
                                <icon name="close" class="w-2 fill-primary" />
                            </button>
                        </div>
                    </li>
                </ul>
                <div class="h-9 rounded-lg overflow-hidden">
                    <label
                        for="completed"
                        class="flex justify-center items-center gap-2 w-full h-full border cursor-pointer hover:bg-orange-400 focus:bg-secondary"
                        :class="{
                            'bg-green-400': form.completado == 1,
                            'bg-secondary': form.completado == 0,
                        }">
                        <input
                            type="checkbox"
                            id="completed"
                            class="opacity-0 absolute -z-10"
                            v-model="form.completado"
                        />
                        <span class="text-sm font-bold text-white" v-if="form.completado == 1">
                             Completado
                        </span>
                        <span class="text-sm font-bold text-white" v-if="form.completado == 0">
                             Marcar Completado
                        </span>
                    </label>
                </div>
                <div v-if="errors.url" class="text-xs text-red-500 font-bold">
                    {{ errors.url }}
                </div>
                <div class="h-9 rounded-lg overflow-hidden">
                    <button
                        class="h-full w-full flex justify-center items-center text-white text-sm font-bold"
                        :class="{'bg-primary hover:bg-orange-400' : uploadedFiles.length, 'bg-gray-400' : !uploadedFiles.length}"
                        :disabled="!uploadedFiles.length"
                        type="submit">
                        Entregar
                    </button>
                </div>
            </div>
        </form>

        <!-- update tarea -->
        <form @submit.prevent="update" v-else>
            <div class="flex flex-col gap-4">
                <div class="h-9 rounded-lg overflow-hidden">
                    <label
                        for="upload"
                        class="flex justify-center items-center gap-2 w-full h-full border cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100">
                        <icon name="edit" class="w-4 h-4 fill-primary" />
                        <input
                            type="file"
                            id="upload"
                            class="opacity-0 absolute -z-10"
                            accept=".pdf, .jpeg, .jpg, .png, .gif, .doc, .docx, .xls, .xlsx, .ppt, .pptx"
                            @change="getFileDataUpdate($event.target)"
                        />
                        <span class="text-sm font-bold">
                            Editar Entrega
                        </span>
                    </label>
                </div>
                <!-- uploads to update -->
                <ul
                    class="flex py-2 flex-wrap gap-3"
                    v-if="uploadedFileUpdate.length">
                    <li
                        v-for="(files, index) in uploadedFileUpdate"
                        :key="index"
                        class="flex items-center h-12 w-full border rounded-xl overflow-hidden">
                        <div
                            class="flex h-full w-full overflow-hidden px-3 justify-between items-center gap-2 border-r"
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
                            class="flex h-full w-full overflow-hidden px-3 justify-center items-center gap-2 border-r"
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
                                @click="deletetoUpdate(index)">
                                <icon name="close" class="w-2 fill-primary" />
                            </button>
                        </div>
                    </li>
                </ul>
                <div class="h-9 rounded-lg overflow-hidden">
                    <label
                        for="completed"
                        class="flex justify-center items-center gap-2 w-full h-full border cursor-pointer"
                        :class="{
                            'bg-gray-400' : devuelto == 1,
                            'bg-green-400': formEdit.completado == 1 && devuelto == 0,
                            'bg-secondary': formEdit.completado == 0 && devuelto == 0,
                        }">
                        <input
                            type="checkbox"
                            id="completed"
                            class="opacity-0 absolute -z-10"
                            v-model="formEdit.completado"
                        />
                        <span class="text-sm font-bold text-white" v-if="formEdit.completado == 1">
                             Completado
                        </span>
                        <span class="text-sm font-bold text-white" v-if="formEdit.completado == 0">
                             Marcar Completado
                        </span>
                    </label>
                </div>
                <div v-if="errors.url" class="text-xs text-red-500 font-bold">
                    {{ errors.url }}
                </div>
                <div class="h-9 rounded-lg overflow-hidden">
                    <button
                        class="h-full w-full flex justify-center items-center text-white text-sm font-bold"
                        :class="{
                        'bg-primary' : uploadedFileUpdate.length && devuelto == 0,
                        'bg-gray-400' : !uploadedFileUpdate.length || devuelto == 1}"
                        :disabled="!uploadedFileUpdate.length || devuelto == 1"
                        type="submit">
                        Editar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
