<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DataTable from '@/Components/DataTable.vue';
defineProps({ apis: Array });
</script>
<template>
  <AdminLayout>
    <h1 class="mb-4 text-xl font-bold">APIs</h1>
    <DataTable :columns="['Name','Base URL','Status','Rate Limit']" :rows="apis" />
  </AdminLayout>
</template>
