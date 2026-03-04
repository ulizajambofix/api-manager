<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Verify Email" />
  <main class="grid min-h-screen place-items-center bg-slate-100 px-4">
    <section class="w-full max-w-md space-y-4 rounded-xl bg-white p-6 shadow">
      <h1 class="text-2xl font-bold">Verify your email</h1>
      <p class="text-sm text-slate-600">
        We sent a verification email to your inbox. Please verify your address to continue.
      </p>
      <div class="flex gap-3">
        <Link href="/dashboard" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">I already verified</Link>
        <Link href="/logout" method="post" as="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">Log out</Link>
      </div>
    </section>
  </main>
</template>
