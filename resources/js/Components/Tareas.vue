<script setup>
import { ref, getCurrentInstance } from "vue";
import Dropdown from "./Dropdown.vue";
import Icon from "./Icon.vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import moment from "moment-timezone";

const props = defineProps({
    data: Object,
    errors: Object,
    clase_id: Number,
    unidade_id: Number,
});

const open = ref(false);

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
                <h3 class="font-bold capitalize">
                    <Link
                        :href="
                            route('clases.unidades.tareas.show', {
                                clase: clase_id,
                                unidad: unidade_id,
                                tarea: data.id,
                            })"
                        class="block py-2 group-hover:text-primary">
                        <span>Tarea {{ data.titulo }}</span> &nbsp;
                        <span class="text-sm text-gray-500">
                            Fecha de Entrega:
                            {{ moment.tz(data.fecha_entrega, "America/Asuncion").format("DD-MM-YYYY") }} -
                            {{ data.hora_entrega }}hs.
                        </span>
                    </Link>
                </h3>
            </div>
            <!-- dropdown -->
            <dropdown v-if="$page.props.userRole.role !== 'alumno'">
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
</template>
