<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import SearchFilter from "../../Components/SearchFilter.vue";
import { reactive, watchEffect } from "vue";
import { pickBy } from "lodash";
import { router } from "@inertiajs/vue3";
import gsap from "gsap";

const props = defineProps({
    carreras: Array,
    filters: Object,
});

const form = reactive({
    search: props.filters.search,
});

const reset = () => {
    form.search = null;
};

watchEffect(() => {
    const query = pickBy(form);
    router.replace(
        route("carreras.index", Object.keys(query).length ? query : {})
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
        delay: el.dataset.index * 0.2,
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Carreras" />

        <template #header>
            <h2
                class="font-semibold text-xl text-primary flex items-center gap-4">
                <div
                    class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                    <Icon name="homework" class="w-2 h-2 fill-white" />
                </div>
                Académicos / Carreras
            </h2>
        </template>
        <!-- -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="flex items-center justify-between mb-6">
                <search-filter
                    v-model="form.search"
                    class="mr-4 w-full max-w-md"
                    @reset="reset">
                </search-filter>
                <Link class="btn-indigo" href="/carreras/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Carrera</span>
                </Link>
            </div>
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Código</th>
                            <th class="pb-4 pt-6 px-6">Nombre</th>
                            <th class="pb-4 pt-6 px-6">Duracion</th>
                            <th class="pb-4 pt-6 px-6">Descripcion</th>
                        </tr>
                    </thead>
                    <transition-group
                        tag="tbody"
                        appear
                        @before-enter="beforeEnter"
                        @enter="enter">
                        <tr
                            v-for="(carrera, index) in carreras"
                            :key="carrera.id"
                            :data-index="index"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('carreras.edit', carrera.id)">
                                    {{ carrera.codigo }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('carreras.edit', carrera.id)">
                                    {{ carrera.nombre }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('carreras.edit', carrera.id)">
                                    <div>{{ carrera.duracion }}</div>
                                </Link>
                            </td>

                            <td class="border-t max-w-80">
                                <Link
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('carreras.edit', carrera.id)">
                                    <div>{{ carrera.descripcion }}</div>
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    tabindex="-1"
                                    :href="route('carreras.edit', carrera.id)">
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
