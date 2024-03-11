<script setup>
defineProps({
    loading: Boolean,
});


</script>

<template>
    <button :disabled="loading" class="bg-primary w-48 h-10 rounded-md text-white font-bold flex items-center justify-center cursor-pointer">
        <div v-if="loading" class="btn-spinner mr-2" />
        <slot />
    </button>
</template>


