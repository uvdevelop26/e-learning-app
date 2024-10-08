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
    administradores: Array,
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
        route("administradores.index", Object.keys(query).length ? query : {})
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

</script>

<template>
    <AppLayout>
        <Head title="Administradores" />

        <template #header>
            <h2 class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                <div class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                    <Icon name="user" class="w-2 h-2 fill-white" />
                </div> 
                Usuarios / Administradores
            </h2>
        </template>
        <!-- -->
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div class="flex items-center justify-between mb-6">
                <div class="w-full h-10 flex items-center gap-4">
                    <div class="h-full w-20 bg-white border-2 shadow-md flex rounded-md">
                        <a :href="route('administradores.pdf')"
                        target="_blank" 
                        class="h-full w-full text-sm font-bold flex items-center justify-center border-r hover:bg-gray-100">PDF</a>
                        <!-- <a href="" 
                        class="h-full w-full text-sm font-bold flex items-center justify-center hover:bg-gray-100">XLS</a> -->
                    </div>  
                    <search-filter
                        v-model="form.search"
                        class="mr-4 w-full max-w-md"
                        @reset="reset">
                  </search-filter> 
                </div>
                <Link class="btn-indigo" href="/administradores/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Administrador</span>
                </Link>
            </div>
            <div class="w-full bg-white overflow-x-auto rounded-md shadow">
                <table
                    class="w-full whitespace-nowrap text-sm rounded-md shadow-md">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Nombre</th>
                            <th class="pb-4 pt-6 px-6">CI</th>
                            <th class="pb-4 pt-6 px-6">Teléfono</th>
                            <th class="pb-4 pt-6 px-6">Dirección</th>
                            <th class="pb-4 pt-6 px-6">Cargo</th>
                            <th class="pb-4 pt-6 px-6">Correo</th>
                            <th class="pb-4 pt-6 px-6">Estado</th>
                        </tr>
                    </thead>
                    <transition-group tag="tbody" appear @before-enter="beforeEnter" @enter="enter">
                        <tr
                            v-for="(administradore, index) in administradores"
                            :key="administradore.id"
                            :data-index="index"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('administradores.edit', administradore.id)">
                                    {{ administradore.persona.nombre }}
                                    {{ administradore.persona.apellido }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
                                    <div>
                                        {{ administradore.persona.ci_numero }}
                                    </div>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
                                    <div>
                                        {{ administradore.persona.telefono }}
                                    </div>
                                </Link>
                            </td>
                            <td class="border-t max-w-80">
                                <Link
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
                                    <div>
                                        {{ administradore.persona.direccion }}
                                    </div>
                                </Link>
                            </td>
                            <td class="border-t max-w-80">
                                <Link
                                    class="flex items-center px-6 py-4 whitespace-normal"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
                                    <div>{{ administradore.cargo }}</div>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
                                    <div>{{ administradore.user.email }}</div>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
                                    <div>
                                        {{ administradore.estado.estado }}
                                    </div>
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    tabindex="-1"
                                    :href="route('administradores.edit', administradore.id)">
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
