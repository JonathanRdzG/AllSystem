<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
defineProps({ stats: Object });
</script>
<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <div class="grid grid-cols-5 gap-4">
      <div class="bg-white p-4 rounded shadow">Clientes: {{ stats.customers }}</div>
      <div class="bg-white p-4 rounded shadow">Productos: {{ stats.products }}</div>
      <div class="bg-white p-4 rounded shadow">Cotizaciones: {{ stats.quotes }}</div>
      <div class="bg-white p-4 rounded shadow">Ventas: {{ stats.sales }}</div>
      <div class="bg-white p-4 rounded shadow">Ordenes: {{ stats.serviceOrders }}</div>
    </div>
  </AdminLayout>
</template>
