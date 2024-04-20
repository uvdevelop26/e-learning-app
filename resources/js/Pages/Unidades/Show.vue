<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import Anuncio from "../../Components/Anuncio.vue";

const props = defineProps({
    unidadesYanuncios: Array,
    errors: Object,
});


</script>
<template>
    <AppLayout>
        <Head :title="`Unidad ${unidadesYanuncios.numero}`" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center"
            >
                <span>
                    Unidad Número {{ unidadesYanuncios.numero }} -
                    {{ unidadesYanuncios.tema }}
                </span>
            </h2>
        </template>
        <div class="py-9 px-4 lg:px-8 max-w-7xl">
            <!-- content -->
            <div class="mt-6 flex flex-col gap-6 lg:flex-row">
                <!-- options  -->
                <div class="flex gap-6 items-center lg:flex-col lg:items-start">
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group hover:shadow-md"
                    >
                        <a
                            class="absolute top-0 left-0 right-0 bottom-0"
                            target="_blank"
                            tabindex="-1"
                        >
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2"
                            >
                                <span
                                    class="block pb-3 group-hover:text-primary"
                                >
                                    Plan de Estudio
                                </span>
                                <icon
                                    name="pdf"
                                    class="w-6 h-6 mx-auto fill-black group-hover:fill-primary"
                                />
                            </div>
                        </a>
                    </div>
                    <!-- opion persona page -->
                    <div
                        class="w-36 h-32 bg-white shadow py-4 border rounded-xl text-sm relative group hover:shadow-md"
                    >
                        <Link
                            class="absolute top-0 left-0 right-0 bottom-0"
                            tabindex="-1"
                        >
                            <div
                                class="font-bold w-full text-center absolute top-1/2 -translate-y-1/2"
                            >
                                <span
                                    class="block pb-3 group-hover:text-primary"
                                >
                                    Personas
                                </span>
                                <icon
                                    name="user"
                                    class="w-6 h-6 mx-auto fill-black group-hover:fill-primary"
                                />
                            </div>
                        </Link>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-6">
                    <editor-wrapper
                        title="Anuncia algo a tu clase.."
                        :unidade="unidadesYanuncios"
                        :errors="errors"
                        @newpost="newpost"
                    />

                    <Anuncio
                        v-for="anuncios in unidadesYanuncios.anuncios"
                        :key="anuncios.id"
                        :data="anuncios"
                        :errors="errors"
                        :unidade_id="unidadesYanuncios.id"
                        @updateanuncios="updateanuncios"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
