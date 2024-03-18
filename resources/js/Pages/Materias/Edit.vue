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
    materia: Array,
    currentCarrera: Number,
    carreras: Array,
    semestres: Array,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.materia.id,
    nombre: props.materia.nombre,
    codigo: props.materia.codigo,
    horas_semanales: props.materia.horas_semanales,
    plan_estudio: null,
    descripcion: props.materia.descripcion,
    carrera_id: props.currentCarrera,
    semestre_id: props.materia.semestre_id,
});

const semesters = props.semestres;

const filteredSemestres = ref(null);

watchEffect(() => {
    let carreraId = parseInt(form.carrera_id);

    if (isNaN(carreraId)) {
        filteredSemestres.value = null;
    } else {
        filteredSemestres.value = semesters.filter(
            (sem) => sem.carrera_id === carreraId
        );

      //  form.semestre_id = null;
    }
});

watchEffect(() => {
    const semestreId = parseInt(form.semestre_id);
    const randomNumber = Math.floor(Math.random() * 100);

    if (isNaN(semestreId)) {
        form.codigo = null;
    } else {
        const prefixCode = semesters.filter((sem) => sem.id == semestreId);

        form.codigo = prefixCode[0].codigo + randomNumber;
    }
});

const update = () => {
    form.post(route("materias.update", form), {
        preserveScroll: true,
        forceFormData: true
    });
};

const deleteMateria = () => {
    form.delete(route("materias.destroy", form.id), {
        preserveScroll: true,
    });
};
</script>
<template>
    <div>
        <AppLayout title="carrera">
            <Head title="Carreras" />

            <template #header>
                <h2 class="font-semibold text-xl text-gray-800">
                    Académicos / Materias / {{ materia.nombre }}
                </h2>
            </template>

            <div class="py-12 px-4 lg:px-8 max-w-7xl">
                <div class="w-full overflow-hidden">
                    <form @submit.prevent="update">
                        <div
                            class="bg-white flex flex-wrap -mb-8 -mr-6 p-8 shadow rounded-md"
                        >
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Carrera"
                                id="carrera"
                                v-model="form.carrera_id"
                                :error="errors.carrera_id"
                            >
                                <option :value="null" />
                                <option
                                    v-for="carrera in carreras"
                                    :key="carrera.id"
                                    :value="carrera.id"
                                    class="capitalize"
                                >
                                    {{ carrera.nombre }}
                                </option>
                            </select-input>
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Semestre"
                                id="semestre"
                                v-model="form.semestre_id"
                                :error="errors.semestre_id"
                            >
                                <option :value="null" />
                                <option
                                    v-for="semestre in filteredSemestres"
                                    :key="semestre.id"
                                    :value="semestre.id"
                                    class="capitalize"
                                >
                                    {{ semestre.nombre }}
                                </option>
                            </select-input>
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Nombre"
                                v-model="form.nombre"
                                id="nombre"
                                :error="errors.nombre"
                            />

                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Código"
                                v-model="form.codigo"
                                id="codigo"
                                :error="errors.codigo"
                                disabled
                            />
                            <text-input
                                type="number"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Horas Semanales"
                                v-model="form.horas_semanales"
                                id="horas_semanales"
                                :error="errors.horas_semanales"
                            />
                            <text-input
                                type="file"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Plan de Estudio"
                                @input="
                                    form.plan_estudio = $event.target.files[0]
                                "
                                id="duracion"
                                :error="errors.plan_estudio"
                            />
                            <text-area
                                id="descripcion"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Descripción"
                                v-model="form.descripcion"
                                :error="errors.descripcion"
                            >
                            </text-area>
                        </div>

                        <div
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100"
                        >
                        <button
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="deleteMateria"
                            >
                                Eliminar Materia
                            </button>
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Actualizar Materia
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
