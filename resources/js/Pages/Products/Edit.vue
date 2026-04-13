<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ record: Object });
const form = useForm(record);
const save = () => form.put('/products/${record.id}');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Edit Product</h1>
      <input v-model="form.company_id" placeholder="company_id" class="field" />
      <input v-model="form.category_id" placeholder="category_id" class="field" />
      <input v-model="form.unit_id" placeholder="unit_id" class="field" />
      <input v-model="form.sku" placeholder="sku" class="field" />
      <input v-model="form.name" placeholder="name" class="field" />
      <input v-model="form.cost" placeholder="cost" class="field" />
      <input v-model="form.price" placeholder="price" class="field" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
