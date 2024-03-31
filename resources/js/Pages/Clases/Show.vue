<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import TextArea from "../../Components/TextArea.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import Dropdown from "../../Components/Dropdown.vue";
import { ref, onMounted, reactive } from "vue";
import { useForm } from "@inertiajs/vue3";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    clase: Array,
    materia: Array,
    semestre: Array,
    carrera: Array,
    anunciosYunidades: Object,
    errors: Object,
});

const { auth } = usePage().props;

const anunciosUnidades = ref(props.anunciosYunidades);

const newAnunciosUnidades = ref(
    anunciosUnidades.value.anuncios.concat(anunciosUnidades.value.unidades)
);

const show = ref(false);

const open = ref(false);

const editorRef = ref(null);

//QuillEditor Options
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


//reactive forms for Unidades and Anuncios
const form = useForm({
    clase_id: props.clase.id,
    numero: "",
    tema: "",
    objetivos: "",
});

const formAnuncios = useForm({
    titulo: "",
    descripcion: "",
    user_id: auth.user.id,
    anunciable_id: props.clase.id,
    anunciable_type: "",
});


//submitting forms unidades and anuncios
const submitUnidades = () => {
    form.post(route("unidades.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.tema = null;
            form.objetivos = null;
            show.value = false;
            props.errors.tema = "";
            anunciosUnidades.value = props.anunciosYunidades;
            newAnunciosUnidades.value = anunciosUnidades.value.anuncios.concat(
                anunciosUnidades.value.unidades
            );
            sortArray();
        },
    });
};

const enviar = () => {
    formAnuncios.post(route("anuncios.store"), {
        preserveScroll: true,
        onSuccess: () => {
            cancelar();
            props.errors.titulo = "";
            anunciosUnidades.value = props.anunciosYunidades;
            newAnunciosUnidades.value = anunciosUnidades.value.anuncios.concat(
                anunciosUnidades.value.unidades
            );
            sortArray();
        },
    });
};

//cancel submitting unidades and anuncios
const cancelar = () => {
    setTimeout(() => {
        if (editorRef.value) {
            const quill = editorRef.value.getQuill();
            if (quill) {
                quill.setText("");
            }
        }

        formAnuncios.titulo = "";
    }, 300);
};

const cancelProcess = ()=>{
    props.errors.numero = "";
    props.errors.tema = "";
    form.tema = "";
    form.objetivos = ""
    

}

//organizing array to show in the screen
const sortArray = () => {
    newAnunciosUnidades.value.sort((a, b) => {
        const dateA = new Date(a.created_at);
        const dateB = new Date(b.created_at);
        return dateA - dateB;
    });
};

onMounted(() => {
    sortArray();
});
</script>

