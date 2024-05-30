<script setup>
const props = defineProps({
    modelValue: String,
    maxWidth:{
        type: Number,
        default: 300
    }
});

defineEmits(['update:modelValue', 'reset'])

</script>
<template>
    <div class="flex items-center">
      <div class="flex w-full rounded shadow ">
        <input class="relative px-6 py-3 w-full rounded-md border-primary border-opacity-40 shadow focus:ring-0 placeholder:text-sm placeholder:italic" autocomplete="off" type="text" name="search" placeholder="Buscar.." :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
      </div>
      <button class="ml-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500 text-sm" type="button" @click="$emit('reset')">Reset</button>
    </div>
  </template>
  

  