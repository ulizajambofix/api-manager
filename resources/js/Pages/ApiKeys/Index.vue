<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataTable from '@/Components/DataTable.vue';
import Modal from '@/Components/Modal.vue';
import FormInput from '@/Components/FormInput.vue';

const loading = ref(false);
const keys = ref([]);
const showGenerate = ref(false);
const generatedToken = ref('');
const form = ref({ api_id: '', user_id: '', name: '', expires_at: '' });

const loadKeys = async () => {
  loading.value = true;
  const { data } = await axios.get('/api/api-keys');
  keys.value = (data.data || []).map((item) => ({
    Name: item.name,
    Prefix: item.prefix,
    'Usage Count': item.request_logs_count,
    Status: item.revoked_at ? 'Revoked' : 'Active',
  }));
  loading.value = false;
};

const generateKey = async () => {
  const { data } = await axios.post('/api/api-keys', form.value);
  generatedToken.value = data.token;
  await loadKeys();
};

loadKeys();
</script>

<template>
  <AdminLayout>
    <div class="mb-4 flex items-center justify-between">
      <h1 class="text-xl font-bold">API Keys</h1>
      <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white" @click="showGenerate = true">Generate key</button>
    </div>

    <DataTable :columns="['Name','Prefix','Usage Count','Status']" :rows="keys" :loading="loading" />

    <Modal :open="showGenerate" title="Generate API Key" @close="showGenerate = false">
      <div class="space-y-3">
        <FormInput v-model="form.api_id" label="API ID" />
        <FormInput v-model="form.user_id" label="User ID" />
        <FormInput v-model="form.name" label="Key Name" />
        <FormInput v-model="form.expires_at" label="Expires At" type="datetime-local" />
        <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white" @click="generateKey">Generate</button>
        <p v-if="generatedToken" class="rounded bg-amber-50 p-2 text-xs text-amber-700">Copy now (shown once): {{ generatedToken }}</p>
      </div>
    </Modal>
  </AdminLayout>
</template>
