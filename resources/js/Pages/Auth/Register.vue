<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/FormInput.vue';

const form = useForm({ name: '', email: '', password: '', password_confirmation: '' });

const submit = () => form.post('/register');
</script>

<template>
  <Head title="Register" />
  <main class="grid min-h-screen place-items-center bg-slate-100 px-4">
    <form class="w-full max-w-md space-y-4 rounded-xl bg-white p-6 shadow" @submit.prevent="submit">
      <h1 class="text-2xl font-bold">Create account</h1>

      <FormInput v-model="form.name" label="Full name" placeholder="Jane Doe" :error="form.errors.name" required />
      <FormInput v-model="form.email" label="Email" type="email" placeholder="jane@company.com" :error="form.errors.email" required />
      <FormInput v-model="form.password" label="Password" type="password" :error="form.errors.password" required />
      <FormInput v-model="form.password_confirmation" label="Confirm password" type="password" required />

      <button :disabled="form.processing" class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white disabled:opacity-60">
        {{ form.processing ? 'Creating account...' : 'Create account' }}
      </button>

      <p class="text-sm text-slate-600">Already have an account? <Link href="/login" class="text-blue-600 hover:underline">Sign in</Link></p>
    </form>
  </main>
</template>
