<script setup>
defineProps({ fields: Array, modelValue: Object });
const emit = defineEmits(['update:modelValue']);
const update = (name, value) => emit('update:modelValue', { ...modelValue, [name]: value });
</script>

<template>
  <div class="grid grid-cols-1 gap-4 rounded-2xl border border-slate-200 bg-slate-50/60 p-4 md:grid-cols-2">
    <div v-for="field in fields" :key="field.id">
      <label class="field-label">{{ field.label }}</label>
      <input
        v-if="field.field_type === 'text' || field.field_type === 'integer' || field.field_type === 'decimal' || field.field_type === 'date'"
        :type="field.field_type === 'date' ? 'date' : 'text'"
        class="field"
        :value="modelValue[field.internal_name] || ''"
        @input="update(field.internal_name, $event.target.value)"
      >
      <textarea v-else-if="field.field_type === 'textarea'" class="field min-h-24" :value="modelValue[field.internal_name] || ''" @input="update(field.internal_name, $event.target.value)" />
      <select v-else class="field" :value="modelValue[field.internal_name] || ''" @change="update(field.internal_name, $event.target.value)">
        <option value="">Selecciona</option>
        <option v-for="option in field.options_json || []" :key="option" :value="option">{{ option }}</option>
      </select>
      <p class="mt-1 text-xs text-slate-500">{{ field.help_text }}</p>
    </div>
  </div>
</template>
