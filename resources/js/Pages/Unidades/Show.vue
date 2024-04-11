<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import Icon from "../../Components/Icon.vue";
import EditorWrapper from "../../Components/EditorWrapper.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const props = defineProps({
    unidade: Array,
});

//QuillEditor Options
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
</script>
<template>
    <AppLayout>
        <Head :title="`Unidad ${unidade.numero}`" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 flex justify-between items-center">
                <span>
                    Unidad Número {{ unidade.numero }} - {{ unidade.tema }}
                </span>
                <!--    <button @click="show = !show">
                    <icon name="plus" class="h-4 w-4 fill-primary" />
                </button> -->
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <!-- <editor-wrapper
                title="Anuncia algo a tu clase..."
                @enviar="enviar"
                @cancelar="cancelar"
            >
                <template #content>
                    <form>
                        <text-input
                            class="hidden"
                            id="titulo"
                            placeholder="Ingresa el título del Anuncio"
                        />
             v-model="form.user_id" -
                        <text-input
                            class="pb-3 pr-6 w-full"
                            id="titulo"
                            placeholder="Ingresa el título del Anuncio"
                        />
                
                        <QuillEditor
                            theme="snow"
                            :options="options"
                            style="height: 120px"
                            ref="editorRef"
                        />
               
                        <div class="py-2 border-t-3">
                            <label
                                for="imagen"
                                class="flex justify-center items-center w-11 h-11 rounded-full cursor-pointer bg-indigo-100"
                            >
                                <icon
                                    name="upload"
                                    class="w-4 h-4 fill-primary"
                                />
                                <input
                                    type="file"
                                    id="imagen"
                                    class="opacity-0 absolute -z-10"
                                />
                            </label>
                        </div>
                    </form>
                </template>
            </editor-wrapper> -->
        </div>
    </AppLayout>
</template>
