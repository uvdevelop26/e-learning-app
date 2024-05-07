<script setup>
import { ref, getCurrentInstance } from "vue";
import Dropdown from "./Dropdown.vue";
import TextInput from "./TextInput.vue";
import TextArea from "./TextArea.vue";
import Modal from "./Modal.vue";
import Icon from "./Icon.vue";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

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

const setOpenModal = () => {
    form.id = props.data.id;
    form.numero = props.data.numero;
    form.tema = props.data.tema;
    form.objetivos = props.data.objetivos;
    form.clase_id = props.clase_id;
    openModal.value = true;
};

const update = () => {
    form.post(route("unidades.update", form), {
        preserveScroll: true,
        onSuccess: () => {
            cancelProcess();
            emit("updateunidad");
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
                        class="block py-2 group-hover:text-primary"
                        :href="route('clases.unidades.show', { clase: data.clase_id, unidad: data.id })">
                        Unidad Número {{ data.numero }} - {{ data.tema }}
                    </Link>
                </h3>
            </div>
            <!-- dropdown options -->
            <dropdown v-if="$page.props.userRole.role.rol !== 'alumno'">
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
                            @click="setOpenModal()">
                            Editar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
    </div>
    <!-- modal -->
    <modal :show="openModal">
        <template #headerModal>
            <h3 class="px-2 text-xl text-primary font-bold">Editar Unidad</h3>
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
                        v-model="form.objetivos">
                    </text-area>
                </div>
                <div
                    class="flex items-center justify-between pt-4 bg-gray-50 border-t border-gray-100">
                    <button
                        class="px-3 text-red-500 hover:underline"
                        type="button"
                        @click="cancelProcess()">
                        Cancelar
                    </button>
                    <button
                        class="px-6 py-3 rounded text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-orange-400 focus:bg-orange-400"
                        :class="{
                            'bg-gray-400': form.processing,
                            'bg-primary': !form.processing,
                        }"
                        type="submit"
                        :disabled="form.processing">
                        Actualizar
                    </button>
                </div>
            </form>
        </template>
    </modal>
</template>
