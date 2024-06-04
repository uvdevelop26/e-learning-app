<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { watchEffect, ref } from "vue";
import TextInput from "../../Components/TextInput.vue";
import Icon from "../../Components/Icon.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextArea from "../../Components/TextArea.vue";
import LoadingButton from "../../Components/LoadingButton.vue";
import DangerButton from "../../Components/DangerButton.vue"
import SecondaryButton from "../../Components/SecondaryButton.vue"
import Modal from "../../Components/Modal.vue"

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
const filename = ref("");

const showConfirm = ref(false);

const handleFileUpload = (event) =>{
    const file = event.target.files[0];
    form.plan_estudio = file;
    filename.value = file.name;
    /* form.plan_estudio = event.target.files[0];
    filename.value = */
} 

watchEffect(() => {
    let carreraId = parseInt(form.carrera_id);

    if (isNaN(carreraId)) {
        filteredSemestres.value = null;
    } else {
        filteredSemestres.value = semesters.filter(
            (sem) => sem.carrera_id === carreraId
        );
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
        onSuccess: () => {
            showConfirm.value = false
        }
    });
};
</script>
<template>
    <div>
        <AppLayout title="carrera">
            <Head title="Carreras" />

            <template #header>
                <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="edit" class="w-3 h-3 fill-white" />
                    </div>
                    Académicos / Materias / {{ materia.nombre }}
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
                            <div class="py-2 border-t-3 flex gap-3 items-center">
                                <label
                                    for="upload"
                                    class="flex justify-center items-center w-11 h-11 border rounded-full cursor-pointer hover:bg-indigo-100 focus:bg-indigo-100 relative">
                                    <icon name="upload" class="w-4 h-4 fill-primary" />
                                    <input
                                        type="file"
                                        id="upload"
                                        class="opacity-0 absolute -z-10"
                                        accept=".pdf, .jpeg, .jpg, .png, .gif, .doc, .docx, .xls, .xlsx, .ppt, .pptx"
                                        @input="handleFileUpload($event)"
                                    />
                                   <span class="absolute w-28 font-bold -top-8 left-0">Plan de estudio</span>
                                </label>
                                <div class="text-sm lowercase">{{ filename }}</div>
                                <div v-if="errors.plan_estudio">{{ errors.plan_estudio }}</div>
                            </div>
                            <!-- <text-input
                                type="file"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Plan de Estudio"
                                @input="
                                    form.plan_estudio = $event.target.files[0]"
                                id="duracion"
                                :error="errors.plan_estudio"
                            /> -->
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
                            <button
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="showConfirm = !showConfirm">
                                Eliminar Materia
                            </button>
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit">
                                Actualizar Materia
                            </loading-button>
                            <Modal :show="showConfirm" maxWidth="md">
                                <template #headerModal>
                                   <h2 class="flex items-center justify-center">
                                    <span class="font-bold text-lg text-primary mr-2">¿Desea Eliminar esta Materia?</span>                         
                                    <Icon name="trash" class="w-4 h-4 fill-primary" />
                                   </h2> 
                                </template>
                                <template #bodyModal>
                                    <div class="flex justify-center space-x-8">
                                        <DangerButton @click="deleteMateria">
                                            Eliminar
                                        </DangerButton>
                                        <SecondaryButton @click="showConfirm = !showConfirm">
                                            Cancelar
                                        </SecondaryButton>
                                    </div>
                                </template>
                            </Modal>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
