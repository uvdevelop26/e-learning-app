<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import Icon from "../../Components/Icon.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextArea from "../../Components/TextArea.vue";
import { useForm } from "@inertiajs/vue3";
import LoadingButton from "../../Components/LoadingButton.vue";
import { watchEffect, ref } from "vue";

const props = defineProps({
    errors: Object,
    materias: Array,
    semestres: Array,
    carreras: Array,
    clase: Array,
    currentSemestre: Number,
    currentCarrera: Number,
    estados: Array
});

const form = useForm({
    _method: "PUT",
    id: props.clase.id,
    codigo: props.clase.codigo,
    materia_id: props.clase.materia_id,
    carrera_id: props.currentCarrera,
    semestre_id: props.currentSemestre,
    estado_id: props.clase.estado_id
});

const semesters = props.semestres;

const filteredSemesters = ref(null);

const materias = props.materias;

const filteredMaterias = ref(null);

watchEffect(() => {
    const carreraId = parseInt(form.carrera_id);

    if (isNaN(carreraId)) {
        filteredSemesters.value = null;

    } else {
        filteredSemesters.value = semesters.filter(
            (semester) => semester.carrera_id === carreraId
        );

    }
});

watchEffect(() => {
    const semestreId = parseInt(form.semestre_id);

    if (isNaN(semestreId)) {
        filteredMaterias.value = null;
    } else {
        filteredMaterias.value = materias.filter(
            (materia) => materia.semestre_id === semestreId
        );
    }
});

watchEffect(() => {
    const materiaId = parseInt(form.materia_id);
    const randomNumber = Math.floor(Math.random() * 100);

    if (isNaN(materiaId)) {
        form.codigo = null;
    } else {
        const prefixCode = materias.filter(
            (materia) => materia.id === materiaId
        );

        form.codigo = prefixCode[0].codigo + randomNumber;
    }
});

const update = () => {
    form.post(route("clases.update", form), {
        preserveScroll: true,
    });
};
</script>
<template>
    <div>
        <AppLayout title="Clases/create">
            <Head title="Clases/create" />

            <template #header>
                <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="edit" class="w-3 h-3 fill-white" />
                    </div>
                    Clases / Editar
                </h2>
            </template>
            <div class="py-12 px-4 lg:px-8 max-w-7xl">
                <div class="w-full overflow-hidden">
                    <form @submit.prevent="update">
                        <div
                            class="bg-white flex flex-wrap -mb-8 -mr-6 p-8 shadow rounded-md">
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Carrera"
                                id="carrera"
                                v-model="form.carrera_id"
                                :error="errors.carrera_id">
                                <option :value="null" />
                                <option
                                    v-for="carrera in carreras"
                                    :key="carrera.id"
                                    :value="carrera.id"
                                    class="capitalize">
                                    {{ carrera.nombre }}
                                </option>
                            </select-input>
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Semestre"
                                id="semestre"
                                v-model="form.semestre_id"
                                :error="errors.semestre_id">
                                <option :value="null" />
                                <option
                                    v-for="semestre in filteredSemesters"
                                    :key="semestre.id"
                                    :value="semestre.id"
                                    class="capitalize">
                                    {{ semestre.nombre }}
                                </option>
                            </select-input>
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Materia"
                                v-model="form.materia_id"
                                id="materia"
                                :error="errors.materia_id">
                                <option :value="null" />
                                <option
                                    v-for="materia in filteredMaterias"
                                    :key="materia.id"
                                    :value="materia.id"
                                    class="capitalize">
                                    {{ materia.nombre }}
                                </option>
                            </select-input>
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Estado"
                                id="estado"
                                v-model="form.estado_id"
                                :error="errors.estado_id">
                                <option :value="null" />
                                <option
                                    v-for="estado in estados"
                                    :key="estado.id"
                                    :value="estado.id"
                                    class="capitalize">
                                    {{ estado.estado }}
                                </option>
                            </select-input>
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Código"
                                v-model="form.codigo"
                                id="telefono"
                                :error="errors.codigo"
                                disabled
                            />
                        </div>
                        <div
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit">
                                Actualizar Clase
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
