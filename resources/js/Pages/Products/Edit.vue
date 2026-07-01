<script setup>
import { computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import ResourceForm from '../../Components/ResourceForm.vue';
import { filterByCompany, sameId } from '../../lib/forms';

const props = defineProps({
  record: {
    type: Object,
    required: true,
  },
  companies: {
    type: Array,
    default: () => [],
  },
  categories: {
    type: Array,
    default: () => [],
  },
  units: {
    type: Array,
    default: () => [],
  },
});

const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  company_id: props.record?.company_id ?? '',
  category_id: props.record?.category_id ?? '',
  unit_id: props.record?.unit_id ?? '',
  sku: props.record?.sku ?? '',
  name: props.record?.name ?? '',
  description: props.record?.description ?? '',
  cost: props.record?.cost ?? '',
  price: props.record?.price ?? '',
  active: props.record?.active ?? true,
});

const categoryOptions = computed(() => filterByCompany(props.categories, form.company_id));
const unitOptions = computed(() => filterByCompany(props.units, form.company_id));

watch(
  () => form.company_id,
  () => {
    if (!categoryOptions.value.some((category) => sameId(category.id, form.category_id))) {
      form.category_id = '';
    }

    if (!unitOptions.value.some((unit) => sameId(unit.id, form.unit_id))) {
      form.unit_id = '';
    }
  },
);

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'category_id', label: 'Categoría', type: 'select', required: true, options: categoryOptions.value, placeholder: 'Selecciona una categoría' },
  { name: 'unit_id', label: 'Unidad', type: 'select', required: true, options: unitOptions.value, placeholder: 'Selecciona una unidad' },
  { name: 'sku', label: 'SKU', required: true, placeholder: 'PROD-001' },
  { name: 'name', label: 'Nombre del producto', required: true, placeholder: 'Batería 12V' },
  { name: 'cost', label: 'Costo', type: 'number', required: true, step: '0.01', min: '0', placeholder: '0.00' },
  { name: 'price', label: 'Precio de venta', type: 'number', required: true, step: '0.01', min: '0', placeholder: '0.00' },
  { name: 'description', label: 'Descripción', type: 'textarea', placeholder: 'Características, notas técnicas o detalles comerciales...', fullWidth: true },
  { name: 'active', label: 'Producto activo', type: 'checkbox', help: 'Los productos inactivos se ocultan del flujo comercial sin perder historial.' },
]);

const save = () => form.put(`/products/${props.record.id}`);
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar producto' : 'Nuevo producto'">
    <ResourceForm
      :title="isEdit ? 'Editar producto' : 'Registrar producto'"
      description="Actualiza la definición comercial del producto sin perder consistencia entre catálogos."
      :form="form"
      :fields="fields"
      submit-label="Actualizar producto"
      cancel-href="/products"
      @submit="save"
    />
  </AdminLayout>
</template>
