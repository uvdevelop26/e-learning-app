<script setup>
import { ref, onMounted, onUnmounted, reactive } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Icon from "../Components/Icon.vue";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import MenuNav from "../Components/MenuNav.vue";
import { usePage } from '@inertiajs/vue3'


const props = defineProps({
    title: String,
});

const { auth } = usePage().props;

    // Ahora puedes acceder a la propiedad "auth"
   /*  console.log(auth.user.id); */



const isMobile = ref(null);
let mql = null;

const linkList = reactive([
    { id: 1, name: "dashboard", href: "/dashboard" },
    {
        id: 3,
        name: "Clases Impartidas",
        href: "/clases",
        /* submenu: [
            { name: "alumnos", href: "/alumnos" },
            { name: "docentes", href: "/docentes" },
            { name: "administradores", href: "/administradores" },
        ],
        toggle_submenu: false, */
    },
    {
        id: 2,
        name: "usuarios",
        href: "..",
        submenu: [
            { name: "alumnos", href: "/alumnos" },
            { name: "docentes", href: "/docentes" },
            { name: "administradores", href: "/administradores" },
        ],
        toggle_submenu: false,
    },
    {
        id: 3,
        name: "académicos",
        href: "...",
        submenu: [
            { name: "carreras", href: "/carreras" },
            { name: "semestres", href: "/semestres" },
            { name: "materias", href: "/materias" },
        ],
    },
]);


const handleSubmenu = (index) => {
    linkList[index].toggle_submenu = !linkList[index].toggle_submenu;
};

const handleMqlChange = (e) => {
    isMobile.value = e.matches;
};

onMounted(() => {
    mql = window.matchMedia("(min-width: 1024px)");
    isMobile.value = mql.matches;

    mql.addEventListener("change", handleMqlChange);

       
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
                <nav
                    class="text-gray-500 lg:flex-shrink-0 lg:w-56 lg:h-screen lg:shadow-lg">
                    <div class="bg-primary px-4 py-4 flex justify-between">
                        <Link :href="route('dashboard')">
                            <ApplicationMark class="block h-9 w-auto" />
                        </Link>
                        <button
                            class="cursor-pointer lg:hidden"
                            @click="isMobile = !isMobile">
                            <Icon name="hamburger" />
                        </button>
                    </div>
                    <MenuNav :showDropdown="isMobile">
                        <template #content>
                            <ul class="">
                                <li
                                    v-for="(links, index) in linkList"
                                    :key="links.id"
                                    class="capitalize">
                                    <NavLink
                                        :href="links.href"
                                        v-if="!links.submenu"
                                        :class="{
                                            'bg-indigo-100 font-bold':
                                                $page.url.startsWith(
                                                    links.href
                                                ),
                                        }">
                                        {{ links.name }}
                                    </NavLink>
                                    <NavLink
                                        as="button"
                                        v-else
                                        class="flex gap-2 capitalize w-full"
                                        @click="handleSubmenu(index)">
                                        <Icon
                                            class="h-3 w-3 fill-primary"
                                            name="plus"
                                        />
                                        {{ links.name }}
                                    </NavLink>
                                    <transition name="submenu-slice">
                                        <ul
                                            v-if="
                                                links.submenu &&
                                                links.toggle_submenu
                                            "
                                            class="pl-3 bg-white">
                                            <li
                                                v-for="submenu in links.submenu"
                                                class="capitalize border-l-2">
                                                <NavLink
                                                    :href="submenu.href"
                                                    :class="{
                                                        'bg-indigo-100 font-bold':
                                                            $page.url.startsWith(
                                                                submenu.href
                                                            ),
                                                    }">
                                                    {{ submenu.name }}
                                                </NavLink>
                                            </li>
                                        </ul>
                                    </transition>
                                </li>
                            </ul>
                        </template>
                        <template #authData>
                            <div class="mt-4 border-t">
                                <div class="pt-1 border-gray-200">
                                    <div class="flex items-center px-3">
                                        <div class="shrink-0 mr-3">
                                            <img
                                                class="h-10 w-10 rounded-full object-cover"
                                                :src="
                                                        $page.props.auth.user
                                                        .profile_photo_url
                                                "
                                                :alt="
                                                    $page.props.auth.user.email
                                                "
                                            />
                                        </div>
                                        <div>
                                            <div
                                                class="font-medium text-xs text-gray-500"
                                            >
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
                                <!--     <DropdownLink as="a" :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>  -->
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
                        class="bg-white w-full shadow lg:fixed lg:top-0 z-50"
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
