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
  { key: 'name', label: 'Nombre' },
  { key: 'email', label: 'Correo' },
  { key: 'roles.0.name', label: 'Rol' },
  { key: 'active', label: 'Estado', type: 'boolean' },
];
</script>
<template>
  <AdminLayout page-title="Usuarios">
    <CrudIndex
      title="Usuarios"
      description="Gestiona accesos, asignación organizacional y estado de los usuarios del sistema."
      :rows="rows"
      :filters="filters"
      route-base="users"
      create-label="Nuevo usuario"
      :columns="columns"
    />
  </AdminLayout>
</template>
