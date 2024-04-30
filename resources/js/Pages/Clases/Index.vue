<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Card from "../../Components/Card.vue";
import Dropdown from "../../Components/Dropdown.vue";
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    clases: Array,
});

const open = ref(false);
const showClases = ref(null);

const getUserRole = async () => {
    try {
        const data = await fetch("http://127.0.0.1:8000/dashboard/users");
        if (!data.ok) {
            throw Error("data not available");
        }
        const response = data.json();
        return response;
    } catch (error) {
        console.log(error.message);
    }
};

const fetchClases = async () => {
    try {
        const data = await getUserRole();

        if (data.role == "docente") {
            showClases.value = props.clases.filter(
                (item) => item.docente_id == data.id
            );
        } else if (data.role == "alumno") {
            showClases.value = props.clases.filter((item) => {
                if (item.alumnos.length !== 0) {
                    return item.alumnos[0].id == data.id;
                }
            });
        } else if (data.role == "administrador") {
            showClases.value = props.clases;
        }
    } catch (error) {
        console.error("Error fetching user role:", error);
    }
};

const deleteClase = (id) => {
    router.delete(route("clases.destroy", id), {
        onSuccess: () => {
            fetchClases();
        },
    });
};

onMounted(fetchClases);

/*onMounted(async () => {
   try {
        const data = await getUserRole();

        if (data.role == "docente") {
            showClases.value = props.clases.filter(
                (item) => item.docente_id == data.id
            );
        } else if (data.role == "alumno") {
            showClases.value = props.clases.filter((item) => {
                if (item.alumnos.length !== 0) {
                    return item.alumnos[0].id == data.id;
                }
            });
        } else if (data.role == "administrador") {
            showClases.value = props.clases;
        }
    } catch (error) {
        console.error("Error fetching user role:", error);
    } 
});*/
</script>

<template>
    <AppLayout>
        <Head title="Clases" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 flex items-center">
                <span class="mr-3 text-primary">Clases Impartidas</span>
            </h2>
        </template>
        <div class="py-12 px-4 bg-gray-100 lg:px-8 max-w-7xl">
            <!-- create button -->
            <div
                class="flex items-center mb-6"
                v-if="$page.props.userRole.role.rol === 'docente'"
            >
                <Link class="btn-indigo" href="/clases/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Clase</span>
                </Link>
            </div>
            <div class="w-full overflow-x-auto">
                <div
                    class="py-4 px-4 flex flex-wrap items-center justify-center md:justify-start gap-6"
                >
                    <!-- cards -->
                    <template v-for="clase in showClases" :key="clase.id">
                        <card>
                            <template #cardHeader>
                                <Link
                                    class="inline-block pb-4 w-full group"
                                    :href="route('clases.show', clase.id)"
                                >
                                    <span
                                        class="block text-3xl text-white font-bold capitalize group-hover:underline"
                                    >
                                        {{ clase.materia.nombre }}
                                    </span>
                                    <span
                                        class="block text-md font-md text-white"
                                    >
                                        {{ clase.codigo }}
                                    </span>
                                </Link>
                                <Dropdown
                                    class="self-start"
                                    v-if="
                                        $page.props.userRole.role.rol !==
                                        'alumno'
                                    "
                                >
                                    <template #trigger>
                                        <div
                                            class="pt-2 pr-1 pb-1 overflow-hidden flex items-center justify-end"
                                        >
                                            <button
                                                :open="open"
                                                class="flex h-6 w-6 pt-1 rounded-full justify-center overflow-hidden z-10 group hover:ring-1 hover:ring-white focus:ring-1 focus:ring-white"
                                            >
                                                <icon
                                                    name="trigger"
                                                    class="w-[0.2rem] h-[0.2rem] fill-white"
                                                />
                                            </button>
                                        </div>
                                    </template>
                                    <template #content>
                                        <div class="p-3">
                                            <Link
                                                class="inline-block py-2 font-bold w-full h-full text-primary hover:underline"
                                                :href="
                                                    route(
                                                        'clases.edit',
                                                        clase.id
                                                    )
                                                "
                                                v-if="
                                                    $page.props.userRole.role
                                                        .rol === 'docente'
                                                "
                                            >
                                                Editar
                                            </Link>
                                            <button
                                                class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                                                type="button"
                                                @click="deleteClase(clase.id)"
                                            >
                                                Eliminar
                                            </button>
                                        </div>
                                    </template>
                                </Dropdown>
                            </template>
                            <template #cardFooter>
                                <div
                                    class="h-full flex px-4 items-center justify-between"
                                >
                                    <span
                                        class="text-xs font-bold text-primary italic capitalize"
                                    >
                                        {{ clase.estado.estado }}
                                    </span>
                                    <span class="text-xs text-gray-400 italic">
                                        {{ clase.alumnos.length }}
                                        Participante/s
                                    </span>
                                </div>
                            </template>
                        </card>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
