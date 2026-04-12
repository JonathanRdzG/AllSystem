<script setup>
import { Link, router } from '@inertiajs/vue3';
defineProps({ title: String, rows: Object, routeBase: String, columns: Array });
const remove = (id, routeBase) => {
  if (confirm('¿Eliminar registro?')) router.delete(`/${routeBase}/${id}`);
};
</script>

<template>
  <div class="space-y-4">
    <div class="flex justify-between">
      <h1 class="text-2xl font-semibold">{{ title }}</h1>
      <Link :href="`/${routeBase}/create`" class="bg-blue-600 text-white px-3 py-2 rounded">Nuevo</Link>
    </div>
    <table class="w-full bg-white shadow rounded">
      <thead>
        <tr>
          <th class="p-2 text-left" v-for="c in columns" :key="c">{{ c }}</th>
          <th class="p-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in rows.data" :key="row.id" class="border-t">
          <td class="p-2" v-for="c in columns" :key="`${row.id}-${c}`">{{ row[c] }}</td>
          <td class="p-2 space-x-2">
            <Link :href="`/${routeBase}/${row.id}/edit`" class="text-blue-600">Editar</Link>
            <button class="text-red-600" @click="remove(row.id, routeBase)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
