<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({});
const form = useForm({});
const save = () => form.post('/users');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Create User</h1>
      <input v-model="form.company_id" placeholder="company_id" class="field" />
      <input v-model="form.branch_id" placeholder="branch_id" class="field" />
      <input v-model="form.name" placeholder="name" class="field" />
      <input v-model="form.email" placeholder="email" class="field" />
      <input v-model="form.password" placeholder="password" class="field" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
