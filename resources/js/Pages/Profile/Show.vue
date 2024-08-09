<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Icon from "../../Components/Icon.vue";
import { Link, Head } from "@inertiajs/vue3";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    user: Array,
});
</script>

<template>
    <AppLayout title="Perfil">
        <Head title="Perfil" />

        <template #header>
            <h2
                class="font-semibold font-mono text-xl text-primary flex items-center gap-4">
                <div
                    class="w-7 h-7 flex items-center justify-center rounded-full bg-primary border shadow-md">
                    <Icon name="user" class="w-2 h-2 fill-white" />
                </div>
                Perfil
            </h2>
        </template>
        <div class="py-12 px-4 lg:px-8 max-w-7xl">
            <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                <UpdateProfileInformationForm :user="user" />

                <SectionBorder />
            </div>
            <div v-if="$page.props.jetstream.canUpdatePassword">
                <UpdatePasswordForm class="mt-10 sm:mt-0" />

                <SectionBorder />
            </div>
        </div>
    </AppLayout>
</template>
