<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CustomFields from '../../Components/CustomFields.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ customFields: Array });
const form = useForm({ custom_fields: {} });
const save = () => form.post('/customers');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Create Customer</h1>
      <input v-model="form.company_id" placeholder="company_id" class="field" />
      <input v-model="form.branch_id" placeholder="branch_id" class="field" />
      <input v-model="form.name" placeholder="name" class="field" />
      <input v-model="form.tax_id" placeholder="tax_id" class="field" />
      <input v-model="form.email" placeholder="email" class="field" />
      <input v-model="form.phone" placeholder="phone" class="field" />
      <input v-model="form.notes" placeholder="notes" class="field" />
      <CustomFields :fields="customFields" v-model="form.custom_fields" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
