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
  { key: 'sku', label: 'SKU' },
  { key: 'name', label: 'Producto' },
  { key: 'category.name', label: 'Categoría' },
  { key: 'unit.name', label: 'Unidad' },
  { key: 'price', label: 'Precio', type: 'currency' },
  { key: 'active', label: 'Estado', type: 'boolean' },
];
</script>
<template>
  <AdminLayout page-title="Productos">
    <CrudIndex
      title="Productos"
      description="Mantén organizado el catálogo comercial con categorías, unidades y precios consistentes."
      :rows="rows"
      :filters="filters"
      route-base="products"
      create-label="Nuevo producto"
      :columns="columns"
    />
  </AdminLayout>
</template>
