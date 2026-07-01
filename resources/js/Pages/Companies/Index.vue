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
  { key: 'name', label: 'Nombre' },
  { key: 'legal_name', label: 'Razón social' },
  { key: 'tax_id', label: 'RFC / Tax ID' },
  { key: 'email', label: 'Correo' },
  { key: 'active', label: 'Estado', type: 'boolean' },
];
</script>
<template>
  <AdminLayout page-title="Empresas">
    <CrudIndex
      title="Empresas"
      description="Administra la información principal de cada empresa registrada en la plataforma."
      :rows="rows"
      :filters="filters"
      route-base="companies"
      create-label="Nueva empresa"
      :columns="columns"
    />
  </AdminLayout>
</template>
