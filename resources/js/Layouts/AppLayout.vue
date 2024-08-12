<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Icon from "../Components/Icon.vue";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Dropdown from "../Components/Dropdown.vue";
import NavLink from "@/Components/NavLink.vue";
import MenuNav from "../Components/MenuNav.vue";
import { usePage } from "@inertiajs/vue3";
import menu from "../data/menu.js";
import FlashMessage from "../Components/FlashMessage.vue";
import { imageUrl } from "../data/handleFiles.js";

const props = defineProps({
    title: String,
});

const { props: pageProps } = usePage();

const isMobile = ref(null);
let mql = null;
const flashMessage = ref("");

const successMessage = computed(() => pageProps.flash.success);

const getUserRole = (role, index) => {
    return menu[index].role.includes(role);
};

const handleSubmenu = (index) => {
    menu[index].toggle_submenu = !menu[index].toggle_submenu;
};

const handleMqlChange = (e) => {
    isMobile.value = e.matches;
};

const getDataMenu = async () => {
    try {
        const data = await fetch("http://127.0.0.1:8000/dashboard/menuData");

        if (!data.ok) {
            throw Error("not data available");
        }
        const response = data.json();

        return response;
    } catch (error) {
        console.log(error.message);
    }
};
const pushDataOnMenu = async () => {
    try {
        const menuData = await getDataMenu();

        let submenu = [];

        if (menuData.role == "alumno") {
            if (menuData.clases.length) {
                menuData.clases.forEach((item) => {
                    if (item.estado_id === 1) {
                        submenu.push({
                            id: `${item.id}`,
                            name: `${item.codigo} ${item.materia.nombre}`,
                            href: `/clases/${item.id}`,
                        });
                    }
                });
                menu[3].submenu = submenu; // Asigna el submenu filtrado
            }
        } else if (menuData.role == "docente") {
            if (menuData.clases.length) {
                menuData.clases.forEach((item) => {
                    submenu.push({
                        id: `${item.id}`,
                        name: `${item.codigo} ${item.materia.nombre}`,
                        href: `/clases/${item.id}`,
                    });
                    menu[2].submenu = submenu;
                });
            }
        }
    } catch (error) {
        console.log(error.message);
    }
};

const hideFlashMessage = () => {
    setTimeout(() => {
        flashMessage.value = "";
        pageProps.flash.success = "";
        successMessage.value = "";
    }, 5000);
};