<template>
    <AppLayout>
        <Head :title="`Clase ${clase.codigo}`" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center">
                <span>
                    {{ carrera.nombre }}
                </span>
                <button @click="show = !show">
                    <icon name="plus" class="h-4 w-4 fill-primary" />
                </button>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <!-- Header class -->
            <div
                class="h-56 bg-primary rounded-2xl flex flex-col items-center justify-center">
                <h3 class="pt-2 font-bold text-3xl lg:text-5xl text-white">
                    {{ props.materia.nombre }}
                </h3>
                <div class="font-bold text-xl lg:text-2xl text-white">
                    Semestre {{ props.semestre.nombre }}
                </div>
                <div class="font-bold text-xl lg:text-2xl text-white">
                    Clase {{ props.clase.codigo }}
                </div>
            </div>
            <!-- Content Class -->
            <div class="mt-6 flex flex-col gap-6 lg:flex-row">
                <!-- Options -->
                <div class="flex gap-6 items-center lg:flex-col lg:items-start">
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group hover:shadow-md">
                        <a
                            :href="`/download/${materia.id}`"
                            class="absolute top-0 left-0 right-0 bottom-0"
                            target="_blank"
                            tabindex="-1">
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2">
                                <span
                                    class="block pb-3 text-primary group-hover:text-secondary">
                                    Plan de Estudio
                                </span>
                                <icon
                                    name="pdf"
                                    class="w-6 h-6 mx-auto fill-primary group-hover:fill-secondary"
                                />
                            </div>
                        </a>
                    </div>
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group hover:shadow-md">
                        <Link
                            :href="route('clases.showPersonas', clase.id)"
                            class="absolute top-0 left-0 right-0 bottom-0"
                            tabindex="-1">
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2">
                                <span
                                    class="block pb-3 text-primary group-hover:text-secondary">
                                    Personas
                                </span>
                                <icon
                                    name="user"
                                    class="w-6 h-6 mx-auto fill-primary group-hover:fill-secondary"
                                />
                            </div>
                        </Link>
                    </div>
                </div>
                <!-- Body -->
                <div class="w-full flex flex-col gap-6">
                    <editor-wrapper
                        title="Anuncia algo a tu clase..."
                        @enviar="enviar"
                        @cancelar="cancelar">
                        <template #content>
                            <form>
                                <text-input
                                    class="hidden"
                                    id="titulo"
                                    placeholder="Ingresa el título del Anuncio"
                                    v-model="form.user_id"
                                />
                                <text-input
                                    class="pb-3 pr-6 w-full"
                                    id="titulo"
                                    placeholder="Ingresa el título del Anuncio"
                                    v-model="formAnuncios.titulo"
                                    :error="errors.titulo"
                                />
                                <QuillEditor
                                    theme="snow"
                                    :options="options"
                                    style="height: 120px"
                                    v-model:content="formAnuncios.descripcion"
                                    ref="editorRef"
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
                            </form>
                        </template>
                    </editor-wrapper>
                    <div
                        class="w-full p-4 rounded-xl border shadow bg-white group"
                        v-for="(data, index) in newAnunciosUnidades"
                        :key="index">
                        <div class="flex justify-end">
                            <dropdown>
                                <template #trigger>
                                    <div class="text-right">
                                        <button
                                            :open="open"
                                            class="inline-block h-4 w-4"
                                        >
                                            <icon
                                                name="trigger"
                                                class="w-[0.25rem] h-[0.25rem] fill-primary"
                                            />
                                        </button>
                                    </div>
                                </template>
                                <template #content>
                                    <div class="p-3">
                                        <Link
                                            class="inline-block py-2 font-bold w-full h-full text-primary hover:underline">
                                            Editar
                                        </Link>
                                        <button
                                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                                            type="button">
                                            Eliminar
                                        </button>
                                    </div>
                                </template>
                            </dropdown>
                        </div>
                        <div v-if="data.titulo">
                            <h3 class="py-2 font-bold uppercase">
                                {{ data.titulo }}
                            </h3>
                            <p class="text-sm">{{ data.descripcion }}</p>
                        </div>
                        <div v-if="data.numero">
                            <h3 class="font-bold uppercase">
                                <Link :href="route('unidades.show', data.id)"
                                    class="block py-2 group-hover:text-primary">
                                    Unidad Número {{ data.numero }} -
                                    {{ data.tema }}
                                </Link>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal :show="show">
            <template #headerModal>
                <h3 class="text-lg">Agregar Unidad</h3>
            </template>
            <template #bodyModal>
                <form @submit.prevent="submitUnidades">
                    <div class="bg-white flex flex-wrap -mb-8 -mr-6 rounded-md">
                        <text-input
                            class="pb-8 pr-6 w-full"
                            label="Número"
                            id="numero"
                            v-model="form.numero"
                            :error="errors.numero"
                            disabled
                        />
                        <text-input
                            class="pb-8 pr-6 w-full"
                            label="Tema"
                            id="tema"
                            :error="errors.tema"
                            v-model="form.tema"
                        />
                        <text-area
                            id="objetivos"
                            class="pb-8 pr-6 w-full"
                            label="Objetivos"
                            :error="errors.objetivos"
                            v-model="form.objetivos"
                        >
                        </text-area>
                    </div>
                    <div
                        class="flex items-center justify-between pt-4 bg-gray-50 border-t border-gray-100">
                        <button 
                            class="px-3 text-red-500 hover:underline" 
                            type="button"
                            @click="cancelProcess">
                            Cancelar
                        </button>
                        <button
                            class="px-7 py-1 bg-primary hover:bg-orange-400 text-white rounded-md"
                            type="submit"
                            :disabled="form.processing">
                            Enviar
                        </button>
                    </div>
                </form>
            </template>
        </modal>
    </AppLayout>
</template>
