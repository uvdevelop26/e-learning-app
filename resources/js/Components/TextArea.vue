<script setup>

defineProps({
    label: String
})

</script>
<template> 
    <div>
        <label for="">{{ label }}</label>
        <textarea class="w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm" name="" id="" cols="30" rows="2">
        </textarea>
    </div>
</template>



<style lang="scss" scoped>

</style>