<script setup>
import { computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const logoutForm = useForm({});

const links = [
  { name: 'Dashboard', href: '/dashboard', icon: 'home' },
  { name: 'Empresas', href: '/companies', icon: 'building' },
  { name: 'Sucursales', href: '/branches', icon: 'branch' },
  { name: 'Usuarios', href: '/users', icon: 'users' },
  { name: 'Clientes', href: '/customers', icon: 'briefcase' },
  { name: 'Productos', href: '/products', icon: 'cube' },
  { name: 'Cotizaciones', href: '/quotes', icon: 'document' },
  { name: 'Ventas', href: '/sales', icon: 'chart' },
  { name: 'Órdenes', href: '/service-orders', icon: 'tool' },
];

const currentPath = computed(() => page.url.split('?')[0]);
const isActive = (href) => currentPath.value === href || currentPath.value.startsWith(`${href}/`);
const initials = computed(() => (page.props.auth?.user?.name || 'Admin').slice(0, 2).toUpperCase());

const iconPaths = {
  home: 'M3 12l9-9 9 9M4.5 10.5V21h15V10.5',
  building: 'M3 21h18M6 21V6a1 1 0 011-1h10a1 1 0 011 1v15M9 9h.01M9 12h.01M9 15h.01M15 9h.01M15 12h.01M15 15h.01',
  branch: 'M8 6h8M8 12h8M8 18h8M4 6h.01M4 12h.01M4 18h.01',
  users: 'M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8.5 7a4 4 0 100 8 4 4 0 000-8zm11 8a3 3 0 100-6 3 3 0 000 6z',
  briefcase: 'M3 7h18v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7zm6-3h6a2 2 0 012 2v1H7V6a2 2 0 012-2z',
  cube: 'M12 2l9 5-9 5-9-5 9-5zm9 5v10l-9 5-9-5V7',
  document: 'M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2zm7 0v5h5',
  chart: 'M4 19h16M8 17V9m4 8V5m4 12v-6',
  tool: 'M14 7l-9 9m0 0H3v-2l9-9m-7 14l4 4m8-19a4 4 0 00-5 5l8 8a4 4 0 005-5l-8-8z',
};

const logout = () => logoutForm.post('/logout');
</script>

<template>
  <div class="min-h-screen bg-slate-100 p-3 sm:p-5">
    <div class="mx-auto flex min-h-[calc(100vh-1.5rem)] max-w-[1600px] gap-4">
      <aside class="hidden w-72 flex-col rounded-3xl border border-slate-200/70 bg-white p-5 shadow-sm lg:flex">
        <div class="mb-8 flex items-center gap-3 px-2">
          <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M4 15h16M4 11h16M4 7h16" /></svg>
          </div>
          <div>
            <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-400">Workspace</p>
            <h1 class="text-lg font-semibold text-slate-900">AllSystem</h1>
          </div>
        </div>

        <nav class="space-y-1.5">
          <Link
            v-for="link in links"
            :key="link.href"
            :href="link.href"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition"
            :class="isActive(link.href)
              ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100'
              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800'"
          >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" :d="iconPaths[link.icon]" />
            </svg>
            <span>{{ link.name }}</span>
          </Link>
        </nav>

        <button class="btn-secondary mt-auto w-full" @click="logout">Cerrar sesión</button>
      </aside>

      <div class="flex min-w-0 flex-1 flex-col gap-4">
        <header class="panel-surface flex flex-wrap items-center justify-between gap-4 p-4 sm:p-5">
          <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Panel administrativo</p>
            <h2 class="text-lg font-semibold text-slate-900">Hola, {{ page.props.auth?.user?.name || 'Equipo' }}</h2>
          </div>

          <div class="flex w-full items-center justify-end gap-3 sm:w-auto">
            <div class="relative w-full sm:w-72">
              <input class="field pl-9" type="search" placeholder="Buscar módulo..." />
              <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
            </div>
            <button class="btn-ghost">Filtrar</button>
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">{{ initials }}</div>
          </div>
        </header>

        <main class="min-w-0 flex-1 pb-4">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
