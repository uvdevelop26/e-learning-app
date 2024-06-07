<script setup>
import { onMounted, ref } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { usePage } from "@inertiajs/vue3";
import { imageUrl } from "../../../data/handleFiles";

const props = defineProps({
    user: Object,
    userWrole: Array,
});


const { props: pageProps } = usePage();

const form = useForm({
    _method: "PUT",
    id: props.user.id,
    nombre: "",
    apellido: "",
    telefono: "",
    direccion: "",
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("profile.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

onMounted(() => {
    const userRole = pageProps.userRole.role;

    if (userRole == "administrador") {
        form.nombre = props.user.administradores[0].persona.nombre;
        form.apellido = props.user.administradores[0].persona.apellido;
        form.telefono = props.user.administradores[0].persona.telefono;
        form.direccion = props.user.administradores[0].persona.direccion;
    }else if (userRole == "alumno"){
        form.nombre = props.user.alumnos[0].persona.nombre;
        form.apellido = props.user.alumnos[0].persona.apellido;
        form.telefono = props.user.alumnos[0].persona.telefono;
        form.direccion = props.user.alumnos[0].persona.direccion;
    }else if(userRole == "docente"){
        form.nombre = props.user.docentes[0].persona.nombre;
        form.apellido = props.user.docentes[0].persona.apellido;
        form.telefono = props.user.docentes[0].persona.telefono;
        form.direccion = props.user.docentes[0].persona.direccion;
    }
});
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #form>
            <!-- Profile Photo -->
            <div
                v-if="$page.props.jetstream.managesProfilePhotos"
                class="col-span-6 sm:col-span-4">
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                />

                <InputLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img v-if="user.profile_photo_path"
                        :src="imageUrl(user.profile_photo_path)"
                        :alt="user.email"
                        class="rounded-full h-20 w-20 object-cover"
                    />
                    <img
                        v-else
                        src="https://static.vecteezy.com/system/resources/thumbnails/009/734/564/small_2x/default-avatar-profile-icon-of-social-media-user-vector.jpg"
                        :alt="user.email"
                        class="rounded-full h-20 w-20 object-cover"
                    />
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <SecondaryButton
                    class="mt-2 mr-2"
                    type="button"
                    @click.prevent="selectNewPhoto">
                    Selecciona una nueva Foto
                </SecondaryButton>

                <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto">
                    Eliminar Foto
                </SecondaryButton>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>
            <!-- nombre -->

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="nombre" value="Nombre" />
                <TextInput
                    id="nombre"
                    v-model="form.nombre"
                    type="text"
                    class="mt-1 block w-full"
                    disabled
                />
                <InputError :message="form.errors.nombre" class="mt-2" />
            </div>

            <!-- apellidos -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="apellido" value="Apellido" />
                <TextInput
                    id="nombre"
                    v-model="form.apellido"
                    type="text"
                    disabled
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.apellido" class="mt-2" />
            </div>

            <!-- Teléfono -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="telefono" value="Telefono" />
                <TextInput
                    id="telefono"
                    v-model="form.telefono"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.telefono" class="mt-2" />
            </div>
            <!-- direccion -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="direccion" value="Dirección" />
                <TextInput
                    id="direccion"
                    v-model="form.direccion"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.direccion" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />

                <!-- if has email verification -->
                <div
                    v-if="
                        $page.props.jetstream.hasEmailVerification &&
                        user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification">
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div
                        v-show="verificationLinkSent"
                        class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email
                        address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <!-- <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Guardar.
            </ActionMessage> -->

            <button
                class="btn-indigo"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Guardar
            </button>
        </template>
    </FormSection>
</template>
