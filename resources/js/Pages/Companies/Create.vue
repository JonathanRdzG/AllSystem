<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({});
const form = useForm({});
const save = () => form.post('/companies');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Create Companie</h1>
      <input v-model="form.name" placeholder="name" class="field" />
      <input v-model="form.legal_name" placeholder="legal_name" class="field" />
      <input v-model="form.tax_id" placeholder="tax_id" class="field" />
      <input v-model="form.email" placeholder="email" class="field" />
      <input v-model="form.phone" placeholder="phone" class="field" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
