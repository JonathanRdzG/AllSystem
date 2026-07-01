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
  customFields: {
    type: Array,
    default: () => [],
  },
  customFieldValues: {
    type: Object,
    default: () => ({}),
  },
});

const toDateInput = (value) => (value ? String(value).slice(0, 10) : '');
const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  company_id: props.record?.company_id ?? '',
  branch_id: props.record?.branch_id ?? '',
  customer_id: props.record?.customer_id ?? '',
  assigned_user_id: props.record?.assigned_user_id ?? '',
  status: props.record?.status ?? props.statuses[0] ?? 'open',
  title: props.record?.title ?? '',
  description: props.record?.description ?? '',
  promise_date: toDateInput(props.record?.promise_date),
  comments: props.record?.comments ?? '',
  custom_fields: { ...props.customFieldValues },
});

const branchOptions = computed(() => filterByCompany(props.branches, form.company_id));
const customerOptions = computed(() => filterByCompany(props.customers, form.company_id));
const userOptions = computed(() => filterByCompany(props.users, form.company_id));
const statusOptions = computed(() => props.statuses.map((status) => ({ value: status, label: status })));

watch(
  () => form.company_id,
  () => {
    if (!branchOptions.value.some((branch) => sameId(branch.id, form.branch_id))) {
      form.branch_id = '';
    }
    if (!customerOptions.value.some((customer) => sameId(customer.id, form.customer_id))) {
      form.customer_id = '';
    }
    if (!userOptions.value.some((user) => sameId(user.id, form.assigned_user_id))) {
      form.assigned_user_id = '';
    }
  },
);

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'branch_id', label: 'Sucursal', type: 'select', required: true, options: branchOptions.value, placeholder: 'Selecciona una sucursal' },
  { name: 'customer_id', label: 'Cliente', type: 'select', required: true, options: customerOptions.value, placeholder: 'Selecciona un cliente' },
  { name: 'assigned_user_id', label: 'Asignado a', type: 'select', options: userOptions.value, placeholder: 'Opcional' },
  { name: 'status', label: 'Estado', type: 'select', required: true, options: statusOptions.value, placeholder: 'Selecciona un estado' },
  { name: 'title', label: 'Título', required: true, placeholder: 'Revisión de instalación' },
  { name: 'promise_date', label: 'Fecha promesa', type: 'date' },
  { name: 'description', label: 'Descripción', type: 'textarea', placeholder: 'Describe el servicio, la falla o el alcance solicitado...', fullWidth: true },
  { name: 'comments', label: 'Comentarios internos', type: 'textarea', placeholder: 'Observaciones para el equipo operativo...', fullWidth: true },
]);

const save = () => form.put(`/service-orders/${props.record.id}`);
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar orden de servicio' : 'Nueva orden de servicio'">
    <ResourceForm
      :title="isEdit ? 'Editar orden de servicio' : 'Registrar orden de servicio'"
      description="Actualiza el contexto operativo de la orden y sus datos personalizados."
      :form="form"
      :fields="fields"
      submit-label="Actualizar orden"
      cancel-href="/service-orders"
      @submit="save"
    >
      <template #after-fields>
        <CustomFields v-if="customFields.length" :fields="customFields" v-model="form.custom_fields" />
      </template>
    </ResourceForm>
  </AdminLayout>
</template>
