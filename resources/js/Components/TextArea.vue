<script setup>
import { onMounted, ref } from "vue";

defineProps({
    label: String,
    modelValue: String,
    id: String,
    error: String,
})

defineEmits(["update:modelValue"]);

const textArea = ref(null);

onMounted(() => {
    if (textArea.value.hasAttribute("autofocus")) {
        textArea.value.focus();
    }
});

defineExpose({ focus: () => textArea.value.focus() });

</script>
<template> 
    <div>
        <label :for="id">{{ label }}</label>
        <textarea class="p-0 w-full border-gray-300 focus:border-secondary focus:ring-secondary rounded-md shadow-sm text-left" 
         :id="id" 
         cols="30" 
         rows="4"
         ref="textArea"
         @input="$emit('update:modelValue', $event.target.value)">
            {{ modelValue }}
        </textarea>
        <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
    </div>
</template>
