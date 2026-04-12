<script setup>
import { Link } from '@inertiajs/vue3';
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
</script>

<template>
  <div class="min-h-screen bg-slate-100 flex">
    <aside class="w-64 bg-slate-900 text-white p-4">
      <h1 class="font-bold text-xl mb-4">AllSystem</h1>
      <nav class="space-y-2">
        <Link v-for="link in links" :key="link.href" :href="link.href" class="block px-2 py-1 rounded hover:bg-slate-700">{{ link.name }}</Link>
      </nav>
    </aside>
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>
