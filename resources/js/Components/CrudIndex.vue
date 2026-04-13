<script setup>
import { Link, router } from '@inertiajs/vue3';
defineProps({ title: String, rows: Object, routeBase: String, columns: Array });

const remove = (id, routeBase) => {
  if (confirm('¿Eliminar registro?')) router.delete(`/${routeBase}/${id}`);
};
</script>

<template>
  <div class="space-y-4">
    <div class="panel-surface flex flex-wrap items-center justify-between gap-3 p-5">
      <div>
        <h1 class="section-heading">{{ title }}</h1>
        <p class="section-description">Gestión de registros y operaciones del módulo.</p>
      </div>
      <div class="flex gap-2">
        <input class="field w-44" placeholder="Buscar..." />
        <Link :href="`/${routeBase}/create`" class="btn-primary">Nuevo</Link>
      </div>
    </div>

    <div class="panel-surface overflow-hidden p-3">
      <div class="overflow-x-auto">
        <table class="data-table">
          <thead>
            <tr>
              <th v-for="c in columns" :key="c">{{ c }}</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in rows.data" :key="row.id" class="hover:bg-slate-50/70">
              <td v-for="c in columns" :key="`${row.id}-${c}`">{{ row[c] }}</td>
              <td>
                <div class="flex gap-2">
                  <Link :href="`/${routeBase}/${row.id}/edit`" class="btn-ghost !px-2 !py-1.5 text-indigo-600 hover:bg-indigo-50">Editar</Link>
                  <button class="btn-ghost !px-2 !py-1.5 text-rose-600 hover:bg-rose-50" @click="remove(row.id, routeBase)">Eliminar</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
