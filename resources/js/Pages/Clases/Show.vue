<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import TextArea from "../../Components/TextArea.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const props = defineProps({
    clase: Array,
    materia: Array,
    semestre: Array,
    carrera: Array,
    unidades: Array,
    errors: Object,
});

const show = ref(false);

const numeroUnidad = props.unidades.length + 1;

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

const form = useForm({
    clase: props.clase.id,
    numero: numeroUnidad,
    tema: "",
    objetivos: "",
});

const cancelProcess = () => {
    (form.tema = null),
        (form.objetivos = null),
        (show.value = false),
        (props.errors.tema = "");
};

const submit = () => {
    form.post(route("unidades.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.tema = null;
            form.objetivos = null;
            show.value = false;
            props.errors.tema = "";
        },
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Carreras" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center"
            >
                <span>
                    {{ carrera.nombre }}
                </span>
                <button
                    class="flex flex-col items-center group"
                    type="button"
                    @click="show = !show"
                >
                    <icon
                        name="plus"
                        class="w-5 h-5 fill-primary group-hover:fill-secondary"
                    />
                </button>
            </h2>
        </template>
        <div
            class="py-12 px-4 mx-auto bg-white border h-screen lg:px-8 max-w-7xl"
        >
            <div class="h-full flex flex-col gap-6">
                <div
                    class="h-56 bg-primary rounded-2xl flex flex-col items-center justify-center"
                >
                    <span class="inline-block text-3xl lg:text-5xl text-white">
                        {{ props.materia.nombre }}
                    </span>
                    <span class="inline-block text-xl lg:text-2xl text-white">
                        Semestre {{ props.semestre.nombre }}
                    </span>
                    <span class="inline-block text-lg lg:text-xl text-white">
                        Clase {{ props.clase.codigo }}
                    </span>
                </div>
                <div
                    class="flex flex-col gap-6 items-center lg:flex-row lg:items-start"
                >
                    <div
                        class="w-full flex justify-center flex-wrap gap-6 lg:flex-col lg:justify-start lg:w-fit"
                    >
                        <div
                            class="w-36 py-4 border rounded-xl flex flex-col items-center justify-center text-sm"
                        >
                            <span class="font-bold text-primary"
                                >Plan de Estudio</span
                            >
                            <a
                                :href="`/download/${materia.id}`"
                                class="flex items-center px-6 py-4 whitespace-normal"
                                target="_blank"
                                tabindex="-1"
                            >
                                <div class="flex items-center text-xs">
                                    <icon
                                        name="pdf"
                                        class="w-6 h-6 fill-primary hover:fill-secondary"
                                    />
                                </div>
                            </a>
                        </div>
                        <div
                            class="w-36 py-4 border rounded-xl flex flex-col items-center justify-center text-sm"
                        >
                            <span class="font-bold text-primary"
                                >Próximas Entregas</span
                            >
                            {{ clase.codigo }}
                        </div>
                        <div
                            class="w-36 py-4 border rounded-xl flex flex-col items-center justify-center text-sm"
                        >
                            <span class="font-bold text-primary">
                                Personas
                            </span>
                            <Link
                                class="flex items-center px-6 py-4 whitespace-normal"
                                :href="route('clases.showPersonas', clase.id)"
                            >
                                <div class="flex items-center text-xs">
                                    <icon
                                        name="user"
                                        class="w-6 h-6 fill-primary hover:fill-secondary"
                                    />
                                </div>
                            </Link>
                            <!--  <a
                                :href="`/download/${materia.id}`"
                                class="flex items-center px-6 py-4 whitespace-normal"
                                target="_blank"
                                tabindex="-1"
                            >
                               
                            </a> -->
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-6">
                        <editor-wrapper title="Anuncia algo a tu clase...">
                            <template #content>
                                <form action="">
                                    <text-input
                                        class="pb-3 pr-6 w-full"
                                        id="titulo"
                                        placeholder="Ingresa el título del Anuncio"
                                    />
                                    <QuillEditor
                                        theme="snow"
                                        :options="options"
                                        style="height: 120px"
                                    />
                                    <div class="py-2 border-t-3">
                                        <label
                                            for="imagen"
                                            class="flex justify-center items-center w-11 h-11 rounded-full cursor-pointer bg-indigo-100"
                                        >
                                        <icon name="upload" class="w-4 h-4 fill-primary" />
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
                      <!--   <div
                            class="w-full p-4 rounded-xl border shadow group bg-white hover:shadow-md cursor-pointer"
                            v-for="unidad in unidades"
                        >
                            <h2 class="text-sm font-bold capitalize">
                                Unidad Número {{ unidad.numero }} - Tema
                                {{ unidad.tema }}
                            </h2>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <modal :show="show">
            <template #headerModal>
                <h3 class="text-lg">Agregar Unidad</h3>
            </template>
            <template #bodyModal>
                <form @submit.prevent="submit">
                    <div class="bg-white flex flex-wrap -mb-8 -mr-6 rounded-md">
                        <text-input
                            class="pb-8 pr-6 w-full"
                            label="Número"
                            id="numero"
                            disabled
                            v-model="form.numero"
                            :error="errors.numero"
                        />
                        <text-input
                            class="pb-8 pr-6 w-full"
                            label="Tema"
                            id="tema"
                            v-model="form.tema"
                            :error="errors.tema"
                        />
                        <text-area
                            id="objetivos"
                            class="pb-8 pr-6 w-full"
                            label="Objetivos"
                            v-model="form.objetivos"
                            :error="errors.objetivos"
                        >
                        </text-area>
                    </div>
                    <div
                        class="flex items-center justify-between pt-4 bg-gray-50 border-t border-gray-100"
                    >
                        <button
                            class="px-3 text-red-500 hover:underline"
                            @click="cancelProcess"
                        >
                            Cancelar
                        </button>
                        <button
                            class="px-7 py-1 bg-primary hover:bg-secondary text-white rounded-md"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Enviar
                        </button>
                    </div>
                </form>
            </template>
        </modal>
    </AppLayout>
</template>
