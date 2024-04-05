<script setup>
import { ref, getCurrentInstance } from "vue";
import Dropdown from "./Dropdown.vue";
import TextInput from "./TextInput.vue";
import TextArea from "./TextArea.vue";
import Modal from "./Modal.vue";
import Icon from "./Icon.vue";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    data: Object,
    errors: Object,
    clase_id: Number,
});

const open = ref(false);
const openModal = ref(false);
const { emit } = getCurrentInstance();

const form = useForm({
    _method: "PUT",
    id: props.data.id,
    numero: props.data.numero,
    tema: props.data.tema,
    objetivos: props.data.objetivos,
    clase_id: props.clase_id,
});

const cancelProcess = () => {
    openModal.value = false;
    props.errors.tema = "";
};

const update = () => {
    form.post(route("unidades.update", form), {
        preserveScroll: true,
        onSuccess: () => {
            cancelProcess();
            emit("updateunidades");
        },
    });
};

const deleteUnidad = () => {
    router.delete(route("unidades.destroy", form.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updateunidades");
        },
    });
};
</script>
<template>
    <div
        class="w-full p-4 rounded-xl border shadow bg-white group hover:shadow-md">
        <div class="flex items-center justify-between gap-4">
            <!-- data -->
            <div class="w-full">
                <h3 class="font-bold uppercase">
                    <Link
                        :href="route('unidades.show', data.id)"
                        class="block py-2 group-hover:text-primary">
                        Unidad Número {{ data.numero }} -
                        {{ data.tema }}
                    </Link>
                </h3>
            </div>
            <!-- dropdown options -->
            <dropdown>
                <template #trigger>
                    <div class="text-right">
                        <button
                            :open="open"
                            class="flex pb-2 justify-center items-center h-7 w-7 rounded-full hover:bg-indigo-100 focus:bg-indigo-100">
                            <icon
                                name="trigger"
                                class="inline-block w-[0.18rem] h-[0.18rem] fill-primary"
                            />
                        </button>
                    </div>
                </template>
                <template #content>
                    <div class="p-3">
                        <button
                            class="inline-block text-left py-2 font-bold w-full h-full text-primary hover:underline"
                            @click="openModal = true">
                            Editar
                        </button>
                        <button
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button"
                            @click="deleteUnidad()">
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
    </div>
    <!-- modal -->
    <modal :show="openModal">
        <template #headerModal>
            <h3 class="text-lg">Editar Unidad</h3>
        </template>
        <template #bodyModal>
            <form @submit.prevent="update">
                <div class="bg-white flex flex-wrap -mb-8 -mr-6 rounded-md">
                    <text-input
                        class="pb-8 pr-6 w-full"
                        label="Número Unidad"
                        id="numero"
                        v-model="form.numero"
                        :error="errors.numero"
                        disabled
                    />
                    <text-input
                        class="pb-8 pr-6 w-full"
                        label="Tema"
                        id="tema"
                        :error="errors.tema"
                        v-model="form.tema"
                    />
                    <text-area
                        id="objetivos"
                        class="pb-8 pr-6 w-full"
                        label="Objetivos"
                        :error="errors.objetivos"
                        v-model="form.objetivos"
                    >
                    </text-area>
                </div>
                <div
                    class="flex items-center justify-between pt-4 bg-gray-50 border-t border-gray-100">
                    <button
                        class="px-3 text-red-500 hover:underline"
                        type="button"
                        @click="cancelProcess">
                        Cancelar
                    </button>
                    <button
                        class="px-7 py-1 bg-primary hover:bg-orange-400 text-white rounded-md"
                        type="submit"
                        :disabled="form.processing">
                        Actualizar
                    </button>
                </div>
            </form>
        </template>
    </modal>
</template>
