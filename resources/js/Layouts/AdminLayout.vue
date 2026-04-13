<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const logoutForm = useForm({});

const links = [
  { name: 'Dashboard', href: '/dashboard' },
  { name: 'Empresas', href: '/companies' },
  { name: 'Sucursales', href: '/branches' },
  { name: 'Usuarios', href: '/users' },
  { name: 'Clientes', href: '/customers' },
  { name: 'Productos', href: '/products' },
  { name: 'Cotizaciones', href: '/quotes' },
  { name: 'Ventas', href: '/sales' },
  { name: 'Ordenes', href: '/service-orders' },
];

const logout = () => {
  logoutForm.post('/logout');
};
</script>

<template>
  <div class="min-h-screen bg-slate-100 flex">
    <aside class="w-64 bg-slate-900 text-white p-4 flex flex-col">
      <h1 class="font-bold text-xl mb-4">AllSystem</h1>
      <nav class="space-y-2 flex-1">
        <Link v-for="link in links" :key="link.href" :href="link.href" class="block px-2 py-1 rounded hover:bg-slate-700">{{ link.name }}</Link>
      </nav>
      <button class="mt-4 w-full rounded border border-slate-600 px-2 py-1 text-sm hover:bg-slate-700" @click="logout">Cerrar sesión</button>
    </aside>
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>
