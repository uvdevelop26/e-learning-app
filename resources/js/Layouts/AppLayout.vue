<script setup>
import { ref, onMounted, onUnmounted, reactive } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Icon from "../Components/Icon.vue";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import MenuNav from "../Components/MenuNav.vue";

defineProps({
    title: String,
});

const isMobile = ref(null);
let mql = null;

const linkList = reactive([
    { id: 1, name: "dashboard", href: "dashboard" },
    {
        id: 2,
        name: "usuarios",
        href: "..",
        submenu: [
            { name: "alumnos", href: "alumnos" },
            { name: "docentes", href: "docentes" },
            { name: "administradores", href: "administradores" },
        ],
        toggle_submenu: false,
    },
    {
        id:3,
        name: "académicos",
        href: "...",
        submenu:[
            {name: "carreras", href: "carreras"}
        ]
    }
]);

const handleSubmenu = (index) => {
    linkList[index].toggle_submenu = !linkList[index].toggle_submenu
};

const handleMqlChange = (e) => {
    isMobile.value = e.matches;
};

onMounted(() => {
    mql = window.matchMedia("(min-width: 1024px)");
    isMobile.value = mql.matches;

    mql.addEventListener("change", handleMqlChange);

    console.log(mql);
});

onUnmounted(() => {
    mql.removeEventListener("change", handleMqlChange);
});

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="md:h-screen">
            <div class="lg:flex lg:flex-grow">
                <nav class="text-gray-500 lg:flex-shrink-0 lg:w-56 lg:h-screen lg:shadow-lg">
                    <div class="bg-primary px-4 py-4 flex justify-between">
                        <Link :href="route('dashboard')">
                            <ApplicationMark class="block h-9 w-auto" />
                        </Link>
                        <button class="cursor-pointer lg:hidden" @click="isMobile = !isMobile">
                            <Icon name="hamburger" />
                        </button>
                    </div>
                    <MenuNav :showDropdown="isMobile">
                        <template #content>
                            <ul class="">
                                <li v-for="(links, index) in linkList" :key="links.id" class="capitalize">
                                    <NavLink :href="links.href" :active="route().current(links.href)" v-if="!links.submenu">
                                        {{ links.name }}
                                    </NavLink>
                                    <NavLink as="button" v-else class="flex gap-2 capitalize" @click="handleSubmenu(index)">
                                        <Icon class="h-3 w-3 fill-primary" name="plus"/>
                                        {{ links.name }}
                                    </NavLink>
                                    <ul v-if="links.submenu && links.toggle_submenu" class="pl-3">
                                        <li v-for="submenu in links.submenu"
                                            class="capitalize border-l-2">
                                            <NavLink :href="submenu.href" :active="route().current(submenu.href)">
                                                {{ submenu.name }}
                                            </NavLink>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </template>
                        <template #authData>
                            <div class="mt-4 border-t">
                                <div class="pt-1 border-gray-200">
                                    <div class="flex items-center px-3">
                                        <div class="shrink-0 mr-3">
                                            <img
                                                class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url"
                                                :alt="$page.props.auth.user.name"
                                            />
                                        </div>
                                        <div>
                                            <div class="font-medium text-base text-gray-800">
                                                {{ $page.props.auth.user.name }}
                                            </div>
                                            <div class="font-medium text-xs text-gray-500">
                                                {{
                                                    $page.props.auth.user.email
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        Cerrar Sesión
                                    </DropdownLink>
                                </form>
                            </div>
                        </template>
                    </MenuNav>
                </nav>
                <!-- Page  -->
                <div
                    class="bg-gray-100 lg:pt-10 lg:flex-1 lg:h-screen lg:overflow-y-auto"
                    scroll-region
                >
                    <!-- Page Header -->
                    <header
                        v-if="$slots.header"
                        class="bg-white w-full shadow lg:fixed lg:top-0"
                    >
                        <div class="max-w-7xl py-5 px-12">
                            <slot name="header" />
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main>
                        <slot />
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
