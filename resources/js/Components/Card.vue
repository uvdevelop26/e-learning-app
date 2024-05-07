<script setup>
import { onMounted } from 'vue';


</script>
<template>
    <div
        class="bg-white h-72 w-full max-w-80 flex flex-col justify-between border rounded-xl shadow-md cursor-pointer hover:shadow-lg overflow-hidden">
        <div
            class="h-1/3 px-4 bg-gradient-to-br from-primary to-secondary flex gap-2 justify-between items-center">
            <slot name="cardHeader" />
        </div>
        <div class="h-10 border-t">
            <slot name="cardFooter" />
        </div>
    </div>
</template>
