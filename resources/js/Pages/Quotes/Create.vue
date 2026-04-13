<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({});
const form = useForm({});
const save = () => form.post('/quotes');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Create Quote</h1>
      <input v-model="form.company_id" placeholder="company_id" class="field" />
      <input v-model="form.branch_id" placeholder="branch_id" class="field" />
      <input v-model="form.customer_id" placeholder="customer_id" class="field" />
      <input v-model="form.user_id" placeholder="user_id" class="field" />
      <input v-model="form.status" placeholder="status" class="field" />
      <input v-model="form.valid_until" placeholder="valid_until" class="field" />
      <input v-model="form.total" placeholder="total" class="field" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
