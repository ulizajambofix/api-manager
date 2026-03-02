<script setup>
defineProps({ open: Boolean, title: String });
defineEmits(['close']);
</script>
<template>
  <div v-if="open" class="fixed inset-0 grid place-items-center bg-black/40">
    <div class="w-full max-w-lg rounded bg-white p-6">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="font-semibold">{{ title }}</h3>
        <button @click="$emit('close')">✕</button>
      </div>
      <slot />
    </div>
  </div>
</template>
