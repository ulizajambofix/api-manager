<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/FormInput.vue';

const form = useForm({ email: '' });

const submit = () => form.post('/forgot-password');
</script>

<template>
  <Head title="Forgot Password" />
  <main class="grid min-h-screen place-items-center bg-slate-100 px-4">
    <form class="w-full max-w-md space-y-4 rounded-xl bg-white p-6 shadow" @submit.prevent="submit">
      <h1 class="text-2xl font-bold">Forgot your password?</h1>
      <p class="text-sm text-slate-500">Enter your email and we’ll send reset instructions.</p>

      <FormInput v-model="form.email" label="Email" type="email" :error="form.errors.email" required />

      <button :disabled="form.processing" class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white disabled:opacity-60">
        {{ form.processing ? 'Sending...' : 'Send reset link' }}
      </button>

      <p class="text-sm text-slate-600">Back to <Link href="/login" class="text-blue-600 hover:underline">sign in</Link></p>
    </form>
  </main>
</template>
