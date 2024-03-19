<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import Card from "../../Components/Card.vue";
import Dropdown from "../../Components/Dropdown.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    clase: Array,
    materia: Array,
    semestre: Array,
    carrera: Array,
});
</script>

<template>
    <AppLayout>
        <Head title="Carreras" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center"
            >
                <span>
                    {{ carrera.nombre }}
                </span>
                <!-- <button>
                    <icon name="plus" class="w-5 h-5 fill-primary hover:fill-secondary" />
                </button> -->
            </h2>
        </template>
        <div
            class="py-12 px-4 mx-auto bg-white border h-screen lg:px-8 max-w-7xl"
        >
            <div class="h-full flex flex-col gap-6">
                <div
                    class="h-56 bg-primary rounded-2xl flex flex-col items-center justify-center"
                >
                    <span
                        class="inline-block text-3xl lg:text-5xl text-white"
                        >{{ props.materia.nombre }}</span
                    >
                    <span class="inline-block text-xl lg:text-2xl text-white"
                        >Semestre {{ props.semestre.nombre }}</span
                    >
                    <span class="inline-block text-lg lg:text-xl text-white"
                        >Clase {{ props.clase.codigo }}</span
                    >
                    
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-full flex justify-center gap-6 lg:flex-col lg:justify-start">
                        <div
                            class="w-36 h-36 border rounded-xl flex flex-col items-center justify-center text-sm"
                        >
                            <span class="font-bold text-primary">Próximas Entregas</span>
                            {{ clase.codigo }}
                        </div>
                        <div
                            class="w-36 h-36 border rounded-xl flex flex-col items-center justify-center text-sm"
                        >
                            <span class="font-bold text-primary"
                                >Plan de Estudio</span
                            >
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
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
            <!-- <div class="flex items-center mb-6">
               <search-filter
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
                </search-filter>
                <Link class="btn-indigo" href="/clases/create">
                    <span>Crear</span>
                    <span class="hidden md:inline">&nbsp;Clase</span>
                </Link>
            </div> -->
        </div>
    </AppLayout>
</template>
