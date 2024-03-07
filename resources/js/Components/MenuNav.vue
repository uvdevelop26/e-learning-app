<script setup>

defineProps({

    showDropdown: Boolean,
});
</script>
<template>
    <div class="border-b shadow-md lg:h-[90vh]" v-if="showDropdown">
        <div class="lg:h-[82%] overflow-y-auto">
            <slot name="content" />
        </div>
        <div>
            <slot name="authData" />
        </div>
    </div>
</template>
