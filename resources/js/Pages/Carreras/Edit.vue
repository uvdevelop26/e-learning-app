<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import Icon from "../../Components/Icon.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextArea from "../../Components/TextArea.vue";
import { useForm } from "@inertiajs/vue3";
import LoadingButton from "../../Components/LoadingButton.vue";

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
    });
};
</script>
<template>
    <div>
        <AppLayout title="carrera">
            <Head title="Carreras" />

            <template #header>
                <h2 class="font-semibold text-xl text-gray-800">
                    Usuarios / Carreras / {{ props.carrera.nombre }}
                </h2>
            </template>

            <div class="py-12 px-4 lg:px-8 max-w-7xl">
                <div class="w-full overflow-hidden">
                    <form @submit.prevent="update">
                        <div
                            class="bg-white flex flex-wrap -mb-8 -mr-6 p-8 shadow rounded-md"
                        >
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
                                v-model="form.descripcion"
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
                                @click="deleteCarrer"
                            >
                                Eliminar Carrera
                            </button>
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Actualizar Carrera
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>

<!--        
                       

                    -->
