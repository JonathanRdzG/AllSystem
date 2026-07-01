<script setup>
import { computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import ResourceForm from '../../Components/ResourceForm.vue';
import { filterByCompany, quoteOptionLabel, sameId } from '../../lib/forms';

const props = defineProps({
  record: {
    type: Object,
    default: null,
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
  quotes: {
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
  quote_id: props.record?.quote_id ?? '',
  user_id: props.record?.user_id ?? '',
  status: props.record?.status ?? props.statuses[0] ?? 'draft',
  sale_date: toDateInput(props.record?.sale_date),
  total: props.record?.total ?? '',
});

const branchOptions = computed(() => filterByCompany(props.branches, form.company_id));
const customerOptions = computed(() => filterByCompany(props.customers, form.company_id));
const quoteOptions = computed(() => filterByCompany(props.quotes, form.company_id).map((quote) => ({
  value: quote.id,
  label: quoteOptionLabel(quote),
})));
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
    if (!quoteOptions.value.some((quote) => sameId(quote.value, form.quote_id))) {
      form.quote_id = '';
    }
    if (!userOptions.value.some((user) => sameId(user.id, form.user_id))) {
      form.user_id = '';
    }
  },
);

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'branch_id', label: 'Sucursal', type: 'select', required: true, options: branchOptions.value, placeholder: 'Selecciona una sucursal' },
  { name: 'customer_id', label: 'Cliente', type: 'select', required: true, options: customerOptions.value, placeholder: 'Selecciona un cliente' },
  { name: 'quote_id', label: 'Cotización asociada', type: 'select', options: quoteOptions.value, placeholder: 'Opcional' },
  { name: 'user_id', label: 'Responsable', type: 'select', required: true, options: userOptions.value, placeholder: 'Selecciona un usuario' },
  { name: 'status', label: 'Estado', type: 'select', required: true, options: statusOptions.value, placeholder: 'Selecciona un estado' },
  { name: 'sale_date', label: 'Fecha de venta', type: 'date', required: true },
  { name: 'total', label: 'Total cobrado', type: 'number', required: true, step: '0.01', min: '0', placeholder: '0.00' },
]);

const save = () => form.post('/sales');
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar venta' : 'Nueva venta'">
    <ResourceForm
      :title="isEdit ? 'Editar venta' : 'Registrar venta'"
      description="Registra el cierre de una venta vinculando cliente, responsable y, cuando aplique, una cotización previa."
      :form="form"
      :fields="fields"
      submit-label="Guardar venta"
      cancel-href="/sales"
      @submit="save"
    />
  </AdminLayout>
</template>
