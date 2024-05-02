<script setup>
import Icon from "./Icon.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    entregas: Array,
    tarea_id: Number,
    errors: Object
});

const uploadedFiles = ref([]);
const { auth } = usePage().props;

const form = useForm({
    /* entregas data */
    completado: "",
    puntaje: "",
    tarea_id: "",
    user_id: "",
    /* materiale_tarea data */
    url: [],
    nombre: [],
    materiable_id: "",
    materiable_type: "",
});

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



const submit = ()=>{
    const tareaId = props.tarea_id;
    const userId = auth.user.id;
    const materiableType = 'App\\Models\\Entrega';

    form.tarea_id = tareaId;
    form.user_id = userId;
    form.materiable_type = materiableType;

    form.post(route("entregas.store"), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
           // cancelOperation();
        },
    });

}


</script>
<template>
    <div class="w-full p-4 rounded-xl border shadow bg-white group lg:w-2/5">
        <!-- text info and options -->
        <div class="flex items-center justify-between gap-4">
            <div class="w-full">
                <div class="flex py-4 justify-between items-end">
                    <h3 class="text-xl font-bold">Tu trabajo</h3>
                    <div class="text-sm leading-6 font-bold text-red-500">
                        Sin entregar
                    </div>
                </div>
            </div>
        </div>
        <!-- Add tarea -->
        <form @submit.prevent="submit">
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
                        <span class="text-sm font-bold italic">
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
                        class="flex justify-center items-center gap-2 w-full h-full border cursor-pointer bg-secondary hover:bg-orange-400 focus:bg-secondary" :class="{'bg-green-400' : form.completado }">
                        <input
                            type="checkbox"
                            id="completed"
                            class="opacity-0 absolute -z-10"
                            v-model="form.completado"
                        />
                        <span class="text-sm font-bold italic text-white">
                            Marcar Completado
                        </span>
                    </label>
                </div>
                <div v-if="errors.url" class="text-xs text-red-500 font-bold">{{ errors.url }}</div>
                <div class="h-9 rounded-lg overflow-hidden">
                    <button
                        class="h-full w-full flex justify-center items-center bg-primary text-white text-sm font-bold hover:bg-orange-400"
                        type="submit">
                        Entregar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
