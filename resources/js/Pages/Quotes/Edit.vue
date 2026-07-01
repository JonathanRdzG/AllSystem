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
  branches: {
    type: Array,
    default: () => [],
  },
  customers: {
    type: Array,
    default: () => [],
  },
  users: {
    type: Array,
    default: () => [],
  },
  statuses: {
    type: Array,
    default: () => [],
  },
});

const toDateInput = (value) => (value ? String(value).slice(0, 10) : '');
const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  company_id: props.record?.company_id ?? '',
  branch_id: props.record?.branch_id ?? '',
  customer_id: props.record?.customer_id ?? '',
  user_id: props.record?.user_id ?? '',
  status: props.record?.status ?? props.statuses[0] ?? 'draft',
  valid_until: toDateInput(props.record?.valid_until),
  notes: props.record?.notes ?? '',
  total: props.record?.total ?? '',
});

const branchOptions = computed(() => filterByCompany(props.branches, form.company_id));
const customerOptions = computed(() => filterByCompany(props.customers, form.company_id));
const userOptions = computed(() => filterByCompany(props.users, form.company_id));

watch(
  () => form.company_id,
  () => {
    if (!branchOptions.value.some((branch) => sameId(branch.id, form.branch_id))) {
      form.branch_id = '';
    }
    if (!customerOptions.value.some((customer) => sameId(customer.id, form.customer_id))) {
      form.customer_id = '';
    }
    if (!userOptions.value.some((user) => sameId(user.id, form.user_id))) {
      form.user_id = '';
    }
  },
);

const statusOptions = computed(() => props.statuses.map((status) => ({ value: status, label: status })));

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'branch_id', label: 'Sucursal', type: 'select', required: true, options: branchOptions.value, placeholder: 'Selecciona una sucursal' },
  { name: 'customer_id', label: 'Cliente', type: 'select', required: true, options: customerOptions.value, placeholder: 'Selecciona un cliente' },
  { name: 'user_id', label: 'Responsable', type: 'select', required: true, options: userOptions.value, placeholder: 'Selecciona un usuario' },
  { name: 'status', label: 'Estado', type: 'select', required: true, options: statusOptions.value, placeholder: 'Selecciona un estado' },
  { name: 'valid_until', label: 'Vigente hasta', type: 'date', required: true },
  { name: 'total', label: 'Total estimado', type: 'number', required: true, step: '0.01', min: '0', placeholder: '0.00' },
  { name: 'notes', label: 'Notas', type: 'textarea', placeholder: 'Condiciones, alcances o comentarios para el cliente...', fullWidth: true },
]);

const save = () => form.put(`/quotes/${props.record.id}`);
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar cotización' : 'Nueva cotización'">
    <ResourceForm
      :title="isEdit ? 'Editar cotización' : 'Registrar cotización'"
      description="Actualiza vigencia, responsable y monto total sin perder seguimiento comercial."
      :form="form"
      :fields="fields"
      submit-label="Actualizar cotización"
      cancel-href="/quotes"
      @submit="save"
    />
  </AdminLayout>
</template>
