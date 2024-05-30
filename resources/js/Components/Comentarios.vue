<script setup>
import Icon from "./Icon.vue";
import Dropdown from "./Dropdown.vue";
import { useForm } from "@inertiajs/vue3";
import { watchEffect, ref, getCurrentInstance } from "vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import moment from "moment-timezone";

const props = defineProps({
    comentarios: Array,
    anuncio_id: Number,
    tarea_id: Number,
});

const hiddeComments = ref(true);
const buttonDisabled = ref(true);
const buttonEditDisabled = ref(false);
const { auth } = usePage().props;
const { emit } = getCurrentInstance();
const editing = ref(false);
const comentIndex = ref(null);

const form = useForm({
    contenido: "",
    comentable_id: "",
    comentable_type: "",
    user_id: auth.user.id,
});

const formEdit = useForm({
    _method: "PUT",
    id: "",
    contenido: "",
    comentable_id: "",
    comentable_type: "",
    user_id: auth.user.id,
});

watchEffect(() => {
    const contenido = form.contenido;

    if (contenido !== "") {
        buttonDisabled.value = false;
    } else {
        buttonDisabled.value = true;
    }
});

const setEditData = (data, index) => {
    comentIndex.value = index;
    formEdit.id = data.id;
    formEdit.contenido = data.contenido;

    setTimeout(() => {
        editing.value = true;
    }, 300);
};

const submit = () => {
    const comentableId = props.anuncio_id ? props.anuncio_id : props.tarea_id;
    const comentableType = props.anuncio_id
        ? "App\\Models\\Anuncio"
        : "App\\Models\\Tarea";

    form.comentable_id = comentableId;
    form.comentable_type = comentableType;

    form.post(route("comentarios.store"), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updateanuncios");
            form.contenido = "";
        },
    });
};

const update = () => {
    //formEdit.anuncio_id = props.anuncio_id;
    const comentableId = props.anuncio_id ? props.anuncio_id : props.tarea_id;
    const comentableType = props.anuncio_id
        ? "App\\Models\\Anuncio"
        : "App\\Models\\Tarea";

    formEdit.comentable_id = comentableId;
    formEdit.comentable_type = comentableType;

    formEdit.post(route("comentarios.update", formEdit), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updateanuncios");
            formEdit.contenido = "";
            setTimeout(() => {
                editing.value = false;
            }, 300);
        },
    });
};

const deleteData = (id) => {
    router.delete(route("comentarios.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("updateanuncios");
        },
    });
};
</script>
<template>
    <div>
        <div class="pt-2">
            <!-- Header comments -->
            <button class="flex gap-2" @click="hiddeComments = !hiddeComments">
                <icon name="comments" class="fill-primary w-4 h-4" />
                <span class="text-xs font-bold text-primary hover:underline">
                    {{ `${comentarios.length} comentario/s` }}
                </span>
            </button>
        </div>
        <!-- Comment lists -->
        <ul class="pt-2 flex flex-col gap-3">
            <li
                class="flex items-center gap-2"
                v-for="(comentario, index) in comentarios"
                :key="comentario.id"
                ref="commentsList"
                :class="{ hidden: index < 4 && hiddeComments }">
                <!-- Profile picture -->
                <div class="w-12 h-12 rounded-full self-start">
                    <img
                        src="https://static.vecteezy.com/system/resources/thumbnails/009/734/564/small_2x/default-avatar-profile-icon-of-social-media-user-vector.jpg"
                        alt="profilePicture"
                        class="w-full object-cover"
                    />
                </div>
                <!-- Name and Comment content -->
                <div class="mr-auto w-full whitespace-normal">
                    <p class="pb-1 font-bold text-xs capitalize" v-if="comentario.user.alumnos[0]">
                        {{ comentario.user.alumnos[0].persona.nombre }}
                        {{ comentario.user.alumnos[0].persona.apellido }}
                        <span class="text-xxs m-2 text-gray-400">
                            {{  moment.tz(comentario.created_at, "America/Asuncion").format("DD-MM-YYYY") }}
                        </span>
                    </p>
                    <p class="pb-1 font-bold text-xs capitalize" v-else-if="comentario.user.docentes[0]">
                        {{ comentario.user.docentes[0].persona.nombre }}
                        {{ comentario.user.docentes[0].persona.apellido }}
                        <span class="text-xxs m-2 text-gray-400">
                            {{  moment.tz(comentario.created_at, "America/Asuncion").format("DD-MM-YYYY") }}
                        </span>
                    </p>
                    <p class="pb-1 font-bold text-xs capitalize" v-else-if="comentario.user.administradores[0]">
                        {{ comentario.user.administradores[0].persona.nombre }}
                        {{ comentario.user.administradores[0].persona.apellido }}
                        <span class="text-xxs m-2 text-gray-400">
                            {{  moment.tz(comentario.created_at, "America/Asuncion").format("DD-MM-YYYY") }}
                        </span>
                    </p>
                    <p
                        class="text-xs whitespace-normal"
                        v-if="!editing || comentIndex !== index">
                        {{ comentario.contenido }}
                    </p>
                    <form
                        @submit.prevent="update"
                        v-if="editing && comentIndex == index">
                        <textarea
                            id="editcontenido"
                            class="p-1 m-0 h-11 overflow-y-auto whitespace-normal border-gray-200 outline-0 focus:outline-0 w-full text-xs rounded-lg resize-none focus:border-gray-500 focus:right-0"
                            v-model="formEdit.contenido">
                        </textarea>
                        <div class="py-2 flex justify-between items-center">
                            <button
                                class="px-3 text-red-500 hover:underline"
                                type="button"
                                @click="editing = false">
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
                </div>
                <!-- Dropdowm options -->
                <dropdown class="self-start" :width="'40'">
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
                                @click="setEditData(comentario, index)">
                                Editar
                            </button>
                            <button
                                class="inline-block py-2 text-left font-bold w-full h-full text-primary hover:underline"
                                type="button"
                                @click="deleteData(comentario.id)">
                                Eliminar
                            </button>
                        </div>
                    </template>
                </dropdown>
            </li>
        </ul>
        <!-- form comment -->
        <div>
            <form @submit.prevent="submit">
                <div class="pt-3 flex gap-3">
                    <div class="w-full">
                        <input
                            type="text"
                            id="cometario"
                            class="w-full text-sm border-gray-300 focus:border-secondary focus:ring-secondary rounded-2xl shadow-sm placeholder:text-xs placeholder:italic"
                            placeholder="Deja tu comentario..."
                            autocomplete="off"
                            v-model="form.contenido"
                        />
                    </div>
                    <button
                        class="w-9 h-9 pl-2 rounded-full focus:bg-indigo-100"
                        :class="{
                            'hover:bg-gray-100': buttonDisabled,
                            'hover:bg-indigo-100': !buttonDisabled,
                        }"
                        :disabled="buttonDisabled"
                        type="submit">
                        <icon
                            name="send"
                            class="w-4 h-4"
                            :class="{
                                'fill-gray-300': buttonDisabled,
                                'fill-primary': !buttonDisabled,
                            }"
                        />
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
