<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormInput from '@/Components/FormInput.vue';
import Toast from '@/Components/Toast.vue';

const toast = ref({ show: false, message: '', type: 'success' });
const form = useForm({ email: '', password: '', remember: false });

const submit = () => {
  form.post('/login', {
    onSuccess: () => {
      toast.value = { show: true, message: 'Welcome back!', type: 'success' };
      setTimeout(() => (toast.value.show = false), 2200);
    },
    onError: () => {
      toast.value = { show: true, message: 'Login failed. Check your credentials.', type: 'error' };
      setTimeout(() => (toast.value.show = false), 2200);
    },
  });
};
</script>

<template>
  <Head title="Login" />
  <Toast :show="toast.show" :message="toast.message" :type="toast.type" />

  <main class="grid min-h-screen place-items-center bg-slate-100 px-4">
    <form class="w-full max-w-md space-y-5 rounded-xl bg-white p-6 shadow" @submit.prevent="submit">
      <div>
        <h1 class="text-2xl font-bold">Sign in</h1>
        <p class="text-sm text-slate-500">Access your API Management Portal account.</p>
      </div>

      <FormInput v-model="form.email" label="Email" type="email" placeholder="you@company.com" :error="form.errors.email" required />
      <FormInput v-model="form.password" label="Password" type="password" placeholder="••••••••" :error="form.errors.password" required />

      <label class="flex items-center gap-2 text-sm text-slate-600">
        <input v-model="form.remember" type="checkbox" class="rounded border-slate-300" />
        Remember me
      </label>

      <button :disabled="form.processing" class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white disabled:opacity-60">
        {{ form.processing ? 'Signing in...' : 'Sign in' }}
      </button>

      <div class="flex justify-between text-sm">
        <Link href="/forgot-password" class="text-blue-600 hover:underline">Forgot password?</Link>
        <Link href="/register" class="text-blue-600 hover:underline">Create account</Link>
      </div>
    </form>
  </main>
</template>
