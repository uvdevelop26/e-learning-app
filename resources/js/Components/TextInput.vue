<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: String,
    label: String,
    id: String,
    type: String,
    error: String,
    disabled: Boolean
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="">
        <label :for="id">{{ label }}</label>
        <input
            :type="type"
            ref="input"
            class="w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm"
            :id="id"
            :value="modelValue"
            :disabled="disabled"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
    </div>
</template>
