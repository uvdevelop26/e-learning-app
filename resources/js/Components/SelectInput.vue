<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: String,
    label: String,
    id: String,
    disabled: Boolean,
    error: String,
});

defineEmits(["update:modelValue"]);

const inputSelect = ref(null);

onMounted(() => {
    if (inputSelect.value.hasAttribute("autofocus")) {
        inputSelect.value.focus();
    }
});

defineExpose({ focus: () => inputSelect.value.focus(), inputSelect });
</script>
<template>
    <div>
        <label :for="id">{{ label }}</label>
        <select
            class="w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm cursor-pointer"
            :name="id"
            :id="id"
            ref="inputSelect"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :disabled="disabled"
        >
            <slot />
        </select>
        <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
    </div>
</template>
