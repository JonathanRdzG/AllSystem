<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import ResourceForm from '../../Components/ResourceForm.vue';

const props = defineProps({
  companies: {
    type: Array,
    default: () => [],
  },
  record: {
    type: Object,
    default: null,
  },
});

const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  company_id: props.record?.company_id ?? '',
  name: props.record?.name ?? '',
  code: props.record?.code ?? '',
  address: props.record?.address ?? '',
  phone: props.record?.phone ?? '',
  active: props.record?.active ?? true,
});

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'name', label: 'Nombre de sucursal', required: true, placeholder: 'Matriz, Norte, Centro...' },
  { name: 'code', label: 'Código interno', required: true, placeholder: 'MTZ' },
  { name: 'phone', label: 'Teléfono', type: 'tel', placeholder: '+52 55 0000 0000' },
  { name: 'address', label: 'Dirección', type: 'textarea', placeholder: 'Calle, colonia, ciudad, referencias...', fullWidth: true },
  { name: 'active', label: 'Sucursal activa', type: 'checkbox', help: 'Mantén visible la sucursal para asignación de usuarios, clientes y operaciones.' },
]);

const save = () => form.post('/branches');
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar sucursal' : 'Nueva sucursal'">
    <ResourceForm
      :title="isEdit ? 'Editar sucursal' : 'Registrar sucursal'"
      description="Asigna la sucursal a una empresa y define su información operativa principal."
      :form="form"
      :fields="fields"
      submit-label="Guardar sucursal"
      cancel-href="/branches"
      @submit="save"
    />
  </AdminLayout>
</template>
