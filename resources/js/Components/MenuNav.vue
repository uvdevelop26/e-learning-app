<script setup>
defineProps({
    showDropdown: Boolean,
});
</script>
<template>
    <transition name="slice">
        <div class="border-b shadow-md lg:h-[90vh] bg-white" v-if="showDropdown">
            <div class="lg:h-[82%] overflow-y-auto">
                <slot name="content" />
            </div>
            <div class="flex p-2 items-center">
                <slot name="authData" />
            </div>
        </div>
    </transition>
</template>
<style scoped>

.slice-enter-from {
   /*  transform: translateY(-100%); */
   max-height: 0;
   overflow: hidden;
   opacity: 0;
}

.slice-enter-to {
   /*  transform: translateY(0); */
   max-height: 1000px;
   overflow: visible;
   opacity: 1;
}

.slice-enter-active,
.slice-leave-active {
    transition: all 350ms ease;
}

.slice-leave-from {
   /*  transform: translateY(0); */
   max-height: 1000px;
   overflow: visible;
   opacity: 1;
}

.slice-leave-to {
    max-height: 0;
   overflow: hidden;
   opacity: 0;
}

@media(min-width: 1024px) {

    .slice-enter-active,
    .slice-leave-active {
        transition: none;
    }

}


</style>
