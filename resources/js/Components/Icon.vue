<script setup>
defineProps({
    name: String,
});
</script>
<template>
    <div>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            class="h-6 w-6 fill-white"
            v-if="name == 'hamburger'"
        >
            <path
                d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"
            />
        </svg>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            v-else-if="name == 'plus'"
        >
            <path
                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"
            />
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" v-else-if="name == 'minus'">
            <path
                d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"
            />
        </svg>
    </div>
</template>

<style lang="scss" scoped></style>
