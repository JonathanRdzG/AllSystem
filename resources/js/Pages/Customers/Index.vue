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
  { key: 'branch.name', label: 'Sucursal' },
  { key: 'name', label: 'Cliente' },
  { key: 'email', label: 'Correo' },
  { key: 'phone', label: 'Teléfono' },
  { key: 'active', label: 'Estado', type: 'boolean' },
];
</script>
<template>
  <AdminLayout page-title="Clientes">
    <CrudIndex
      title="Clientes"
      description="Conserva el padrón comercial ordenado, con relación directa a empresa y sucursal."
      :rows="rows"
      :filters="filters"
      route-base="customers"
      create-label="Nuevo cliente"
      :columns="columns"
    />
  </AdminLayout>
</template>
