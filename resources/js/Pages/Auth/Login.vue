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

  <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,rgba(15,118,110,0.18),transparent_35%),radial-gradient(circle_at_bottom_right,rgba(251,146,60,0.18),transparent_30%),linear-gradient(180deg,#f8fafc_0%,#e2e8f0_100%)] px-4 py-10">
    <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
      <section class="hidden rounded-[36px] bg-slate-950 p-10 text-white shadow-[0_30px_80px_rgba(15,23,42,0.35)] lg:block">
        <p class="text-xs font-semibold uppercase tracking-[0.34em] text-teal-300/80">Plataforma empresarial</p>
        <h1 class="mt-5 text-4xl font-semibold leading-tight">Opera clientes, ventas, cotizaciones y servicio desde un mismo tablero.</h1>
        <p class="mt-5 max-w-xl text-sm leading-7 text-slate-300">AllSystem organiza la operación diaria de PyMEs con un flujo más limpio, rápido y consistente para equipos comerciales y administrativos.</p>

        <div class="mt-10 grid gap-4 sm:grid-cols-3">
          <div class="rounded-3xl bg-white/8 p-4">
            <p class="text-2xl font-semibold">CRM</p>
            <p class="mt-2 text-sm text-slate-300">Clientes centralizados y listos para seguimiento.</p>
          </div>
          <div class="rounded-3xl bg-white/8 p-4">
            <p class="text-2xl font-semibold">Ventas</p>
            <p class="mt-2 text-sm text-slate-300">Cotizaciones y cierres con mejor trazabilidad.</p>
          </div>
          <div class="rounded-3xl bg-white/8 p-4">
            <p class="text-2xl font-semibold">Servicio</p>
            <p class="mt-2 text-sm text-slate-300">Órdenes y atención postventa en un solo lugar.</p>
          </div>
        </div>
      </section>

      <form class="panel-surface w-full max-w-xl space-y-5 p-6 sm:p-8 lg:justify-self-end" @submit.prevent="submit">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.3em] text-teal-700">Acceso seguro</p>
          <h2 class="mt-3 text-3xl font-semibold text-slate-950">Iniciar sesión</h2>
          <p class="mt-2 text-sm leading-6 text-slate-500">Ingresa con las credenciales de tu organización para continuar.</p>
        </div>

        <div>
          <label class="field-label" for="email">Correo electrónico</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="field"
            required
            autofocus
            autocomplete="username"
            placeholder="admin@empresa.com"
          >
          <p v-if="form.errors.email" class="field-error">{{ form.errors.email }}</p>
        </div>

        <div>
          <label class="field-label" for="password">Contraseña</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="field"
            required
            autocomplete="current-password"
            placeholder="••••••••"
          >
          <p v-if="form.errors.password" class="field-error">{{ form.errors.password }}</p>
        </div>

        <label class="flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm text-slate-700">
          <input v-model="form.remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
          Mantener mi sesión iniciada
        </label>

        <button
          type="submit"
          class="btn-primary w-full"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Ingresando...' : 'Entrar al sistema' }}
        </button>

        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50/70 p-4 text-sm text-slate-600">
          <p class="font-semibold text-slate-900">Credenciales demo</p>
          <p class="mt-2">Administrador: <span class="font-medium">admin@demo.local</span> / <span class="font-medium">password123</span></p>
          <p class="mt-1">Operador: <span class="font-medium">operador@demo.local</span> / <span class="font-medium">password123</span></p>
        </div>
      </form>
    </div>
  </div>
</template>
