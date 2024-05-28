<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import { ref, watchEffect } from "vue";
import Modal from "../../Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    clase: Array,
});




</script>
<template>
    <AppLayout>
        <Head title="Acumulativos" />

        <template #header>
            <h2 class="font-semibold flex justify-between items-center">
                <span class="text-xl text-primary capitalize">
                    Puntajes Acumulados
                </span>
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div
                class="w-full p-4 rounded-xl border shadow bg-white group">
                
            </div>
        </div>
    </AppLayout>
</template>
