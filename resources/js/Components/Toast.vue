<script setup>
defineProps({
  show: { type: Boolean, default: false },
  message: { type: String, default: '' },
  type: { type: String, default: 'success' },
});
</script>

<template>
  <transition name="fade">
    <div
      v-if="show"
      class="fixed right-4 top-4 z-50 rounded-lg px-4 py-3 text-sm text-white shadow-lg"
      :class="type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'"
    >
      {{ message }}
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from,
.fade-leave-to { opacity: 0; }
</style>
