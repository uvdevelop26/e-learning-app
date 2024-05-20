<script setup>
const props = defineProps({
    success: String,
});
</script>
<template>
    <transition name="flash">
        <div
            class="absolute -bottom-12 left-5 h-14 w-[90%] max-w-lg rounded-xl bg-green-400 shadow-lg md:left-28 lg:left-[28rem]"
            v-if="success">
            <div
                class="text-white font-bold w-full h-full p-4 flex items-center">
                <span class="block w-full text-center">
                    ¡{{ success }}!
                </span>
            </div>
        </div>
    </transition>
</template>
<style scoped>
.flash-enter-from {
    opacity: 0px;
    transform: translateY(-60px);
}

.flash-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.flash-enter-active {
    /*  transition: all 400ms ease; */
    animation: wobble 0.8s ease;
}

.flash-leave-active {
    transition: all 400ms ease;
}

.flash-leave-from {
    transform: translateY(0);
    opacity: 1;
}

.flash-leave-to {
    opacity: 0px;
    transform: translateY(-60px);
}

@keyframes wobble {
    0% {
        transform: translateY(-60px);
        opacity: 0;
    }
    50% {
        transform: translateY(0px);
        opacity: 1;
    }
    60% {
        transform: translateX(8px);
    }
    70% {
        transform: translateX(-8px);
    }
    80% {
        transform: translateX(4px);
    }
    90% {
        transform: translateX(-4px);
    }
    100% {
        transform: translateX(0px);
    }
}
</style>
