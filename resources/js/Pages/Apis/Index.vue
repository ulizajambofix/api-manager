<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataTable from '@/Components/DataTable.vue';
import Modal from '@/Components/Modal.vue';
import FormInput from '@/Components/FormInput.vue';
import Toast from '@/Components/Toast.vue';

const loading = ref(false);
const showCreate = ref(false);
const rows = ref([]);
const toast = ref({ show: false, message: '', type: 'success' });
const form = ref({ name: '', slug: '', base_url: '', rate_limit_per_minute: 60, status: true, description: '' });

const loadApis = async () => {
  loading.value = true;
  const { data } = await axios.get('/api/apis');
  rows.value = (data.data || []).map((item) => ({
    Name: item.name,
    'Base URL': item.base_url,
    Status: item.status ? 'Active' : 'Inactive',
    'Rate Limit': item.rate_limit_per_minute,
  }));
  loading.value = false;
};

const createApi = async () => {
  await axios.post('/api/apis', form.value);
  toast.value = { show: true, message: 'API created successfully', type: 'success' };
  showCreate.value = false;
  await loadApis();
  setTimeout(() => (toast.value.show = false), 2000);
};

loadApis();
</script>

<template>
  <AdminLayout>
    <Toast :show="toast.show" :message="toast.message" :type="toast.type" />

    <div class="mb-4 flex items-center justify-between">
      <h1 class="text-xl font-bold">APIs</h1>
      <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white" @click="showCreate = true">New API</button>
    </div>

    <DataTable :columns="['Name','Base URL','Status','Rate Limit']" :rows="rows" :loading="loading" />

    <Modal :open="showCreate" title="Create API" @close="showCreate = false">
      <div class="space-y-3">
        <FormInput v-model="form.name" label="Name" />
        <FormInput v-model="form.slug" label="Slug" />
        <FormInput v-model="form.base_url" label="Base URL" />
        <FormInput v-model="form.rate_limit_per_minute" label="Rate limit / min" type="number" />
        <FormInput v-model="form.description" label="Description" />
        <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white" @click="createApi">Save API</button>
      </div>
    </Modal>
  </AdminLayout>
</template>
