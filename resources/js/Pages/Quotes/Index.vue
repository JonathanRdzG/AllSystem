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
  { key: 'user.name', label: 'Responsable' },
  { key: 'status', label: 'Estado', type: 'status' },
  { key: 'valid_until', label: 'Vigencia', type: 'date' },
  { key: 'total', label: 'Total', type: 'currency' },
];
</script>
<template>
  <AdminLayout page-title="Cotizaciones">
    <CrudIndex
      title="Cotizaciones"
      description="Supervisa las propuestas comerciales abiertas, aprobadas o rechazadas en un solo tablero."
      :rows="rows"
      :filters="filters"
      route-base="quotes"
      create-label="Nueva cotización"
      :columns="columns"
    />
  </AdminLayout>
</template>
