<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({});
const form = useForm({});
const save = () => form.post('/branches');
</script>
<template>
  <AdminLayout>
    <div class="form-shell">
      <h1 class="section-heading">Create Branche</h1>
      <input v-model="form.company_id" placeholder="company_id" class="field" />
      <input v-model="form.name" placeholder="name" class="field" />
      <input v-model="form.code" placeholder="code" class="field" />
      <input v-model="form.address" placeholder="address" class="field" />
      <input v-model="form.phone" placeholder="phone" class="field" />
      <button @click="save" class="btn-primary">Guardar</button>
    </div>
  </AdminLayout>
</template>
