<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import SearchFilter from "../../Components/SearchFilter.vue";
import Pagination from "../../Components/Pagination.vue";
import { reactive, watchEffect } from "vue";
import { pickBy } from "lodash";
import { router } from "@inertiajs/vue3";
import gsap from "gsap";
import { onMounted  } from "vue";

const props = defineProps({
    materias: Array,
    filters: Object
});

const form = reactive({
    search: props.filters.search,
    page: 1
});

const reset = () => {
    form.search = null;
    form.page = 1;
    router.replace(route('materias.index', {}));
};

watchEffect(() => {
    const query = pickBy(form);
    router.replace(
        route("materias.index", Object.keys(query).length ? query : {})
    );
});

/* animation */
const beforeEnter = (el) => {
    el.style.transform = "translateX(-60px)";
    el.style.opacity = 0;
};

const enter = (el, done) => {
    gsap.to(el, {
        duration: 0.4,
        x: 0,
        opacity: 1,
        onComplete: done,
        delay: el.dataset.index * 0.2
    });
};

onMounted(() => {
    if (props.filters.page) {
        form.page = props.filters.page;
    }
});

</script>

<template>
    <AppLayout>
        <Head title="Carreras" />

        <template #header>
            <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                    <Icon name="homework" class="w-2 h-2 fill-white" />
                </div>
                Académicos / Materias
            </h2>
        </template>
        <!-- -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="flex items-center justify-between mb-6">
                <div class="w-full h-10 flex items-center gap-4">
                    <div class="h-full w-20 bg-white border-2 shadow-md flex rounded-md">
                        <a :href="route('materias.pdf', pickBy(form))" target="_blank" class="h-full w-full text-sm font-bold flex items-center justify-center border-r hover:bg-gray-100">PDF</a>
                        <!-- <a href="#" 
                        class="h-full w-full text-sm font-bold flex items-center justify-center hover:bg-gray-100">XLS</a> -->
                    </div>
                    <search-filter
                        v-model="form.search"
                        class="mr-4 w-full max-w-md"
                        @reset="reset">
                  </search-filter> 
                </div>  
                <Link class="btn-indigo" href="/materias/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Materia</span>
                </Link>
            </div>
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
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
                    <transition-group tag="tbody" appear @before-enter="beforeEnter" @enter="enter">
                        <tr
                            v-for="(materia, index) in materias.data"
                            v-if="materias.data.length"
                            :key="materia.id"
                            :data-index="index"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('materias.edit', materia.id)">
                                    {{ materia.codigo }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('materias.edit', materia.id)">
                                    {{ materia.nombre }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('materias.edit', materia.id)">
                                    <div>{{ materia.horas_semanales }}</div>
                                </Link>
                            </td>

                            <td class="border-t max-w-80">
                                <a
                                    :href="`materias/download/${materia.id}`"
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    target="_blank"
                                    tabindex="-1">
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
                                    :href="route('materias.edit', materia.id)">
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
                                    :href="route('materias.edit', materia.id)">
                                    <div>{{ materia.descripcion }}</div>
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    tabindex="-1"
                                    :href="route('materias.edit', materia.id)">
                                    <icon
                                        name="cheveron-right"
                                        class="block w-6 h-6 fill-gray-400"
                                    />
                                </Link>
                            </td>
                        </tr>
                        <tr
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                            v-else>
                            <span class="inline-block pl-8 py-5">
                                No se encuentran resultados
                            </span>
                        </tr>
                    </transition-group>
                </table>
            </div>
            <pagination class="mt-6" :links="materias.links" @change-page="page => form.page = page" />
        </div>
    </AppLayout>
</template>
