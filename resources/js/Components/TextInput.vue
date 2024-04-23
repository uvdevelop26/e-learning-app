<script setup>
import { onMounted, ref, computed } from "vue";

const props = defineProps({
    modelValue: String,
    label: String,
    id: String,
    type: String,
    error: String,
    disabled: Boolean,
    placeholder: String,
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus(), input });

const disbledState = computed(()=>{
    return props.disabled ? 'bg-gray-100' : 'bg-white'
})
</script>

<template>
    <div class="">
        <label :for="id" class="font-bold">{{ label }}</label>
        <input
            :type="type"
            ref="input"
            class="w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm placeholder:text-xs placeholder:italic"
            :class="disbledState"
            :id="id"
            :value="modelValue"
            :disabled="disabled"
            :placeholder="placeholder"
            @input="$emit('update:modelValue', $event.target.value)"
            autocomplete="off"
        />
        <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
    </div>
</template>
