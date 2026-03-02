<script setup>
const model = defineModel();
defineProps({ label: String, type: { type: String, default: 'text' } });
</script>
<template>
  <label class="block">
    <span class="mb-1 block text-sm text-slate-700">{{ label }}</span>
    <input v-model="model" :type="type" class="w-full rounded border p-2" />
  </label>
</template>
