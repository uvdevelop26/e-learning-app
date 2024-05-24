<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import TextInput from "../../Components/TextInput.vue";
import Icon from "../../Components/Icon.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextArea from "../../Components/TextArea.vue";
import LoadingButton from "../../Components/LoadingButton.vue";
import DangerButton from "../../Components/DangerButton.vue"
import SecondaryButton from "../../Components/SecondaryButton.vue"
import Modal from "../../Components/Modal.vue"

const props = defineProps({
    carrera: Object,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.carrera.id,
    nombre: props.carrera.nombre,
    codigo: props.carrera.codigo,
    duracion: props.carrera.duracion,
    descripcion: props.carrera.descripcion,
});

const showConfirm = ref(false);

const generateCode = (name) => {
    const array = name.split(" ");
    let newArray = [];
    for (let i = 0; i < array.length; i++) {
        let test = array[i].split("")[0];
        newArray.push(test);
    }

    let result = newArray.join("").toUpperCase();

    form.codigo = result;
};

const update = () => {
    form.post(route("carreras.update", form), {
        preserveScroll: true,
    });
};

const deleteCarrer = () => {
    form.delete(route("carreras.destroy", form.id), {
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
                <h2 class="font-semibold text-xl text-primary flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="edit" class="w-3 h-3 fill-white" />
                    </div>
                    Académicos / Carreras / {{ props.carrera.nombre }}
                </h2>
            </template>

            <div class="py-12 px-4 lg:px-8 max-w-7xl">
                <div class="w-full overflow-hidden">
                    <form @submit.prevent="update">
                        <div
                            class="bg-white flex flex-wrap -mb-8 -mr-6 p-8 shadow rounded-md">
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Nombres"
                                v-model="form.nombre"
                                id="nombre"
                                :error="errors.nombre"
                                @input="generateCode(form.nombre)"
                            />
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Código"
                                v-model="form.codigo"
                                id="nombre"
                                :error="errors.codigo"
                                disabled
                            />
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Duración"
                                v-model="form.duracion"
                                id="duracion"
                                :error="errors.duracion"
                            />
                            <text-area
                                id="descripcion"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Descripción"
                                v-model="form.descripcion">
                            </text-area>
                        </div>
                        <div
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                            <button
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="showConfirm = !showConfirm">
                                Eliminar Carrera
                            </button>
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit">
                                Actualizar Carrera
                            </loading-button>
                            <Modal :show="showConfirm" maxWidth="md">
                                <template #headerModal>
                                   <h2 class="flex items-center justify-center">
                                    <span class="font-bold text-lg text-primary mr-2">¿Desea Eliminar esta Carrera?</span>                         
                                    <Icon name="trash" class="w-4 h-4 fill-primary" />
                                   </h2> 
                                </template>
                                <template #bodyModal>
                                    <div class="flex justify-center space-x-8">
                                        <DangerButton @click="deleteCarrer">
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

