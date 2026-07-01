<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';

defineProps({
  rows: Object,
  filters: {
    type: Object,
    default: () => ({}),
  },
});

const columns = [
  { key: 'customer.name', label: 'Cliente' },
  { key: 'assigned_user.name', label: 'Asignado a' },
  { key: 'title', label: 'Título' },
  { key: 'status', label: 'Estado', type: 'status' },
  { key: 'promise_date', label: 'Promesa', type: 'date' },
];
</script>
<template>
  <AdminLayout page-title="Órdenes de servicio">
    <CrudIndex
      title="Órdenes de servicio"
      description="Administra el trabajo postventa con responsables, prioridades y fechas compromiso."
      :rows="rows"
      :filters="filters"
      route-base="service-orders"
      create-label="Nueva orden"
      :columns="columns"
    />
  </AdminLayout>
</template>
