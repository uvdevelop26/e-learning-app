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
    docente: Object,
    departamentos: Array,
    currentDpto: Number,
    ciudades: Array,
    estados: Array,
    roles: Array,
    currentRole: Number,
    errors: Object
});

const form = useForm({
    _method: "PUT",
    id: props.docente.id,
    profesion: props.docente.profesion,
    estado_id: props.docente.estado_id,

    nombre: props.docente.persona[0].nombre,
    apellido: props.docente.persona[0].apellido,
    ci_numero: props.docente.persona[0].ci_numero,
    sexo: props.docente.persona[0].sexo,
    telefono: props.docente.persona[0].telefono,
    direccion: props.docente.persona[0].direccion,
    ciudade_id: props.docente.persona[0].ciudade_id,
    departamento_id: props.currentDpto,
    email: props.docente.user[0].email,
    password: props.docente.user[0].password,
    password_confirmation: props.docente.user.password,
    role_id: props.currentRole
});

const update = () => {
    form.post(route("docentes.update", form),{
        preserveScroll: true
    });
};

const deleteUser = ()=>{

    form.delete(route("docentes.destroy", form.id),{
        preserveScroll: true
    })
}


</script>
<template>
    <div>
        <AppLayout title="docente">
            <Head title="Docentes" />

            <template #header>
                <h2 class="font-semibold text-xl text-gray-800">
                    Usuarios / Docentes / {{ props.docente.persona[0].nombre }}
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
                                    v-for="ciudade in ciudades"
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
                                label="Profesión"
                                v-model="form.profesion"
                                id="profesion"
                                :error="errors.profesion"
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
                            class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100"
                        >
                            <button
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="deleteUser"
                            >
                                Eliminar Usuario
                            </button>
                            <loading-button
                                :loading="form.processing"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Actualizar Usuario
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
