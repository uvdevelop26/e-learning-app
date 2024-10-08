<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import Icon from "../../Components/Icon.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextArea from "../../Components/TextArea.vue";
import { useForm } from "@inertiajs/vue3";
import LoadingButton from "../../Components/LoadingButton.vue";
import { watchEffect } from "vue";

const props = defineProps({
    semestre: Object,
    carreras: Array,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.semestre.id,
    codigo: props.semestre.codigo,
    nombre: props.semestre.nombre,
    descripcion: props.semestre.descripcion,
    carrera_id: props.semestre.carrera_id,
});

const carrers = props.carreras;

const nameSemestres = [
    "I",
    "II",
    "III",
    "IV",
    "V",
    "VI",
    "VII",
    "VIII",
    "IX",
    "X",
    "XI",
    "XII",
];

watchEffect(() => {
    const carreraId = parseInt(form.carrera_id);
    const nombreSemestre = form.nombre;
    let filteredCarrer = null;

    if (isNaN(carreraId) && nombreSemestre == "") {
        filteredCarrer = null;
        form.codigo = null;
    } else {
        filteredCarrer = carrers.filter((carrera) => carrera.id == carreraId);
        form.codigo = filteredCarrer[0].codigo + "-" + nombreSemestre;
    }
});

const update = () => {
    form.post(route("semestres.update", form), {
        preserveScroll: true,
    });
};

const deleteSemestre = () => {
    form.delete(route("semestres.destroy", form.id), {
        preserveScroll: true,
    });
};
</script>
<template>
    <div>
        <AppLayout title="semestre">
            <Head title="Semestres" />

            <template #header>
                <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="edit" class="w-3 h-3 fill-white" />
                    </div>
                    Académicos / Semestres /  {{ props.semestre.nombre }}
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
                                v-model="form.carrera_id"
                                id="carrera_id"
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
                                label="Nombre"
                                v-model="form.nombre"
                                id="nombre"
                                :error="errors.nombre">
                                <option :value="null" />
                                <option
                                    v-for="name in nameSemestres"
                                    :key="name"
                                    :value="name"
                                    class="capitalize">
                                    {{ name }}
                                </option>
                            </select-input>
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Código"
                                v-model="form.codigo"
                                id="nombre"
                                disabled
                                :error="errors.codigo"
                            />
                            <text-area
                                id="descripcion"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Descripción"
                                v-model="form.descripcion"
                                :error="errors.descripcion">
                            </text-area>
                        </div>

                        <div
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                            
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Actualizar Semestre
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>

