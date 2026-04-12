<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CustomFields from '../../Components/CustomFields.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ record: Object, customFields: Array });
const form = useForm({ ...record, custom_fields: {} });
const save = () => form.put('/service-orders/${record.id}');
</script>
<template>
  <AdminLayout>
    <div class="space-y-3 max-w-3xl">
      <h1 class="text-2xl font-semibold">Edit ServiceOrder</h1>
      <input v-model="form.company_id" placeholder="company_id" class="border p-2 rounded" />
      <input v-model="form.branch_id" placeholder="branch_id" class="border p-2 rounded" />
      <input v-model="form.customer_id" placeholder="customer_id" class="border p-2 rounded" />
      <input v-model="form.assigned_user_id" placeholder="assigned_user_id" class="border p-2 rounded" />
      <input v-model="form.status" placeholder="status" class="border p-2 rounded" />
      <input v-model="form.title" placeholder="title" class="border p-2 rounded" />
      <input v-model="form.description" placeholder="description" class="border p-2 rounded" />
      <input v-model="form.promise_date" placeholder="promise_date" class="border p-2 rounded" />
      <input v-model="form.comments" placeholder="comments" class="border p-2 rounded" />
      <CustomFields :fields="customFields" v-model="form.custom_fields" />
      <button @click="save" class="bg-blue-600 text-white px-3 py-2 rounded">Guardar</button>
    </div>
  </AdminLayout>
</template>
