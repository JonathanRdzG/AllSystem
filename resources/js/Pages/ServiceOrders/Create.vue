<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CustomFields from '../../Components/CustomFields.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ customFields: Array });
const form = useForm({ custom_fields: {} });
const save = () => form.post('/service-orders');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Create ServiceOrder</h1>
      <input v-model="form.company_id" placeholder="company_id" class="field" />
      <input v-model="form.branch_id" placeholder="branch_id" class="field" />
      <input v-model="form.customer_id" placeholder="customer_id" class="field" />
      <input v-model="form.assigned_user_id" placeholder="assigned_user_id" class="field" />
      <input v-model="form.status" placeholder="status" class="field" />
      <input v-model="form.title" placeholder="title" class="field" />
      <input v-model="form.description" placeholder="description" class="field" />
      <input v-model="form.promise_date" placeholder="promise_date" class="field" />
      <input v-model="form.comments" placeholder="comments" class="field" />
      <CustomFields :fields="customFields" v-model="form.custom_fields" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
