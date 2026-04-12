<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CustomFields from '../../Components/CustomFields.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ record: Object, customFields: Array });
const form = useForm({ ...record, custom_fields: {} });
const save = () => form.put('/customers/${record.id}');
</script>
<template>
  <AdminLayout>
    <div class="space-y-3 max-w-3xl">
      <h1 class="text-2xl font-semibold">Edit Customer</h1>
      <input v-model="form.company_id" placeholder="company_id" class="border p-2 rounded" />
      <input v-model="form.branch_id" placeholder="branch_id" class="border p-2 rounded" />
      <input v-model="form.name" placeholder="name" class="border p-2 rounded" />
      <input v-model="form.tax_id" placeholder="tax_id" class="border p-2 rounded" />
      <input v-model="form.email" placeholder="email" class="border p-2 rounded" />
      <input v-model="form.phone" placeholder="phone" class="border p-2 rounded" />
      <input v-model="form.notes" placeholder="notes" class="border p-2 rounded" />
      <CustomFields :fields="customFields" v-model="form.custom_fields" />
      <button @click="save" class="bg-blue-600 text-white px-3 py-2 rounded">Guardar</button>
    </div>
  </AdminLayout>
</template>
