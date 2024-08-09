<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { watchEffect, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Link, Head } from "@inertiajs/vue3";
import TextInput from "../../Components/TextInput.vue";
import Icon from "../../Components/Icon.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextArea from "../../Components/TextArea.vue";
import LoadingButton from "../../Components/LoadingButton.vue";
import DangerButton from "../../Components/DangerButton.vue"
import SecondaryButton from "../../Components/SecondaryButton.vue"
import Modal from "../../Components/Modal.vue"

const props = defineProps({
    administradore: Object,
    departamentos: Array,
    currentDpto: Number,
    ciudades: Array,
    estados: Array,
    roles: Array,
    currentRole: Number,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.administradore.id,
    cargo: props.administradore.cargo,
    estado_id: props.administradore.estado_id,
    nombre: props.administradore.persona[0].nombre,
    apellido: props.administradore.persona[0].apellido,
    ci_numero: props.administradore.persona[0].ci_numero,
    sexo: props.administradore.persona[0].sexo,
    telefono: props.administradore.persona[0].telefono,
    direccion: props.administradore.persona[0].direccion,
    ciudade_id: props.administradore.persona[0].ciudade_id,
    departamento_id: props.currentDpto,
    email: props.administradore.user[0].email,
    password: props.administradore.user[0].password,
    password_confirmation: props.administradore.user[0].password,
    role_id: props.currentRole,
});

const cities = props.ciudades;

const filteredCities = ref(null);
const showConfirm = ref(false);

watchEffect(() => {
    const departamentoId = parseInt(form.departamento_id);

    if (isNaN(departamentoId)) {
        filteredCities.value = null;
    } else {
        filteredCities.value = cities.filter(
            (city) => city.departamento_id === departamentoId
        );
    }
});

const update = () => {
    form.post(route("administradores.update", form), {
        preserveScroll: true,
    });
};

const deleteUser = () => {
    form.delete(route("administradores.destroy", form.id), {
        preserveScroll: true,
        onSuccess: () => {
            showConfirm.value = false
        }
    });
};
</script>
<template>
    <div>
        <AppLayout title="administrador">
            <Head title="Administradores" />

            <template #header>
                <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="edit" class="w-3 h-3 fill-white" />
                    </div>
                    Usuarios / Administrador / {{ props.administradore.persona[0].nombre }} {{ props.administradore.persona[0].apellido }}
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
                                :error="errors.departamento"
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
                                id="cargo"
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
                                id="ciudade_id"
                                disabled
                            >
                                <option :value="null" />
                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                    class="capitalize"
                                >
                                    {{ role.rol }}
                                </option>
                            </select-input>
                        </div>
                        <div
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                            <button
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="showConfirm = !showConfirm">
                                Eliminar Usuario
                            </button>
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Actualizar Usuario
                            </loading-button>
                            <Modal :show="showConfirm" maxWidth="md">
                                <template #headerModal>
                                   <h2 class="flex items-center justify-center">
                                    <span class="font-bold text-lg text-primary mr-2">¿Desea Eliminar este Administrador?</span>                         
                                    <Icon name="trash" class="w-4 h-4 fill-primary" />
                                   </h2> 
                                </template>
                                <template #bodyModal>
                                    <div class="flex justify-center space-x-8">
                                        <DangerButton @click="deleteUser">
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

<!--        
                       

                    -->
