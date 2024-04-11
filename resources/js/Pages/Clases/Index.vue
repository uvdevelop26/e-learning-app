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
        <Head title="Clases" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center"
            >
                <span>Clases Impartidas</span>
            </h2>
        </template>
        <div class="py-12 px-4 bg-gray-100 border lg:px-8 max-w-7xl">
            <!-- create button -->
            <div class="flex items-center mb-6">
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
                    <card v-for="clase in clases" :key="clase.id">
                        <template #cardHeader>
                            <Link
                                class="inline-block pb-4 w-full group"
                                :href="route('clases.show', clase.id)">
                                <span
                                    class="block text-3xl text-white font-bold capitalize group-hover:underline">
                                    {{ clase.materia.nombre }}
                                </span>
                                <span class="block text-md font-md text-white">
                                    {{ clase.codigo }}
                                </span>
                            </Link>
                            <Dropdown class="self-start">
                                <template #trigger>
                                    <div
                                        class="pt-2 pr-1 pb-1 overflow-hidden flex items-center justify-end">
                                        <button
                                            :open="open"
                                            class="flex h-6 w-6 pt-1 rounded-full justify-center overflow-hidden z-10 group hover:ring-1 hover:ring-white focus:ring-1 focus:ring-white">
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
                                            :href="route('clases.edit', clase.id)">
                                            Editar
                                        </Link>
                                        <button
                                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                                            type="button"
                                            @click="deleteClase(clase.id)">
                                            Eliminar
                                        </button>
                                    </div>
                                </template>
                            </Dropdown>
                        </template>
                    </card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
