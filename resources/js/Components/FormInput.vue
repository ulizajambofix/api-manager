<script setup>
const model = defineModel();

defineProps({
  id: { type: String, default: '' },
  label: { type: String, required: true },
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  error: { type: String, default: '' },
  disabled: { type: Boolean, default: false },
  required: { type: Boolean, default: false },
});
</script>

<template>
  <label class="block space-y-1">
    <span class="text-sm font-medium text-slate-700">{{ label }}</span>
    <input
      :id="id || label.toLowerCase().replace(/\s+/g, '-')"
      v-model="model"
      :type="type"
      :placeholder="placeholder"
      :disabled="disabled"
      :required="required"
      class="w-full rounded-lg border px-3 py-2 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:cursor-not-allowed disabled:bg-slate-100"
      :class="error ? 'border-red-400' : 'border-slate-300'"
    />
    <p v-if="error" class="text-xs text-red-600">{{ error }}</p>
  </label>
</template>
