<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import ResourceForm from '../../Components/ResourceForm.vue';

const props = defineProps({
  record: {
    type: Object,
    required: true,
  },
});

const isEdit = computed(() => Boolean(props.record));

const form = useForm({
  name: props.record?.name ?? '',
  legal_name: props.record?.legal_name ?? '',
  tax_id: props.record?.tax_id ?? '',
  email: props.record?.email ?? '',
  phone: props.record?.phone ?? '',
  active: props.record?.active ?? true,
});

const fields = [
  { name: 'name', label: 'Nombre comercial', required: true, placeholder: 'AllSystem MX' },
  { name: 'legal_name', label: 'Razón social', placeholder: 'AllSystem MX SA de CV' },
  { name: 'tax_id', label: 'RFC / Tax ID', placeholder: 'ASM010101ABC' },
  { name: 'email', label: 'Correo corporativo', type: 'email', placeholder: 'contacto@empresa.com' },
  { name: 'phone', label: 'Teléfono', type: 'tel', placeholder: '+52 55 0000 0000' },
  { name: 'active', label: 'Empresa activa', type: 'checkbox', help: 'Desactiva la empresa si ya no debe operar dentro del sistema.' },
];

const save = () => form.put(`/companies/${props.record.id}`);
</script>
<template>
  <AdminLayout :page-title="isEdit ? 'Editar empresa' : 'Nueva empresa'">
    <ResourceForm
      :title="isEdit ? 'Editar empresa' : 'Registrar empresa'"
      description="Actualiza la información corporativa y los medios de contacto de la empresa."
      :form="form"
      :fields="fields"
      submit-label="Actualizar empresa"
      cancel-href="/companies"
      @submit="save"
    />
  </AdminLayout>
</template>
