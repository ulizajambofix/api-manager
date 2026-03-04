<script setup>
defineProps({ columns: Array, rows: Array, loading: Boolean });
</script>
<template>
  <div class="rounded bg-white shadow">
    <div v-if="loading" class="p-4 text-sm text-slate-500">Loading...</div>
    <table v-else class="w-full text-sm">
      <thead><tr><th v-for="c in columns" :key="c" class="border-b p-3 text-left">{{ c }}</th></tr></thead>
      <tbody>
        <tr v-for="(row, idx) in rows" :key="idx" class="border-b"><td v-for="(value, key) in row" :key="key" class="p-3">{{ value }}</td></tr>
      </tbody>
    </table>
  </div>
</template>
