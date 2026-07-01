<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ stats: Object });

const cards = [
  { key: 'customers', title: 'Clientes', hint: 'Registros comerciales', accent: 'from-teal-400/25 to-transparent' },
  { key: 'products', title: 'Productos', hint: 'Catálogo activo', accent: 'from-sky-400/25 to-transparent' },
  { key: 'quotes', title: 'Cotizaciones', hint: 'Propuestas enviadas', accent: 'from-amber-400/25 to-transparent' },
  { key: 'sales', title: 'Ventas', hint: 'Operaciones cerradas', accent: 'from-emerald-400/25 to-transparent' },
  { key: 'serviceOrders', title: 'Órdenes', hint: 'Casos de servicio', accent: 'from-orange-400/25 to-transparent' },
];

const totalOperations = computed(() => Object.values(props.stats ?? {}).reduce((carry, value) => carry + Number(value ?? 0), 0));
const peakValue = computed(() => Math.max(...Object.values(props.stats ?? {}), 1));

const quickLinks = [
  { name: 'Nueva empresa', href: '/companies/create' },
  { name: 'Nuevo cliente', href: '/customers/create' },
  { name: 'Nueva cotización', href: '/quotes/create' },
  { name: 'Nueva orden', href: '/service-orders/create' },
];
</script>

<template>
  <AdminLayout page-title="Dashboard">
    <section class="space-y-5">
      <div class="panel-surface shell-gradient flex flex-wrap items-end justify-between gap-4 p-6 sm:p-8">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.28em] text-teal-700">Resumen general</p>
          <h1 class="section-heading mt-3">Vista operativa del sistema</h1>
          <p class="section-description mt-3 max-w-3xl">Monitorea el volumen actual de clientes, productos, ventas, cotizaciones y órdenes desde un panel unificado.</p>
        </div>
        <div class="rounded-[28px] border border-white/70 bg-white/90 px-5 py-4 shadow-sm">
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Volumen total</p>
          <p class="mt-2 text-3xl font-semibold text-slate-950">{{ totalOperations }}</p>
          <p class="mt-1 text-sm text-slate-500">Registros consolidados en todos los módulos.</p>
        </div>
      </div>

      <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <article v-for="card in cards" :key="card.key" class="panel-surface relative overflow-hidden p-5">
          <div class="absolute inset-0 bg-gradient-to-br" :class="card.accent" />
          <p class="relative text-xs font-semibold uppercase tracking-wider text-slate-500">{{ card.title }}</p>
          <p class="relative mt-3 text-3xl font-semibold text-slate-900">{{ stats[card.key] ?? 0 }}</p>
          <p class="relative mt-1 text-sm text-slate-500">{{ card.hint }}</p>
        </article>
      </div>

      <div class="grid gap-4 xl:grid-cols-3">
        <section class="panel-surface p-5 xl:col-span-2">
          <div class="mb-4 flex items-center justify-between">
            <div>
              <h2 class="text-base font-semibold text-slate-900">Balance entre módulos</h2>
              <p class="text-sm text-slate-500">Distribución visual del volumen actual por área operativa.</p>
            </div>
            <span class="status-chip-muted">Actualizado en tiempo real</span>
          </div>

          <div class="space-y-4 rounded-[28px] border border-slate-200/80 bg-slate-50/70 p-5">
            <div v-for="card in cards" :key="`${card.key}-bar`" class="space-y-2">
              <div class="flex items-center justify-between text-sm">
                <span class="font-medium text-slate-700">{{ card.title }}</span>
                <span class="text-slate-500">{{ stats[card.key] ?? 0 }}</span>
              </div>
              <div class="h-3 rounded-full bg-white">
                <div
                  class="h-3 rounded-full bg-gradient-to-r from-slate-950 via-teal-700 to-amber-500"
                  :style="{ width: `${Math.max(((stats[card.key] ?? 0) / peakValue) * 100, 10)}%` }"
                />
              </div>
            </div>
          </div>
        </section>

        <section class="panel-surface p-5">
          <h2 class="text-base font-semibold text-slate-900">Acciones rápidas</h2>
          <p class="mb-4 text-sm text-slate-500">Accede a los flujos más frecuentes sin navegar todo el menú.</p>
          <div class="space-y-3">
            <Link v-for="link in quickLinks" :key="link.href" :href="link.href" class="flex items-center justify-between rounded-2xl border border-slate-200/80 bg-white/85 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:border-slate-300 hover:bg-white">
              <span>{{ link.name }}</span>
              <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" /></svg>
            </Link>
          </div>

          <div class="mt-6 rounded-[28px] bg-slate-950 p-5 text-white">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-300/80">Estado rápido</p>
            <div class="mt-4 grid gap-3">
              <div class="rounded-2xl bg-white/8 p-3">
                <p class="text-xs uppercase tracking-wide text-white/55">Cotizaciones abiertas</p>
                <p class="mt-2 text-xl font-semibold">{{ stats.quotes ?? 0 }}</p>
              </div>
              <div class="rounded-2xl bg-white/8 p-3">
                <p class="text-xs uppercase tracking-wide text-white/55">Ventas registradas</p>
                <p class="mt-2 text-xl font-semibold">{{ stats.sales ?? 0 }}</p>
              </div>
              <div class="rounded-2xl bg-white/8 p-3">
                <p class="text-xs uppercase tracking-wide text-white/55">Órdenes activas</p>
                <p class="mt-2 text-xl font-semibold">{{ stats.serviceOrders ?? 0 }}</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>
  </AdminLayout>
</template>