onMounted(() => {
    mql = window.matchMedia("(min-width: 1024px)");
    isMobile.value = mql.matches;

    mql.addEventListener("change", handleMqlChange);

    pushDataOnMenu();

    if (successMessage.value) {
        flashMessage.value = successMessage.value;
        hideFlashMessage();
    }
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
        <Head :title="props.title" />

        <div class="md:h-screen">
            <div class="lg:flex lg:flex-grow">
                <!-- navbar -->
                <nav class="lg:flex-shrink-0 lg:w-56 lg:h-screen lg:shadow-lg">
                    <!-- navbar header -->
                    <div class="bg-primary px-4 py-4 flex justify-between">
                        <div class="flex items-center gap-4">
                            <Link :href="route('dashboard')">
                                <ApplicationMark class="block h-9 w-auto" />
                            </Link>
                            <span
                                class="text-xs font-bold italic font-mono text-white">
                                Universidad Politécnica UNVES
                            </span>
                        </div>
                        <button
                            class="cursor-pointer lg:hidden"
                            @click="isMobile = !isMobile">
                            <Icon name="hamburger" />
                        </button>
                    </div>
                    <!-- navbar body -->
                    <MenuNav :showDropdown="isMobile">
                        <!-- content -->
                        <template #content>
                            <ul class="pt-2 px-2">
                                <template
                                    v-for="(links, index) in menu"
                                    :key="links.id">
                                    <li
                                        class="capitalize mb-2"
                                        v-if="getUserRole($page.props.userRole.role, index)">
                                        <NavLink
                                            :href="links.href"
                                            v-if="!links.submenu"
                                            :class="{
                                                'bg-secondary text-white hover:bg-secondary':
                                                    $page.url == links.href,}">
                                            <Icon
                                                :name="links.icon"
                                                class="w-4 h-4 fill-primary group-hover:fill-white"
                                                :class="{'fill-white': $page.url == links.href,}"
                                            />
                                            {{ links.name }}
                                        </NavLink>
                                        <NavLink
                                            as="button"
                                            v-else
                                            class="flex gap-2 capitalize w-full"
                                            @click="handleSubmenu(index)">
                                            <span
                                                class="flex w-4 h-4 items-center justify-center rounded-full bg-primary group-hover:bg-white">
                                                <Icon
                                                    class="h-2 w-2 fill-white group-hover:fill-primary"
                                                    :name="
                                                        links.toggle_submenu
                                                            ? 'cheveron-up'
                                                            : 'cheveron-down'"/>
                                            </span>
                                            {{ links.name }}
                                        </NavLink>
                                        <transition name="submenu-slice">
                                            <ul
                                                v-if="
                                                    links.submenu &&
                                                    links.toggle_submenu"
                                                class="pl-1">
                                                <li
                                                    v-for="submenu in links.submenu"
                                                    class="capitalize mb-1">
                                                    <NavLink
                                                        :href="submenu.href"
                                                        class="text-sm"
                                                        :class="{
                                                            'bg-secondary text-white hover:bg-secondary':
                                                                $page.url.startsWith(submenu.href),}">
                                                        {{ submenu.name }}
                                                    </NavLink>
                                                </li>
                                            </ul>
                                        </transition>
                                    </li>
                                </template>
                            </ul>
                        </template>
                        <!-- foother (authdata) -->
                        <template #authData>
                            <div class="w-full mt-4 border-t lg:mt-8">
                                <Dropdown
                                    :width="'40'"
                                    class="w-fit"
                                    :align="'right-right'">
                                    <template #trigger>
                                        <div class="pt-2 w-fit">
                                            <button
                                                class="flex items-center justify-evenly rounded-2xl bg-primary w-56 h-12 group hover:bg-white hover:border-primary hover:border lg:w-52">
                                                <img
                                                    v-if="$page.props.auth.user.profile_photo_path"
                                                    class="h-9 w-9 rounded-full object-cover lg:h-8 lg:w-8"
                                                    :src="imageUrl($page.props.auth.user.profile_photo_path)"
                                                    :alt="$page.props.auth.user.email"
                                                />
                                                <img
                                                    v-else
                                                    class="h-9 w-9 rounded-full object-cover lg:h-8 lg:w-8"
                                                    src="https://static.vecteezy.com/system/resources/thumbnails/009/734/564/small_2x/default-avatar-profile-icon-of-social-media-user-vector.jpg"
                                                    :alt="$page.props.auth.user.email"
                                                />
                                                <span
                                                    class="text-white font-bold text-sm group-hover:text-primary lg:text-xs">
                                                    {{ $page.props.auth.user.email }}
                                                </span>
                                                <icon
                                                    name="cheveron-right"
                                                    class="w-5 h-5 fill-white lg:w-4 lg:h-4"
                                                />
                                            </button>
                                        </div>
                                    </template>
                                    <template #content>
                                        <div class="pl-3 py-2">
                                            <form
                                                method="POST"
                                                @submit.prevent="logout">
                                                <button
                                                    type="submit"
                                                    class="inline-block text-left py-2 w-full font-bold text-black hover:text-primary hover:underline">
                                                    Cerrar Sesión
                                                </button>
                                            </form>
                                            <div>
                                                <Link
                                                    :href="route('profile.show')"
                                                    class="inline-block py-2 w-full font-bold text-black hover:text-primary hover:underline">
                                                    Perfil
                                                </Link>
                                            </div>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                        </template>
                    </MenuNav>
                </nav>
                <!-- Page  -->
                <div
                    class="bg-gray-100 lg:pt-10 lg:flex-1 lg:h-screen lg:overflow-y-auto"
                    scroll-region>
                    <!-- Page Header -->
                    <header
                        v-if="$slots.header"
                        class="bg-white w-full shadow relative lg:fixed lg:top-0 z-50">
                        <div class="max-w-7xl py-5 px-12">
                            <slot name="header" />
                        </div>
                        <FlashMessage :success="flashMessage" />
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
<style scoped>
.submenu-slice-enter-from {
    max-height: 0px;
    overflow: hidden;
}

.submenu-slice-enter-to {
    max-height: 1000px;
    overflow: visible;
}

.submenu-slice-enter-active,
.submenu-slice-leave-active {
    transition: all 400ms ease;
}

.submenu-slice-leave-from {
    max-height: 1000px;
    overflow: visible;
}

.submenu-slice-leave-to {
    max-height: 0px;
    overflow: hidden;
}
</style>
