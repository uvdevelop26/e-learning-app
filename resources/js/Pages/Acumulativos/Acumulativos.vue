<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Icon from "../../Components/Icon.vue";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    results: Array,
    clase_id: Number,
});

</script>
<template>
    <AppLayout>
        <Head title="Acumulativos" />

        <template #header>
            <h2 class="font-semibold text-xl flex justify-between items-center">
                <div class="text-primary font-mono flex items-center gap-2">
                    <div
                        class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                        <Icon name="chart" class="w-2 h-2 fill-white" />
                    </div>
                    Puntajes Acumulados
                </div>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-5xl">
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">N°</th>
                            <th class="pb-4 pt-6 px-6">Clase</th>
                            <th class="pb-4 pt-6 px-6">Unidad</th>
                            <th class="pb-4 pt-6 px-6">Tareas</th>
                            <th class="pb-4 pt-6 px-6">Puntos Totales</th>
                        </tr>
                    </thead>
                    <transition-group tag="tbody" appear>
                        <tr
                            v-for="(result, index) in results"
                            :key="index"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link
                                    :href="route('clases.unidades.acumulativos.index',
                                            {clase: clase_id, unidad: result.unidade_id,})"
                                    class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    {{ index + 1 }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    :href="route('clases.unidades.acumulativos.index',
                                            {clase: clase_id, unidad: result.unidade_id,})"
                                    class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    {{ result.codigo }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    :href="route('clases.unidades.acumulativos.index',
                                            {clase: clase_id, unidad: result.unidade_id,})"
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    tabindex="-1">
                                    {{ result.tema }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    :href="route('clases.unidades.acumulativos.index',
                                            {clase: clase_id, unidad: result.unidade_id,})"
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    tabindex="-1">
                                    {{ result.tareas }}
                                </Link>
                            </td>
                            <td class="border-t max-w-80">
                                <Link
                                    :href="route('clases.unidades.acumulativos.index',
                                        {clase: clase_id, unidad: result.unidade_id,})"
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    tabindex="-1">
                                    {{ result.puntos_totales }}
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    :href="route('clases.unidades.acumulativos.index',
                                            {clase: clase_id, unidad: result.unidade_id,})"
                                    class="flex items-center px-4"
                                    tabindex="-1">
                                    <icon
                                        name="cheveron-right"
                                        class="block w-6 h-6 fill-gray-400"
                                    />
                                </Link>
                            </td>
                        </tr>
                    </transition-group>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
