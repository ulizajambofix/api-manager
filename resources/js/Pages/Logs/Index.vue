<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataTable from '@/Components/DataTable.vue';
import FormInput from '@/Components/FormInput.vue';

const loading = ref(false);
const rows = ref([]);
const filters = ref({ date: '', status_code: '', api_id: '', user_id: '' });

const loadLogs = async () => {
  loading.value = true;
  const { data } = await axios.get('/api/request-logs', { params: filters.value });
  rows.value = (data.data || []).map((log) => ({
    Endpoint: log.endpoint,
    Method: log.method,
    Status: log.status_code,
    'Response (ms)': log.response_time_ms,
    IP: log.ip_address,
    Date: log.requested_at,
  }));
  loading.value = false;
};

loadLogs();
</script>

<template>
  <AdminLayout>
    <h1 class="mb-4 text-xl font-bold">Request Logs</h1>

    <div class="mb-4 grid grid-cols-1 gap-3 rounded-lg bg-white p-4 shadow md:grid-cols-5">
      <FormInput v-model="filters.date" label="Date" type="date" />
      <FormInput v-model="filters.status_code" label="Status" placeholder="200" />
      <FormInput v-model="filters.api_id" label="API ID" />
      <FormInput v-model="filters.user_id" label="User ID" />
      <div class="flex items-end">
        <button class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white" @click="loadLogs">Apply</button>
      </div>
    </div>

    <DataTable :columns="['Endpoint','Method','Status','Response (ms)','IP','Date']" :rows="rows" :loading="loading" />
  </AdminLayout>
</template>
