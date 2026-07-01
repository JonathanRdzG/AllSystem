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
  { key: 'company.name', label: 'Empresa' },
  { key: 'name', label: 'Sucursal' },
  { key: 'code', label: 'Código' },
  { key: 'phone', label: 'Teléfono' },
  { key: 'active', label: 'Estado', type: 'boolean' },
];
</script>
<template>
  <AdminLayout page-title="Sucursales">
    <CrudIndex
      title="Sucursales"
      description="Organiza las sedes operativas vinculadas a cada empresa y mantén sus datos de contacto actualizados."
      :rows="rows"
      :filters="filters"
      route-base="branches"
      create-label="Nueva sucursal"
      :columns="columns"
    />
  </AdminLayout>
</template>
