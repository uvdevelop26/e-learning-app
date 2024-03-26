<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Card from "../../Components/Card.vue";
import Dropdown from "../../Components/Dropdown.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
    clases: Array,
});

const open = ref(false);

const deleteClase = (id) => {
    router.delete(route("clases.destroy", id));
};
</script>

<template>
    <AppLayout>
        <Head title="Carreras" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center"
            >
                <span>Clases Impartidas</span>
                <!-- <button>
                    <icon name="plus" class="w-5 h-5 fill-primary hover:fill-secondary" />
                </button> -->
            </h2>
        </template>
        <div class="py-12 px-4 bg-gray-100 border lg:px-8 max-w-7xl">
            <div class="flex items-center mb-6">
                <!-- <search-filter
                    v-model="form.search"
                    class="mr-4 w-full max-w-md"
                    @reset="reset"
                >
                    <label class="block text-gray-700">Trashed:</label>
                    <select
                        v-model="form.trashed"
                        class="form-select mt-1 w-full"
                    >
                        <option :value="null" />
                        <option value="with">With Trashed</option>
                        <option value="only">Only Trashed</option>
                    </select>
                </search-filter> -->
                <Link class="btn-indigo" href="/clases/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Clase</span>
                </Link>
            </div>
            <div class="w-full overflow-x-auto">
                <div
                    class="py-4 px-4 flex flex-wrap items-center justify-center md:justify-start gap-6">
                    <card v-for="clase in clases" :key="clase.id">
                        <template #cardHeader>
                            <Dropdown>
                                <template #trigger>
                                    <div class="text-right">
                                        <button
                                            :open="open"
                                            class="inline-block h-full">
                                            <icon
                                                name="trigger"
                                                class="w-[0.38rem] h-[0.38rem] fill-white"
                                            />
                                        </button>
                                    </div>
                                </template>
                                <template #content>
                                    <div class="p-3">
                                        <Link
                                            class="inline-block py-2 font-bold w-full h-full text-primary hover:underline"
                                            :href="route('clases.edit', clase.id)">
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
                            <Link
                                class="inline-block w-full group bg-red-2000"
                                :href="route('clases.show', clase.id)" >
                                <span
                                    class="block text-3xl text-white font-bold group-hover:underline">
                                    {{ clase.materia.nombre }}
                                </span>
                                <span class="block text-md font-md text-white">
                                    {{ clase.codigo }}
                                </span>
                            </Link>
                        </template>
                    </card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
