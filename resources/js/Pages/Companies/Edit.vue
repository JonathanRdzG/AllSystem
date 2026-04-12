<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ record: Object });
const form = useForm(record);
const save = () => form.put('/companies/${record.id}');
</script>
<template>
  <AdminLayout>
    <div class="space-y-3 max-w-3xl">
      <h1 class="text-2xl font-semibold">Edit Companie</h1>
      <input v-model="form.name" placeholder="name" class="border p-2 rounded" />
      <input v-model="form.legal_name" placeholder="legal_name" class="border p-2 rounded" />
      <input v-model="form.tax_id" placeholder="tax_id" class="border p-2 rounded" />
      <input v-model="form.email" placeholder="email" class="border p-2 rounded" />
      <input v-model="form.phone" placeholder="phone" class="border p-2 rounded" />
      <button @click="save" class="bg-blue-600 text-white px-3 py-2 rounded">Guardar</button>
    </div>
  </AdminLayout>
</template>
