<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Modal from "../../Components/Modal.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { router } from "@inertiajs/vue3";
import { getFileType } from "../../data/handleFiles";
import moment from 'moment-timezone';


const props = defineProps({
    entregas: Array,
    tareaAsignada: Array,
    totalAlumnos: Number,
    errors: Object,
});

const openModal = ref(false);
const editorRef = ref(null);
const uploadedFiles = ref([]);

const form = useForm({
    /* devolucione table */
    recomendacion: "",
    devuelto: "",
    puntos: "",
    entrega_id: "",
   
    /* materiales */
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

const setOpenModal = (id) => {
    form.entrega_id = id;
    form.devuelto = 0;

    setTimeout(() => {
        openModal.value = true;
    }, 200);
};

const setDevueltoState = (entrega) =>{
    if(entrega.devoluciones.length === 0 ){
        return false;
    }else if(entrega.devoluciones[0].devuelto == 0){
        return false;
    }else {
        return true;
    }
}

const cancelOperation = () => {
    setTimeout(() => {
        if (editorRef.value) {
            const quill = editorRef.value.getQuill();
            if (quill) {
                quill.setText("");
            }
        }
        form.devuelto = "";
        form.puntos = "";
        form.entrega_id = "";
        uploadedFiles.value = [];
        form.url = [];

        openModal.value = false;
    }, 300);
};

const submit = () => {
    const materiableType = "App\\Models\\Devolucione";

    form.materiable_type = materiableType;

    form.post(route("devoluciones.store"), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            cancelOperation();
        },
    });
};

const deleteDevolucion = (data) => {
    if (data.devoluciones.length) {
        const devolucioneId = data.devoluciones[0].id;
        router.delete(route("devoluciones.destroy", devolucioneId), {
            preserveScroll: true,
        });
    } else {
        console.log("error");
    }
};

