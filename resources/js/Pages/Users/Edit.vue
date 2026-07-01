<script setup>
import { computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import ResourceForm from '../../Components/ResourceForm.vue';
import { filterByCompany, sameId } from '../../lib/forms';

const props = defineProps({
  record: {
    type: Object,
    required: true,
  },
  companies: {
    type: Array,
    default: () => [],
  },
  branches: {
    type: Array,
    default: () => [],
  },
});

const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  company_id: props.record?.company_id ?? '',
  branch_id: props.record?.branch_id ?? '',
  name: props.record?.name ?? '',
  email: props.record?.email ?? '',
  password: '',
  password_confirmation: '',
  active: props.record?.active ?? true,
});

const branchOptions = computed(() => filterByCompany(props.branches, form.company_id));

watch(
  () => form.company_id,
  () => {
    if (!branchOptions.value.some((branch) => sameId(branch.id, form.branch_id))) {
      form.branch_id = '';
    }
  },
);

const fields = computed(() => [
  { name: 'company_id', label: 'Empresa', type: 'select', required: true, options: props.companies, placeholder: 'Selecciona una empresa' },
  { name: 'branch_id', label: 'Sucursal', type: 'select', required: true, options: branchOptions.value, placeholder: 'Selecciona una sucursal' },
  { name: 'name', label: 'Nombre completo', required: true, placeholder: 'Nombre del usuario' },
  { name: 'email', label: 'Correo electrónico', type: 'email', required: true, placeholder: 'usuario@empresa.com' },
  { name: 'password', label: 'Nueva contraseña', type: 'password', placeholder: 'Déjala en blanco para conservar la actual', autocomplete: 'new-password' },
  { name: 'password_confirmation', label: 'Confirmar nueva contraseña', type: 'password', placeholder: 'Repite la nueva contraseña', autocomplete: 'new-password' },
  { name: 'active', label: 'Usuario activo', type: 'checkbox', help: 'Los usuarios inactivos no podrán iniciar sesión.' },
]);

const save = () => form.put(`/users/${props.record.id}`);
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar usuario' : 'Nuevo usuario'">
    <ResourceForm
      :title="isEdit ? 'Editar usuario' : 'Registrar usuario'"
      description="Actualiza la identidad, ubicación organizacional y credenciales de acceso de este usuario."
      :form="form"
      :fields="fields"
      submit-label="Actualizar usuario"
      cancel-href="/users"
      @submit="save"
    />
  </AdminLayout>
</template>
