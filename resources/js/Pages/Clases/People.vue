<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Card from "../../Components/Card.vue";
import Dropdown from "../../Components/Dropdown.vue";
import { ref, watchEffect, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import LoadingButton from "../../Components/LoadingButton.vue";

const props = defineProps({
    clase: Array,
    alumnos: Array,
    docente: Array,
    completeAlumnos: Array,
    errors: Object,
});

const alumnosData = props.completeAlumnos;

const filteredAlumnosData = ref(null);

const show = ref(false);

const inputDisabled = ref(false);

const data = ref(null);

const form = useForm({
    clase: props.clase.id,
    alumnos: [],
});

const formDelete = useForm({
    clase: props.clase.id,
    alumnos: [],
});

watchEffect(() => {
    const dataCI = parseInt(data.value);

    if (isNaN(dataCI)) {
        filteredAlumnosData.value = null;
    } else {
        filteredAlumnosData.value = alumnosData.filter((alumno) => {
            return alumno.ci_numero_persona.includes(dataCI);
        });
    }
});

const selectAlumno = (id) => {
    form.alumnos.push(id);

    filteredAlumnosData.value = null;

    const selected = alumnosData.filter((alumno) => alumno.alumno_id == id);

    data.value = selected[0].nombre_persona;

    inputDisabled.value = true;
};

const deleteSelected = () => {
    form.alumnos = [];

    inputDisabled.value = false;

    data.value = null;
};

const cancelOperation = () => {
    data.value = null;
    show.value = false;
    props.errors.alumnos = "";
    inputDisabled.value = false;
    form.alumnos = [];
};

const submit = () => {
    form.post(route("clases.asignAlumnos"), {
        preserveScroll: true,
        onSuccess: () => {
            data.value = null;
            show.value = false;
            inputDisabled.value = false;
            form.alumnos = [];
        },
    });
};

const deleteAlumno = (id) => {
    formDelete.alumnos.push(id);
    formDelete.delete(route("clases.revokeAlumno", formDelete.clase), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Personas" />

        <template #header>
            <h2
                class="font-semibold flex justify-between items-center">
                <span class="text-xl text-primary">Personas / clase {{ clase.codigo }}</span>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="w-full p-4 rounded-xl border shadow bg-white group">
                <div class="py-4">
                    <div class="py-4 px-4 border-b border-primary">
                        <h3 class="text-2xl font-bold text-primary">
                            Profesor
                        </h3>
                    </div>
                    <div class="py-4 px-4 text-md">
                        {{ docente.nombre }}
                        {{ docente.apellido }}
                    </div>
                </div>
                <div class="py-4">
                    <div
                        class="py-4 px-4 border-b border-primary flex justify-between">
                        <h3 class="text-2xl font-bold text-primary">Alumnos</h3>
                        <button @click="show = !show">
                            <icon
                                name="plus"
                                class="w-5 h-5 fill-primary hover:fill-secondary"
                            />
                        </button>
                    </div>

                    <ul class="px-4 text-md">
                        <li
                            v-for="alumno in alumnos"
                            :key="alumno.id"
                            class="py-2 px-2 rounded-md flex justify-between hover:bg-gray-100">
                            <span>
                                {{ alumno.persona.nombre }}
                                {{ alumno.persona.apellido }}
                            </span>
                            <button
                                class="p-1"
                                @click="deleteAlumno(alumno.id)">
                                <icon
                                    name="trash"
                                    class="w-4 h-4 fill-primary hover:fill-red-500"
                                />
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- modal -->
        <modal :show="show">
            <template #headerModal>
                <h3 class="text-lg">Agregar Alumno</h3>
            </template>
            <template #bodyModal>
                <div>
                    <div class="relative">
                        <input
                            type="search"
                            class="w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm"
                            :class="{ 'bg-gray-100': inputDisabled }"
                            id="buscar"
                            v-model="data"
                            placeholder="Introducir CI"
                            :disabled="inputDisabled"
                        />
                        <div v-if="errors.alumnos" class="text-red-500">
                            {{ errors.alumnos }}
                        </div>
                        <button
                            v-if="inputDisabled"
                            class="absolute top-2 right-5 bg-gray-300 p-2 flex items-center justify-center rounded-full"
                            @click="deleteSelected()">
                            <icon name="close" class="h-2 w-2 fill-gray-500" />
                        </button>
                    </div>
                    <ul>
                        <li
                            v-for="(alumnos, index) in filteredAlumnosData"
                            :key="alumnos.alumno_id"
                            class="my-1 py-2 px-2 text-sm rounded-md hover:bg-gray-100 cursor-pointer"
                            :class="{ hidden: index > 4 }">
                            <button
                                @click="selectAlumno(alumnos.alumno_id)"
                                class="inline-block w-full h-full text-left">
                                {{ alumnos.nombre_persona
                                }}{{ alumnos.apellido_persona }}
                            </button>
                        </li>
                    </ul>
                </div>
            </template>
            <template #footerModal>
                <button
                    class="px-3 text-red-500 hover:underline"
                    @click="cancelOperation()"
                    type="button">
                    Cancelar
                </button>
                <button
                    class="px-6 py-3 rounded text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-orange-400 focus:bg-orange-400"
                    :class="{
                        'bg-primary': !form.processing,
                        'bg-gray-500': form.processing,
                    }"
                    @click="submit()"
                    :disabled="form.processing">
                    Enviar
                </button>
            </template>
        </modal>
    </AppLayout>
</template>
