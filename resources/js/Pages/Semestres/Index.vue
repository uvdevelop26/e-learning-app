<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";

defineProps({
    semestres: Array,
});
</script>

<template>
    <AppLayout>
        <Head title="Semestres" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800">
                Académicos / Semestres
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
                <Link class="btn-indigo" href="/semestres/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Semestre</span>
                </Link>
            </div>
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md"
                >
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Semestre</th>
                            <th class="pb-4 pt-6 px-6">Código</th>
                            <th class="pb-4 pt-6 px-6">Descripcion</th>
                            <th class="pb-4 pt-6 px-6">Carrera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="semestre in semestres"
                            :key="semestre.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('semestres.edit', semestre.id)"
                                >
                                    {{ semestre.nombre }}
                                </Link>
                            </td> 
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('semestres.edit', semestre.id)"
                                >
                                    {{ semestre.codigo }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 max-w-80 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('semestres.edit', semestre.id)"
                                >
                                    <div>{{ semestre.descripcion }}</div>
                                </Link>
                            </td>

                            <td class="border-t max-w-80">
                                <Link
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('semestres.edit', semestre.id)"
                                >
                                    <div>{{ semestre.carrera.nombre }}</div>
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    tabindex="-1"
                                    :href="route('semestres.edit', semestre.id)"
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