</script>
<template>
    <AppLayout>
        <Head title="tarea" />
        <template #header>
            <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="homework" class="w-3 h-3 fill-white" />
                    </div>
                 Entregas 
            </h2>
        </template>
        <!-- body -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl mx-auto">
            <!--  -->
            <div
                class="w-full p-4 rounded-xl border shadow bg-white group max-w-5xl">
                <div class="w-full">
                    <div class="flex flex-col py-4">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <h3 class="text-xl text-primary font-bold">
                                {{ tareaAsignada.titulo }}
                            </h3>
                            <div class="text-sm font-bold">
                                Fecha límite: {{ moment.tz(tareaAsignada.fecha_entrega, 'America/Asuncion').format('DD-MM-YYYY HH:mm:ss') }} - {{ tareaAsignada.hora_entrega }}hs.
                            </div>
                        </div>
                    </div>
                    <div class="flex h-14 items-center justify-center">
                        <div
                            class="w-20 h-full flex flex-col items-center justify-end border-r-2">
                            <span class="text-2xl text-primary font-bold">
                                {{ entregas.length }}
                            </span>
                            <span class="text-xs font-bold">Entregados</span>
                        </div>
                        <div
                            class="w-20 h-full flex flex-col items-center justify-end">
                            <span class="text-2xl text-primary font-bold">
                                {{ totalAlumnos }}
                            </span>
                            <span class="text-xs font-bold">Alumnos</span>
                        </div>
                    </div>
                </div>
                <div class="w-full pt-8 overflow-x-auto">
                    <table
                        class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
                        <thead>
                            <tr class="text-left font-bold">
                                <th
                                    class="pb-4 pt-6 px-6 text-primary underline">
                                    Alumno
                                </th>
                                <th
                                    class="pb-4 pt-6 px-6 text-primary underline">
                                    Materiales
                                </th>
                                <th
                                    class="pb-4 pt-6 px-6 text-primary underline">
                                    Fech de Entrega
                                </th>
                                <th
                                    class="pb-4 pt-6 px-6 text-primary underline">
                                    Estado
                                </th>
                                <th
                                    class="pb-4 pt-6 px-6 text-primary underline">
                                    Puntos Logrados
                                </th>
                                <th
                                    class="pb-4 pt-6 px-6 text-primary underline">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(entrega) in entregas"
                                :key="entrega.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t py-4">
                                    <div>
                                        {{ entrega.user.alumnos[0].persona.nombre }}
                                        {{ entrega.user.alumnos[0].persona.apellido }}
                                    </div>
                                </td>
                                 <td class="border-t py-4">
                                    <div class="flex flex-col gap-2">
                                        <div v-for="materiales in entrega.materiales">
                                            <a
                                                :href="route('materialeTareas.download', materiales.id)"
                                                class="lowercase flex items-center gap-2 text-xs text-primary font-bold hover:underline"
                                                target="_blank">
                                                <Icon :name="getFileType(materiales.nombre)"
                                                    class="w-4 h-4 fill-primary"
                                                />
                                                {{ materiales.nombre }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-t py-4">
                                    <div>
                                        {{ moment.tz(entrega.updated_at, 'America/Asuncion').format('DD-MM-YYYY HH:mm:ss')}}
                                    </div>
                                </td>
                                <td class="border-t py-4">
                                    <div>
                                        <div v-if="entrega.devoluciones.length">
                                            <div
                                                v-for="devoluciones in entrega.devoluciones"
                                                :key="devoluciones.id">
                                                <span
                                                    v-if="devoluciones.devuelto == 1"
                                                    class="text-green-500 font-bold capitalize">
                                                    completado
                                                </span>
                                                <span
                                                    v-if="devoluciones.devuelto == 0"
                                                    class="text-primary font-bold capitalize">
                                                      pendiente
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            v-else
                                            class="text-primary font-bold capitalize">
                                            sin devolver
                                        </div>
                                    </div>
                                </td>
                                <td class="border-t py-4">
                                    <div>
                                        <span v-if="entrega.devoluciones.length">
                                            {{ entrega.devoluciones[0].puntos }}
                                        </span>
                                        <span v-else> ___</span> /
                                        &nbsp;
                                        <span class="text-sm">
                                            {{ tareaAsignada.puntos }} pts.
                                        </span>
                                    </div>
                                </td>
                                <td class="border-t py-4">
                                    <div class="flex items-center gap-2">
                                        <button
                                            :class="setDevueltoState(entrega) ? 'text-gray-400' : 'text-primary hover:underline'"
                                            type="button"
                                            @click="setOpenModal(entrega.id)"
                                            :disabled="setDevueltoState(entrega)">
                                            Devolver
                                        </button>
                                        <button
                                            class="text-red-500 hover:underline"
                                            type="button"
                                            @click="deleteDevolucion(entrega)">
                                            Deshacer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal :show="openModal">
            <template #headerModal>
                <h3 class="px-2 text-xl text-primary font-bold">
                    Devolver Tarea
                </h3>
            </template>
            <template #bodyModal>
                <form @submit.prevent="submit">
                    <label for="recomendacion" class="font-bold block py-1">
                        Recomendaciones
                    </label>
                    <QuillEditor
                        theme="snow"
                        :options="options"
                        style="height: 120px"
                        ref="editorRef"
                        contentType="html"
                        v-model:content="form.recomendacion"
                        id="recomendacion"
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
                            class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100">
                            <icon name="link" class="w-4 h-4 fill-primary" />
                        </button>
                    </div>
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
                    <div
                        class="py-2 flex flex-wrap gap-3 items-center justify-between lg:justify-start">
                        <text-input
                            class="pb-3 w-full lg:w-72"
                            id="puntaje"
                            type="number"
                            placeholder="Puntos logrados"
                            label="Puntaje"
                            v-model="form.puntos"
                        />
                        <div>
                            <label
                                for="completado"
                                class="font-bold flex gap-2 items-center">
                                Completado
                                <input
                                    type="checkbox"
                                    class="border-primary rounded checked:bg-primary checked:outline-none checked:focus:outline-none"
                                    id="completado"
                                    v-model="form.devuelto"
                                />
                            </label>
                        </div>
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
                            Devolver
                        </button>
                    </div>
                </form>
            </template>
        </Modal>
    </AppLayout>
</template>
