<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ record: Object });
const form = useForm(record);
const save = () => form.put('/products/${record.id}');
</script>
<template>
  <AdminLayout>
    <div class="space-y-3 max-w-3xl">
      <h1 class="text-2xl font-semibold">Edit Product</h1>
      <input v-model="form.company_id" placeholder="company_id" class="border p-2 rounded" />
      <input v-model="form.category_id" placeholder="category_id" class="border p-2 rounded" />
      <input v-model="form.unit_id" placeholder="unit_id" class="border p-2 rounded" />
      <input v-model="form.sku" placeholder="sku" class="border p-2 rounded" />
      <input v-model="form.name" placeholder="name" class="border p-2 rounded" />
      <input v-model="form.cost" placeholder="cost" class="border p-2 rounded" />
      <input v-model="form.price" placeholder="price" class="border p-2 rounded" />
      <button @click="save" class="bg-blue-600 text-white px-3 py-2 rounded">Guardar</button>
    </div>
  </AdminLayout>
</template>
