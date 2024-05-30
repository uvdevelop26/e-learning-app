<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
    as: String,
});

</script>

<template>
    <button
        v-if="as == 'button'"
        class="block py-3 px-2 text-primary font-bold items-center border-transparent leading-5 rounded-xl transition duration-150 ease-in-out hover:bg-secondary hover:text-white group">
        <slot />
    </button>
    <Link
        v-else
        :href="href"
        class="flex py-3 px-2 gap-2 text-primary font-bold items-center border-transparen leading-5 rounded-xl transition duration-150 ease-in-out hover:bg-secondary hover:text-white group">
        <slot />
    </Link>
</template>
