<script setup>
import { computed, ref, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
  title: String,
  description: {
    type: String,
    default: 'Gestión de registros y operaciones del módulo.',
  },
  rows: Object,
  routeBase: String,
  columns: Array,
  filters: {
    type: Object,
    default: () => ({}),
  },
  createLabel: {
    type: String,
    default: 'Nuevo registro',
  },
});

const search = ref(props.filters.search ?? '');

watch(
  () => props.filters.search,
  (value) => {
    search.value = value ?? '';
  },
);

const remove = (id) => {
  if (confirm('¿Eliminar este registro? Esta acción no se puede deshacer.')) {
    router.delete(`/${props.routeBase}/${id}`, {
      preserveScroll: true,
    });
  }
};

const resolveValue = (row, key) => key.split('.').reduce((carry, part) => carry?.[part], row);

const formatValue = (value, column) => {
  if (value === null || value === undefined || value === '') {
    return '—';
  }

  if (column.type === 'boolean') {
    return value ? 'Activo' : 'Inactivo';
  }

  if (column.type === 'currency') {
    return Number(value).toLocaleString('es-MX', {
      style: 'currency',
      currency: 'MXN',
    });
  }

  if (column.type === 'date') {
    return new Intl.DateTimeFormat('es-MX', { dateStyle: 'medium' }).format(new Date(`${value}T00:00:00`));
  }

  return value;
};

const cellClass = (column, value) => {
  if (column.type === 'boolean') {
    return value ? 'status-chip-positive' : 'status-chip-muted';
  }

  if (column.type === 'status') {
    const normalized = String(value).toLowerCase();

    if (['paid', 'approved', 'done', 'active'].includes(normalized)) {
      return 'status-chip-positive';
    }

    if (['partial', 'sent', 'in_progress', 'open'].includes(normalized)) {
      return 'status-chip-warning';
    }

    if (['cancelled', 'rejected', 'inactive'].includes(normalized)) {
      return 'status-chip-danger';
    }

    return 'status-chip-muted';
  }

  return '';
};

const runSearch = () => {
  router.get(`/${props.routeBase}`, {
    search: search.value || undefined,
  }, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
};

const resetSearch = () => {
  search.value = '';
  runSearch();
};

const paginationLinks = computed(() => props.rows?.links ?? []);
</script>

<template>
  <div class="space-y-4">
    <div class="panel-surface shell-gradient flex flex-wrap items-center justify-between gap-4 p-5 sm:p-6">
      <div>
        <h1 class="section-heading">{{ title }}</h1>
        <p class="section-description mt-2 max-w-2xl">{{ description }}</p>
      </div>

      <form class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row" @submit.prevent="runSearch">
        <input v-model="search" class="field min-w-0 sm:w-64" type="search" placeholder="Buscar por texto..." />
        <div class="flex gap-2">
          <button type="submit" class="btn-secondary">Buscar</button>
          <button v-if="search" type="button" class="btn-ghost" @click="resetSearch">Limpiar</button>
          <Link :href="`/${routeBase}/create`" class="btn-primary">{{ createLabel }}</Link>
        </div>
      </form>
    </div>

    <div v-if="!rows.data.length" class="panel-surface p-8 text-center">
      <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h10" /></svg>
      </div>
      <h2 class="mt-4 text-lg font-semibold text-slate-900">No hay registros para mostrar</h2>
      <p class="mt-2 text-sm leading-6 text-slate-500">Ajusta los filtros o crea un nuevo registro para comenzar a trabajar en este módulo.</p>
    </div>

    <div v-else class="panel-surface overflow-hidden p-3">
      <div class="overflow-x-auto">
        <table class="data-table">
          <thead>
            <tr>
              <th v-for="column in columns" :key="column.key">{{ column.label }}</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in rows.data" :key="row.id" class="hover:bg-white">
              <td v-for="column in columns" :key="`${row.id}-${column.key}`">
                <span :class="cellClass(column, resolveValue(row, column.key))">
                  {{ formatValue(resolveValue(row, column.key), column) }}
                </span>
              </td>
              <td>
                <div class="flex gap-2">
                  <Link :href="`/${routeBase}/${row.id}/edit`" class="btn-ghost !px-3 !py-2 text-teal-700 hover:bg-teal-50">Editar</Link>
                  <button class="btn-ghost !px-3 !py-2 text-rose-600 hover:bg-rose-50" @click="remove(row.id)">Eliminar</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-4 flex flex-wrap items-center justify-between gap-3 px-2 pb-2">
        <p class="text-sm text-slate-500">
          Mostrando {{ rows.from || 0 }} - {{ rows.to || 0 }} de {{ rows.total || 0 }} registros
        </p>

        <div class="flex flex-wrap gap-2">
          <template v-for="link in paginationLinks" :key="`${routeBase}-${link.label}`">
            <Link
              v-if="link.url"
              :href="link.url"
              class="btn-secondary !rounded-xl !px-3 !py-2 text-sm"
              :class="link.active ? '!border-slate-900 !bg-slate-900 !text-white' : ''"
              v-html="link.label"
            />
            <span v-else class="btn-secondary !rounded-xl !px-3 !py-2 text-sm opacity-45" v-html="link.label" />
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
