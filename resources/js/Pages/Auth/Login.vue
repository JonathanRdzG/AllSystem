<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Iniciar sesión" />

  <div class="min-h-screen flex items-center justify-center bg-slate-100 px-4">
    <form class="w-full max-w-md space-y-4 rounded-lg bg-white p-6 shadow" @submit.prevent="submit">
      <h1 class="text-2xl font-semibold text-slate-900">AllSystem</h1>
      <p class="text-sm text-slate-600">Inicia sesión para continuar.</p>

      <div>
        <label class="mb-1 block text-sm text-slate-700" for="email">Email</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="w-full rounded border border-slate-300 px-3 py-2"
          required
          autofocus
        >
        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
      </div>

      <div>
        <label class="mb-1 block text-sm text-slate-700" for="password">Password</label>
        <input
          id="password"
          v-model="form.password"
          type="password"
          class="w-full rounded border border-slate-300 px-3 py-2"
          required
        >
        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
      </div>

      <label class="flex items-center gap-2 text-sm text-slate-700">
        <input v-model="form.remember" type="checkbox">
        Recordarme
      </label>

      <button
        type="submit"
        class="w-full rounded bg-slate-900 px-4 py-2 text-white disabled:opacity-60"
        :disabled="form.processing"
      >
        Entrar
      </button>
    </form>
  </div>
</template>
