<script setup>
import Icon from "./Icon.vue";
import Dropdown from "./Dropdown.vue";
import Comentarios from "./Comentarios.vue";
import Modal from "./Modal.vue";
import TextInput from "./TextInput.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import { ref, getCurrentInstance } from "vue";
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    data: Object,
    clase_id: Number,
    errors: Object,
});

const open = ref(false);
const openModal = ref(false);
const { emit } = getCurrentInstance();
const { auth } = usePage().props;

const form = useForm({
    _method: "PUT",
    id: props.data.id,
    titulo: props.data.titulo,
    descripcion: props.data.descripcion,
    user_id: auth.user.id,
    anunciable_id: props.clase_id,
    anunciable_type: "",
});

const options = {
    placeholder: "Escribe el contenido...",
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
        ],
    },
};

const cancelProcess = () => {
    openModal.value = false;
    props.errors.titulo = "";
};

const updateanuncios = () => {
    emit("updateanuncios");
};

const setOpenModal = () => {
    form.id = props.data.id;
    form.titulo = props.data.titulo;
    form.descripcion = props.data.descripcion;
    form.user_id = auth.user.id;
    form.anunciable_id = props.clase_id,

    openModal.value = true
};

const update = () => {
    form.post(route("anuncios.update", form), {
        preserveScroll: true,
        onSuccess: () => {
            cancelProcess();
            emit("updateanuncios");
        },
    });
};

const deleteAnuncio = () => {
    router.delete(route("anuncios.destroy", props.data.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updateanuncios");
        },
    });
};
</script>
<template>
    <div class="w-full p-4 rounded-xl border shadow bg-white group">
        <!-- header data -->
        <div class="flex items-center justify-between gap-4">
            <div class="w-full">
                <h3 class="py-1 font-bold uppercase">
                    {{ data.titulo }}
                </h3>
                <p class="text-sm">{{ data.descripcion }}</p>
            </div>
            <dropdown class="self-start">
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
                        <button
                            class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                            type="button"
                            @click="deleteAnuncio()">
                            Eliminar
                        </button>
                    </div>
                </template>
            </dropdown>
        </div>
        <!-- comments sectios -->
        <Comentarios
            class="mt-3 border-t"
            :comentarios="data.comentarios"
            :anuncio_id="data.id"
            @updateanuncios="updateanuncios"
        />
    </div>
    <!-- modal -->
    <Modal :show="openModal">
        <template #headerModal>
            <h3 class="text-lg">Editar Anuncio</h3>
        </template>
        <template #bodyModal>
            <form @submit.prevent="update">
                <text-input
                    class="pb-3 pr-6 w-full"
                    id="titulo"
                    placeholder="Ingresa el título del Anuncio"
                    v-model="form.titulo"
                    :error="errors.titulo"
                />
                <QuillEditor
                    theme="snow"
                    :options="options"
                    style="height: 120px"
                    ref="editorRef"
                    v-model:content="form.descripcion"
                    contentType="text"
                />
                <div class="py-2 border-t-3">
                    <label
                        for="imagen"
                        class="flex justify-center items-center w-11 h-11 rounded-full cursor-pointer bg-indigo-100">
                        <icon name="upload" class="w-4 h-4 fill-primary" />
                        <input
                            type="file"
                            id="imagen"
                            class="opacity-0 absolute -z-10"
                        />
                    </label>
                </div>
                <!-- options -->
                <div class="pt-4 border-t-2 flex justify-between">
                    <button
                        class="inline-block px-8 py-2 text-red-500 hover:underline"
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
    </Modal>
</template>
