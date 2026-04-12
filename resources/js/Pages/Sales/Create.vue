<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({});
const form = useForm({});
const save = () => form.post('/sales');
</script>
<template>
  <AdminLayout>
    <div class="space-y-3 max-w-3xl">
      <h1 class="text-2xl font-semibold">Create Sale</h1>
      <input v-model="form.company_id" placeholder="company_id" class="border p-2 rounded" />
      <input v-model="form.branch_id" placeholder="branch_id" class="border p-2 rounded" />
      <input v-model="form.customer_id" placeholder="customer_id" class="border p-2 rounded" />
      <input v-model="form.quote_id" placeholder="quote_id" class="border p-2 rounded" />
      <input v-model="form.user_id" placeholder="user_id" class="border p-2 rounded" />
      <input v-model="form.status" placeholder="status" class="border p-2 rounded" />
      <input v-model="form.sale_date" placeholder="sale_date" class="border p-2 rounded" />
      <input v-model="form.total" placeholder="total" class="border p-2 rounded" />
      <button @click="save" class="bg-blue-600 text-white px-3 py-2 rounded">Guardar</button>
    </div>
  </AdminLayout>
</template>
