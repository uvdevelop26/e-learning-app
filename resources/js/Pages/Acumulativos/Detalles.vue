<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import { usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const props = defineProps({
    detalles: Array,
    clase: Number,
    unidad: Number
});

const { props: pageProps } = usePage();
const filteredDetalles = ref([]);

onMounted(() => {
    const userRole = pageProps.userRole.role;

    if (userRole === "alumno") {
        const email = pageProps.auth.user.email;
        filteredDetalles.value = props.detalles.filter(
            (item) => item.email === email
        );
    } else {
        filteredDetalles.value = props.detalles;
    }
});
</script>
<template>
    <AppLayout>
        <Head title="Acumulativos" />

        <template #header>
            <h2 class="font-semibold text-xl flex justify-between items-center">
                <div class="text-primary font-mono flex items-center gap-2">
                    <div
                        class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md"
                    >
                        <Icon name="chart" class="w-2 h-2 fill-white" />
                    </div>
                    Detalles
                </div>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-6xl">
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">N°</th>
                            <th class="pb-4 pt-6 px-6">Alumno</th>
                            <th class="pb-4 pt-6 px-6">Tarea</th>
                            <th class="pb-4 pt-6 px-6">Puntos Asignados</th>
                            <th class="pb-4 pt-6 px-6">Entregado</th>
                            <th class="pb-4 pt-6 px-6">Corregido</th>
                            <th class="pb-4 pt-6 px-6">Puntos Logrados</th>
                        </tr>
                    </thead>
                    <transition-group tag="tbody" appear>
                        <template
                            v-if="filteredDetalles && filteredDetalles.length > 0">
                            <tr
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                                v-for="(detalle, index) in filteredDetalles"
                                :key="index">
                                <td class="border-t">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ index + 1 }}
                                    </div>
                                </td>
                                <td class="border-t">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ detalle.email }}
                                    </div>
                                </td>
                                <td class="border-t">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        tabindex="-1">
                                        {{ detalle.titulo }}
                                    </div>
                                </td>
                                <td class="border-t">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        tabindex="-1">
                                        {{ detalle.puntos_asig }}
                                    </div>
                                </td>
                                <td class="border-t max-w-80">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        tabindex="-1">
                                        <span v-if="detalle.completado == 1">Sí</span>
                                        <span v-else>No</span>
                                    </div>
                                </td>
                                <td class="border-t max-w-80">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        tabindex="-1">
                                        <span v-if="detalle.devuelto == 1">Sí</span>
                                        <span v-else>No</span>
                                    </div>
                                </td>
                                <td class="border-t max-w-80">
                                    <div
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        tabindex="-1">
                                        <span v-if="detalle.puntos_devolucion">
                                            {{ detalle.puntos_devolucion }}
                                        </span>
                                        <span v-else>sin devolver</span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr v-else class="focus-within:bg-gray-100">
                            <td colspan="7" class="inline-block pl-8 py-5">
                                No se encontraron detalles de entregas
                            </td>
                        </tr>
                    </transition-group>
                </table>
            </div>
            <div class="flex items-center gap-3 mt-4" v-if="$page.props.userRole.role !== 'alumno'">
                <a
                    :href="route('clases.unidades.acumulativos.pdf',
                           {clase: clase, unidad: unidad,})"
                    class="h-10 w-32 rounded-md shadow-md bg-gray-100 flex items-center justify-center hover:bg-gray-200 cursor-pointer"
                    target="_blank">
                    <span class="font-bold text-sm">Exportar PDF</span>
                </a>
            </div>
        </div>
    </AppLayout>
</template>
