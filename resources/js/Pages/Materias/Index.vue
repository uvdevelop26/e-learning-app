<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";

defineProps({
    materias: Array,
});
</script>

<template>
    <AppLayout>
        <Head title="Carreras" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800">
                Académicos / Materias
            </h2>
        </template>
        <!-- -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="flex items-center justify-between mb-6">
                <!-- <search-filter
                v-model="form.search"
                class="mr-4 w-full max-w-md"
                @reset="reset"
            >
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="form-select mt-1 w-full">
                    <option :value="null" />
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>  -->
                <Link class="btn-indigo" href="/materias/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Materia</span>
                </Link>
            </div>
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md"
                >
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Código</th>
                            <th class="pb-4 pt-6 px-6">Nombre</th>
                            <th class="pb-4 pt-6 px-6">Horas Semanales</th>
                            <th class="pb-4 pt-6 px-6">Plan de Estudio</th>
                            <th class="pb-4 pt-6 px-6">Carrera / Semestre</th>
                            <th class="pb-4 pt-6 px-6">Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="materia in materias"
                            :key="materia.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('materias.edit', materia.id)"
                                >
                                    {{ materia.codigo }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('materias.edit', materia.id)"
                                >
                                    {{ materia.nombre }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('materias.edit', materia.id)"
                                >
                                    <div>{{ materia.horas_semanales }}</div>
                                </Link>
                            </td>

                            <td class="border-t max-w-80">
                                <a
                                    :href="`/download/${materia.id}`"
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    target="_blank"
                                    tabindex="-1"
                                >
                                    <div class="flex items-center text-xs">
                                        <icon
                                            name="pdf"
                                            class="w-6 h-6 fill-primary hover:fill-secondary"
                                        />
                                    </div>
                                </a>
                            </td>
                            <td class="border-t max-w-80">
                                <Link
                                    class="flex flex-col items-start px-6 py-4 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('materias.edit', materia.id)"
                                >
                                    <div>
                                        {{ materia.semestre.carrera.nombre }}
                                    </div>
                                    <div>
                                        Semestre {{ materia.semestre.nombre }}
                                    </div>
                                </Link>
                            </td>
                            <td class="border-t max-w-80">
                                <Link
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('materias.edit', materia.id)"
                                >
                                    <div>{{ materia.descripcion }}</div>
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    tabindex="-1"
                                    :href="route('materias.edit', materia.id)"
                                >
                                    <icon
                                        name="cheveron-right"
                                        class="block w-6 h-6 fill-gray-400"
                                    />
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
