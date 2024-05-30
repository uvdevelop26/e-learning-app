<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    results: Array,
});

const { props: pageProps } = usePage();

const resultsNew = ref([]);
const puntosTotales = ref(0);
const puntosLogrados = ref(0);

const filterResult = () => {
    const userRole = pageProps.userRole.role;
    if (userRole === "alumno") {
        const userEmail = pageProps.userRole.email;
        resultsNew.value = props.results.filter(
            (item) => item.alumno === userEmail
        );
        resultsNew.value.forEach((item) => {
            puntosTotales.value += parseInt(item.puntos_asig);

            if (!isNaN(item.puntos_logrados)) {
                puntosLogrados.value += parseInt(item.puntos_logrados);
            }
        });
    }else{
        resultsNew.value = props.results;
    }
};

onMounted(filterResult);
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
                    Punajes Acumulados
                </div>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">N°</th>
                            <th class="pb-4 pt-6 px-6">Clase</th>
                            <th class="pb-4 pt-6 px-6">Unidad</th>
                            <th class="pb-4 pt-6 px-6">Actividad</th>
                            <th class="pb-4 pt-6 px-6">Puntos Asignados</th>
                            <th class="pb-4 pt-6 px-6">Alumno</th>
                            <th class="pb-4 pt-6 px-6">Entregado</th>
                            <th class="pb-4 pt-6 px-6">Corregido</th>
                            <th class="pb-4 pt-6 px-6">Puntos logrados</th>
                        </tr>
                    </thead>
                    <transition-group tag="tbody" appear>
                        <tr
                            v-for="(result, index) in resultsNew"
                            :key="index"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <div
                                    class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    {{ index + 1 }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div
                                    class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    {{ result.clase }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1">
                                    {{ result.unidad }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1">
                                    {{ result.actividad }}
                                </div>
                            </td>
                            <td class="border-t max-w-80">
                                <div
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1">
                                    {{ result.puntos_asig }}
                                </div>
                            </td>
                            <td class="border-t max-w-80">
                                <div
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1">
                                    {{ result.alumno }}
                                </div>
                            </td>

                            <td class="border-t">
                                <div
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1">
                                    <div v-if="result.entregado == 1">
                                        entregado
                                    </div>
                                    <div v-else>sin entregar</div>
                                </div>
                            </td>
                            <td class="border-t">
                                <div
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1">
                                    <div v-if="result.corregido == 1">
                                        corregido
                                    </div>
                                    <div v-else>sin corregirr</div>
                                </div>
                            </td>
                            <td class="w-px border-t">
                                <div
                                    class="flex items-center px-4"
                                    tabindex="-1">
                                    {{ result.puntos_logrados }}
                                </div>
                            </td>
                        </tr>
                    </transition-group>
                </table>
            </div>
            <div class="py-4 mt-4">
                <ul
                    class="w-48 bg-secondary text-white border py-4 shadow-lg rounded-lg ">
                    <li class="p-2 text-sm font-bold font-mono">
                        Puntos totales: {{ puntosTotales }}
                    </li>
                    <li class="p-2 text-sm font-bold font-mono">
                        Puntos Logrados: {{ puntosLogrados }}
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
