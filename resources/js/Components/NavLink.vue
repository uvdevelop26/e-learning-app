<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
    as: String,
});

/* const classes = computed(() => {
    return props.active
        ? "block items-center w-full bg-indigo-100 py-3 px-2 border-l-2  border-indigo-400 leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
        : "block py-3 px-2 items-center border-transparent leading-5 text-gray-500 focus:outline-none focus:text-gray-700 focus:border-indigo-400 transition duration-150 ease-in-out";
}); */
</script>

<template>
    <button
        v-if="as == 'button'"
        class="block py-3 px-2 text-primary font-bold items-center border-transparent leading-5 transition duration-150 ease-in-out"
    >
        <slot />
    </button>
    <Link
        v-else
        :href="href"
        class="flex py-3 px-2 gap-2 text-primary font-bold  items-center border-transparen leading-5 transition duration-150 ease-in-out hover:bg-indigo-100"
    >
        <slot />
    </Link>
</template>
