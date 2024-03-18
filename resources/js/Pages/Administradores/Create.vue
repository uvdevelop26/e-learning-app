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
    departamentos: Array,
    ciudades: Array,
    estados: Array,
    rol: Array,
});

const form = useForm({
    cargo: "",
    estado_id: "",
    nombre: "",
    apellido: "",
    ci_numero: "",
    sexo: "",
    telefono: "",
    direccion: "",
    ciudade_id: "",
    departamento_id: "",
    email: "",
    password: "",
    password_confirmation: "",
    role_id: props.rol[0].id,
});

const cities = props.ciudades;

const filteredCities = ref(null);

watchEffect(() => {
    const departamentoId = parseInt(form.departamento_id);

    if (isNaN(departamentoId)) {
        filteredCities.value = null;
    } else {
        filteredCities.value = cities.filter(
            (city) => city.departamento_id === departamentoId 
        );

        form.ciudade_id = null
    }
});

const submit = () => {
    form.post(route("administradores.store"), {
        preserveScroll: true,
    });
};
</script>
<template>
    <div>
        <AppLayout title="Docentes/create">
            <Head title="Docentes/create" />

            <template #header>
                <h2 class="font-semibold text-xl text-gray-800">
                    Usuarios / Administradores / Crear
                </h2>
            </template>
            <div class="py-12 px-4 lg:px-8 max-w-7xl">
                <div class="w-full overflow-hidden">
                    <form @submit.prevent="submit">
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
                            />
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Apellidos"
                                v-model="form.apellido"
                                id="apellido"
                                :error="errors.apellido"
                            />
                            <text-input
                                type="text"
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="CI"
                                v-model="form.ci_numero"
                                id="ci_numero"
                                :error="errors.ci_numero"
                            />
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Sexo"
                                v-model="form.sexo"
                                id="sexo"
                                :error="errors.sexo"
                            >
                                <option :value="null" />
                                <option value="femenino">Femenino</option>
                                <option value="masculino">Masculino</option>
                            </select-input>
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Telefono"
                                v-model="form.telefono"
                                id="telefono"
                                :error="errors.telefono"
                            />
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Dirección"
                                v-model="form.direccion"
                                id="direccion"
                                :error="errors.direccion"
                            />
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Departamento"
                                id="departamento"
                                v-model="form.departamento_id"
                                :error="errors.departamento_id"
                            >
                                <option :value="null" />
                                <option
                                    v-for="departamento in departamentos"
                                    :key="departamento.id"
                                    :value="departamento.id"
                                    class="capitalize"
                                >
                                    {{ departamento.nombre }}
                                </option>
                            </select-input>
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Ciudad"
                                v-model="form.ciudade_id"
                                id="ciudade_id"
                                :error="errors.ciudade_id"
                            >
                                <option :value="null" />
                                <option
                                    v-for="ciudade in filteredCities"
                                    :key="ciudade.id"
                                    :value="ciudade.id"
                                    class="capitalize"
                                >
                                    {{ ciudade.nombre }}
                                </option>
                            </select-input>
                        </div>
                        <div
                            class="bg-white flex flex-wrap mt-12 -mb-8 -mr-6 p-8 shadow rounded-md"
                        >
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Email"
                                v-model="form.email"
                                type="email"
                                id="email"
                                :error="errors.email"
                            />
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Cargo"
                                v-model="form.cargo"
                                id="Cargo"
                                :error="errors.cargo"
                            />
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Contraseña"
                                type="password"
                                v-model="form.password"
                                id="contrasenha"
                                :error="errors.password"
                            />
                            <text-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Vuelva a Ingresar Contraseña"
                                type="password"
                                v-model="form.password_confirmation"
                                id="validContrasenha"
                                :error="errors.password"
                            />
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Estado"
                                v-model="form.estado_id"
                                id="ciudade_id"
                                :error="errors.estado_id"
                            >
                                <option :value="null" />
                                <option
                                    v-for="estado in estados"
                                    :key="estado.id"
                                    :value="estado.id"
                                    class="capitalize"
                                >
                                    {{ estado.estado }}
                                </option>
                            </select-input>
                            <select-input
                                class="pb-8 pr-6 w-full lg:w-1/2"
                                label="Rol"
                                v-model="form.role_id"
                                id="role_id"
                                disabled
                            >
                                <option :value="null" />
                                <option
                                    v-for="ro in rol"
                                    :key="ro.id"
                                    :value="ro.id"
                                    class="capitalize"
                                >
                                    {{ ro.rol }}
                                </option>
                            </select-input>
                        </div>
                        <div
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100"
                        >
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Crear Usuario
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
