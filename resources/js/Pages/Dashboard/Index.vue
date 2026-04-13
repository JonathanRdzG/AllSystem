<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';

defineProps({ stats: Object });

const cards = [
  { key: 'customers', title: 'Clientes', hint: 'Registros activos', accent: 'from-violet-500/20 to-transparent' },
  { key: 'products', title: 'Productos', hint: 'Catálogo disponible', accent: 'from-indigo-500/20 to-transparent' },
  { key: 'quotes', title: 'Cotizaciones', hint: 'Solicitudes generadas', accent: 'from-fuchsia-500/20 to-transparent' },
  { key: 'sales', title: 'Ventas', hint: 'Operaciones cerradas', accent: 'from-purple-500/20 to-transparent' },
  { key: 'serviceOrders', title: 'Órdenes', hint: 'Servicios en curso', accent: 'from-blue-500/20 to-transparent' },
];
</script>

<template>
  <AdminLayout>
    <section class="space-y-5">
      <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
          <h1 class="section-heading">Dashboard</h1>
          <p class="section-description">Resumen operativo de módulos y actividad del sistema.</p>
        </div>
        <div class="flex gap-2">
          <button class="btn-secondary">Últimos 30 días</button>
          <button class="btn-primary">Exportar</button>
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
              <h2 class="text-base font-semibold text-slate-900">Rendimiento semanal</h2>
              <p class="text-sm text-slate-500">Comportamiento consolidado de ventas y cotizaciones.</p>
            </div>
            <button class="btn-ghost">Ver detalle</button>
          </div>
          <div class="grid h-64 place-items-center rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/40 text-sm text-indigo-500">
            Área reservada para gráfica principal
          </div>
        </section>

        <section class="panel-surface p-5">
          <h2 class="text-base font-semibold text-slate-900">Estado de pipeline</h2>
          <p class="mb-4 text-sm text-slate-500">Distribución rápida por etapa operativa.</p>
          <div class="space-y-3">
            <div class="rounded-xl bg-slate-50 p-3">
              <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">En revisión</p>
              <p class="text-lg font-semibold text-slate-900">{{ stats.quotes ?? 0 }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-3">
              <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Cierres</p>
              <p class="text-lg font-semibold text-slate-900">{{ stats.sales ?? 0 }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-3">
              <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Soporte</p>
              <p class="text-lg font-semibold text-slate-900">{{ stats.serviceOrders ?? 0 }}</p>
            </div>
          </div>
        </section>
      </div>
    </section>
  </AdminLayout>
</template>
