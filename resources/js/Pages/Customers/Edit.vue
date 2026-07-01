<script setup>
import { computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CustomFields from '../../Components/CustomFields.vue';
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
  branches: {
    type: Array,
    default: () => [],
  },
  customFields: {
    type: Array,
    default: () => [],
  },
  customFieldValues: {
    type: Object,
    default: () => ({}),
  },
});

const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  company_id: props.record?.company_id ?? '',
  branch_id: props.record?.branch_id ?? '',
  name: props.record?.name ?? '',
  tax_id: props.record?.tax_id ?? '',
  email: props.record?.email ?? '',
  phone: props.record?.phone ?? '',
  notes: props.record?.notes ?? '',
  active: props.record?.active ?? true,
  custom_fields: { ...props.customFieldValues },
});

const branchOptions = computed(() => filterByCompany(props.branches, form.company_id));

watch(
  () => form.company_id,
  () => {
    if (!branchOptions.value.some((branch) => sameId(branch.id, form.branch_id))) {
      form.branch_id = '';
    }
  },
);

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'branch_id', label: 'Sucursal', type: 'select', required: true, options: branchOptions.value, placeholder: 'Selecciona una sucursal' },
  { name: 'name', label: 'Nombre del cliente', required: true, placeholder: 'Razón comercial o nombre' },
  { name: 'tax_id', label: 'RFC / Tax ID', placeholder: 'RFC o identificador fiscal' },
  { name: 'email', label: 'Correo electrónico', type: 'email', placeholder: 'cliente@empresa.com' },
  { name: 'phone', label: 'Teléfono', type: 'tel', placeholder: '+52 55 0000 0000' },
  { name: 'notes', label: 'Notas internas', type: 'textarea', placeholder: 'Datos relevantes de atención, cobranza o seguimiento...', fullWidth: true },
  { name: 'active', label: 'Cliente activo', type: 'checkbox', help: 'Ocúltalo del flujo operativo sin perder su historial.' },
]);

const save = () => form.put(`/customers/${props.record.id}`);
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar cliente' : 'Nuevo cliente'">
    <ResourceForm
      :title="isEdit ? 'Editar cliente' : 'Registrar cliente'"
      description="Actualiza los datos base del cliente y sus atributos configurables."
      :form="form"
      :fields="fields"
      submit-label="Actualizar cliente"
      cancel-href="/customers"
      @submit="save"
    >
      <template #after-fields>
        <CustomFields v-if="customFields.length" :fields="customFields" v-model="form.custom_fields" />
      </template>
    </ResourceForm>
  </AdminLayout>
</template>
