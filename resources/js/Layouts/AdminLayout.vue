<script setup>
import { computed, ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import FlashBanner from '../Components/FlashBanner.vue';

const props = defineProps({
  pageTitle: {
    type: String,
    default: 'AllSystem',
  },
});

const page = usePage();
const logoutForm = useForm({});
const mobileOpen = ref(false);
const navQuery = ref('');

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
const filteredLinks = computed(() => {
  const query = navQuery.value.trim().toLowerCase();

  if (!query) {
    return links;
  }

  return links.filter((link) => link.name.toLowerCase().includes(query));
});
const activeLink = computed(() => links.find((link) => isActive(link.href)) ?? links[0]);
const todayLabel = computed(() => new Intl.DateTimeFormat('es-MX', { dateStyle: 'full' }).format(new Date()));

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
const closeMobile = () => {
  mobileOpen.value = false;
};
</script>

<template>
  <Head :title="pageTitle" />

  <div class="min-h-screen p-3 sm:p-5">
    <div class="mx-auto flex min-h-[calc(100vh-1.5rem)] max-w-[1680px] gap-4">
      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <button
          v-if="mobileOpen"
          class="fixed inset-0 z-30 bg-slate-950/35 lg:hidden"
          @click="closeMobile"
        />
      </transition>

      <aside
        class="fixed inset-y-3 left-3 z-40 flex w-[86vw] max-w-80 flex-col gap-5 rounded-[32px] border border-white/70 bg-slate-950 p-5 text-white shadow-[0_30px_80px_rgba(15,23,42,0.45)] transition lg:static lg:inset-auto lg:w-80 lg:translate-x-0 lg:shadow-[0_20px_60px_rgba(15,23,42,0.16)]"
        :class="mobileOpen ? 'translate-x-0' : '-translate-x-[120%] lg:translate-x-0'"
      >
        <div class="rounded-[28px] bg-white/8 p-4">
          <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-400/15 text-teal-200">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14M5 12h14M5 19h9" /></svg>
              </div>
              <div>
                <p class="text-xs uppercase tracking-[0.3em] text-white/45">Workspace</p>
                <h1 class="text-lg font-semibold">AllSystem</h1>
              </div>
            </div>

            <button class="rounded-2xl p-2 text-white/70 hover:bg-white/10 lg:hidden" @click="closeMobile">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
          </div>

          <p class="text-sm leading-6 text-white/70">Panel comercial y operativo para gestión integral de PyMEs.</p>
        </div>

        <div>
          <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.24em] text-white/45" for="nav-search">Buscar módulo</label>
          <div class="relative">
            <input id="nav-search" v-model="navQuery" class="field border-white/10 bg-white/8 pr-10 text-white placeholder:text-white/35" type="search" placeholder="Clientes, ventas..." />
            <svg class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
          </div>
        </div>

        <nav class="space-y-1.5">
          <Link
            v-for="link in filteredLinks"
            :key="link.href"
            :href="link.href"
            class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition"
            :class="isActive(link.href)
              ? 'bg-white text-slate-950'
              : 'text-white/72 hover:bg-white/10 hover:text-white'"
            @click="closeMobile"
          >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" :d="iconPaths[link.icon]" />
            </svg>
            <span>{{ link.name }}</span>
          </Link>
          <p v-if="!filteredLinks.length" class="rounded-2xl border border-dashed border-white/10 px-4 py-3 text-sm text-white/50">
            No hay módulos que coincidan con la búsqueda.
          </p>
        </nav>

        <div class="mt-auto rounded-[28px] bg-white/8 p-4">
          <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/12 text-sm font-semibold text-white">{{ initials }}</div>
            <div class="min-w-0">
              <p class="truncate text-sm font-semibold">{{ page.props.auth?.user?.name || 'Equipo' }}</p>
              <p class="truncate text-xs text-white/55">{{ page.props.auth?.user?.email || 'Sin correo' }}</p>
            </div>
          </div>
          <button class="btn-secondary mt-4 w-full border-white/10 bg-white text-slate-900 hover:bg-white/90" @click="logout">Cerrar sesión</button>
        </div>
      </aside>

      <div class="flex min-w-0 flex-1 flex-col gap-4">
        <header class="panel-surface shell-gradient flex flex-wrap items-center justify-between gap-4 p-5 sm:p-6">
          <div>
            <div class="mb-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">
              <button class="rounded-2xl border border-slate-200/80 bg-white/80 p-2 text-slate-700 lg:hidden" @click="mobileOpen = true">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
              </button>
              <span>Módulo activo</span>
            </div>
            <h2 class="text-2xl font-semibold text-slate-950">{{ activeLink?.name || pageTitle }}</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">{{ todayLabel }}</p>
          </div>

          <div class="flex w-full flex-wrap items-center justify-end gap-3 sm:w-auto">
            <div class="rounded-3xl border border-slate-200/80 bg-white/85 px-4 py-3 text-right shadow-sm">
              <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Usuario</p>
              <p class="mt-1 text-sm font-semibold text-slate-900">{{ page.props.auth?.user?.name || 'Equipo' }}</p>
              <p class="text-xs text-slate-500">{{ page.props.auth?.user?.email || 'Sin correo' }}</p>
            </div>
          </div>
        </header>

        <FlashBanner :success="page.props.flash?.success" :error="page.props.flash?.error" />

        <main class="min-w-0 flex-1 pb-4">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
