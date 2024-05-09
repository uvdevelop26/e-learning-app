<template>
    <div
        class="min-h-screen w-full pt-8 px-4 flex flex-col items-center bg-gray-100 lg:justify-center lg:pt-0">
        <div
            class="w-full flex flex-col items-center p-4 bg-white shadow-md rounded-xl max-w-2xl lg:max-w-3xl lg:py-12 lg:flex-row">
            <div
                class="h-96 flex flex-col items-center lg:h-full lg:flex-1 lg:flex-col-reverse lg:justify-center">
                <slot name="logo" />
            </div>

            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden lg:h-full lg:flex-1">
                <slot />
            </div>
        </div>
    </div>
</template>
