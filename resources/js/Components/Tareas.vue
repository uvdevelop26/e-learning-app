<script setup>
import { ref, getCurrentInstance } from "vue";
import Dropdown from "./Dropdown.vue";
import TextInput from "./TextInput.vue";
import TextArea from "./TextArea.vue";
import Modal from "./Modal.vue";
import Icon from "./Icon.vue";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { format } from "date-fns";
import { router } from "@inertiajs/vue3";


const props = defineProps({
    data: Object,
    errors: Object,
    clase_id: Number,
    unidade_id: Number
});

const form = useForm({
    _method: "PUT",
    id: "",
    titulo: "",
    instruccion: "",
    fecha_entrega: "",
    hora_entrega: "",
    puntos: "",
    unidade_id: "",
});

const open = ref(false);
const openModal = ref(false);
const formattedDate = ref(
    format(new Date(props.data.fecha_entrega), "dd-MM-yyyy")
);
const { emit } = getCurrentInstance();


const deleteTarea = () => {
    router.delete(route("tareas.destroy", props.data.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updatetarea");
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
                        :href="route('clases.unidades.tareas.show', { clase: clase_id, unidad: unidade_id, tarea: data.id })"
                        class="block py-2 group-hover:text-primary">
                        Tarea {{ data.titulo }} - Fecha entrega
                        {{ data.fecha_entrega }}
                    </Link>
                </h3>
            </div>
            <!-- dropdown -->
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
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button"
                            @click="deleteTarea()">
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
    </div>
    <!-- Modal -->
    
</template>
