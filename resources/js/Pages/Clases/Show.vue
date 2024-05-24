<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import Anuncio from "../../Components/Anuncio.vue";
import Unidades from "../../Components/Unidades.vue";
import TextArea from "../../Components/TextArea.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    clase: Array,
    materia: Array,
    semestre: Array,
    carrera: Array,
    anunciosYunidades: Object,
    errors: Object,
});

const anunciosUnidades = ref(props.anunciosYunidades);

const numeroUnidades = ref(props.anunciosYunidades.unidades.length + 1);

const newAnunciosUnidades = ref(
    anunciosUnidades.value.anuncios.concat(anunciosUnidades.value.unidades)
);

const showAddUnidades = ref(false);
const showEditUnidades = ref(false);

//update data

function updatedata() {
    anunciosUnidades.value = props.anunciosYunidades;
    newAnunciosUnidades.value = anunciosUnidades.value.anuncios.concat(
        anunciosUnidades.value.unidades
    );
    sortArray();
}

const sortArray = () => {
    newAnunciosUnidades.value.sort((a, b) => {
        const dateA = new Date(a.created_at);
        const dateB = new Date(b.created_at);
        return dateA - dateB;
    });
};

//reactive forms to store unidades
const form = useForm({
    clase_id: props.clase.id,
    numero: numeroUnidades,
    tema: "",
    objetivos: "",
});

//submit unidades form
const submit = () => {
    form.post(route("unidades.store"), {
        preserveScroll: true,
        onSuccess: () => {
            updatedata();
            form.tema = null;
            form.objetivos = null;
            showAddUnidades.value = false;
            props.errors.tema = "";
            numeroUnidades.value++;
            form.numero = numeroUnidades;
        },
    });
};

//update data throught emits
const updateunidad = () => {
    setTimeout(() => {
        updatedata();
    }, 600);
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

//cancel submitting unidades and anuncios

const cancelProcess = () => {
    //clean errors
    props.errors.tema = "";
    props.errors.objetivos = "";
    //clear add unidades form
    form.tema = "";
    form.objetivos = "";
    //close modals
    showAddUnidades.value = false;
    showEditUnidades.value = false;
};

//organizing array to show in the screen

onMounted(() => {
    updatedata();
});
</script>

<template>
    <AppLayout>
        <Head :title="`Clase ${clase.codigo}`" />

        <template #header>
            <h2
                class="font-semibold text-xl flex justify-between items-center">
                <div class="text-primary flex items-center gap-2">
                    <div
                    class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                         <Icon name="homework" class="w-2 h-2 fill-white" />
                    </div>
                    Clase {{ props.clase.codigo }}
                </div>
                <button @click="showAddUnidades = !showAddUnidades" class="text-sm text-primary italic hover:text-opacity-90 hover:underline" v-if="$page.props.userRole.role !== 'alumno'">
                    + Agregar Unidad
                </button>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <!-- Header class info -->
            <div
                class="h-56 bg-gradient-to-tr from-primary via-secondary to-primary rounded-2xl flex flex-col items-center justify-center">
                <h3 class="pt-2 font-bold text-3xl lg:text-5xl text-white">
                    {{ props.materia.nombre }}
                </h3>
                <div class="font-bold text-xl lg:text-2xl text-white">
                    Semestre {{ props.semestre.nombre }}
                </div>
                <div class="font-bold text-xl lg:text-2xl text-white">
                     {{ props.carrera.nombre}}
                </div>
            </div>
            <!-- Content Class -->
            <div class="mt-6 flex flex-col gap-6 lg:flex-row">
                <!-- Option pdf materia -->
                <div class="flex gap-6 items-center lg:flex-col lg:items-start">
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative cursor-pointer group">
                        <a
                            :href="route('materias.download', materia.id)"
                            class="absolute top-0 left-0 right-0 bottom-0"
                            target="_blank"
                            tabindex="-1">
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2">
                                <span
                                    class="block pb-3 group-hover:text-primary">
                                    Plan de Estudio
                                </span>
                                <icon
                                    name="pdf"
                                    class="w-6 h-6 mx-auto fill-black group-hover:fill-primary"
                                />
                            </div>
                        </a>
                    </div>
                    <!-- opion persona page -->
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group">
                        <Link
                            :href="route('clases.showPersonas', clase.id)"
                            class="absolute top-0 left-0 right-0 bottom-0"
                            tabindex="-1">
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2">
                                <span
                                    class="block pb-3 group-hover:text-primary">
                                    Personas
                                </span>
                                <icon
                                    name="user"
                                    class="w-6 h-6 mx-auto fill-black group-hover:fill-primary"
                                />
                            </div>
                        </Link>
                    </div>
                </div>
                <!-- Body -->
                <div class="w-full flex flex-col gap-6">
                    <!-- editor "Escribe algo en tu clase" -->
                    <editor-wrapper
                        title="Anuncia algo a tu clase.."
                        :clase="clase"
                        :errors="errors"
                        @newpost="newpost"
                        v-if="$page.props.userRole.role !== 'alumno'"
                    />
                    <!-- Unidades links or class anuncios -->
                    <template
                        v-for="(data, index) in newAnunciosUnidades"
                        :key="index">
                        <component
                            v-if="data.titulo"
                            :data="data"
                            :is="Anuncio"
                            :errors="errors"
                            :clase_id="clase.id"
                            @updateanuncios="updateanuncios"
                        />
                        <component
                            v-else
                            :is="Unidades"
                            :data="data"
                            :errors="errors"
                            :clase_id="clase.id"
                            @updateunidad="updateunidad"
                        />
                    </template>
                </div>
            </div>
        </div>

        <!-- modal New Unidades -->
        <modal :show="showAddUnidades">
            <template #headerModal>
                <h3 class="px-2 text-xl text-primary font-bold">Agregar Unidad</h3>
            </template>
            <template #bodyModal>
                <form @submit.prevent="submit">
                    <div class="bg-white flex flex-wrap -mb-8 -mr-6 rounded-md">
                        <text-input
                            class="pb-8 pr-6 w-full"
                            label="Unidad Número"
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
                            v-model="form.objetivos">
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
                            class="px-6 py-3 rounded text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-orange-400 focus:bg-orange-400"
                            :class="{
                                'bg-gray-400': form.processing,
                                'bg-primary': !form.processing,
                            }"
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
