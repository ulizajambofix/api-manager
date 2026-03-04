<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen bg-slate-50">
    <header class="border-b bg-white">
      <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <h1 class="font-semibold">API Management Portal</h1>
        <nav class="flex items-center gap-4 text-sm">
          <Link href="/dashboard" class="text-slate-700 hover:text-blue-600">Dashboard</Link>
          <Link href="/apis" class="text-slate-700 hover:text-blue-600">APIs</Link>
          <Link href="/api-keys" class="text-slate-700 hover:text-blue-600">API Keys</Link>
          <Link href="/logs" class="text-slate-700 hover:text-blue-600">Logs</Link>
        </nav>
      </div>
    </header>
    <main class="mx-auto max-w-7xl p-6"><slot /></main>
  </div>
</template>
