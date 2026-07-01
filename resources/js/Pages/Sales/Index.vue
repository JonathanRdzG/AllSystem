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
  { key: 'sale_date', label: 'Fecha', type: 'date' },
  { key: 'total', label: 'Total', type: 'currency' },
];
</script>
<template>
  <AdminLayout page-title="Ventas">
    <CrudIndex
      title="Ventas"
      description="Da seguimiento al cierre comercial con fechas, responsables y totales ya concretados."
      :rows="rows"
      :filters="filters"
      route-base="sales"
      create-label="Nueva venta"
      :columns="columns"
    />
  </AdminLayout>
</template>
