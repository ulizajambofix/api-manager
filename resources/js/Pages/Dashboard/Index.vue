<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const metrics = ref({});
const loading = ref(true);

onMounted(async () => {
  const { data } = await axios.get('/api/dashboard/summary');
  metrics.value = data;
  loading.value = false;
});
</script>

<template>
  <AdminLayout>
    <h1 class="mb-4 text-2xl font-bold">Dashboard</h1>
    <div v-if="loading">Loading summary...</div>
    <div v-else class="grid grid-cols-2 gap-4 md:grid-cols-4">
      <div class="rounded bg-white p-4 shadow" v-for="(value, key) in metrics" :key="key">
        <p class="text-xs uppercase text-slate-500">{{ key }}</p>
        <p class="text-2xl font-semibold">{{ value }}</p>
      </div>
    </div>
  </AdminLayout>
</template>
