<script setup>
const props = defineProps({
  fields: {
    type: Array,
    default: () => [],
  },
  modelValue: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['update:modelValue']);

const update = (name, value) => emit('update:modelValue', { ...props.modelValue, [name]: value });
</script>

<template>
  <div class="panel-surface mt-6 p-5 sm:p-6">
    <div class="mb-5">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-700">Campos personalizados</p>
      <h2 class="mt-2 text-lg font-semibold text-slate-950">Atributos adicionales</h2>
      <p class="mt-1 text-sm text-slate-500">Completa los datos dinámicos configurados para este módulo.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div v-for="field in fields" :key="field.id">
      <label class="field-label">
        {{ field.label }}
        <span v-if="field.required" class="text-rose-500">*</span>
      </label>

      <input
        v-if="['text', 'date', 'integer', 'decimal'].includes(field.field_type)"
        :type="field.field_type === 'date' ? 'date' : field.field_type === 'decimal' || field.field_type === 'integer' ? 'number' : 'text'"
        class="field"
        :step="field.field_type === 'decimal' ? '0.01' : field.field_type === 'integer' ? '1' : null"
        :value="modelValue[field.internal_name] || ''"
        @input="update(field.internal_name, $event.target.value)"
      >

      <textarea
        v-else-if="field.field_type === 'textarea'"
        class="field min-h-28"
        :value="modelValue[field.internal_name] || ''"
        @input="update(field.internal_name, $event.target.value)"
      />

      <label v-else-if="field.field_type === 'boolean'" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3">
        <input
          type="checkbox"
          class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
          :checked="Boolean(modelValue[field.internal_name])"
          @change="update(field.internal_name, $event.target.checked)"
        >
        <span class="text-sm text-slate-700">Activar este campo</span>
      </label>

      <select v-else class="field" :value="modelValue[field.internal_name] || ''" @change="update(field.internal_name, $event.target.value)">
        <option value="">Selecciona</option>
        <option v-for="option in field.options_json || []" :key="option" :value="option">{{ option }}</option>
      </select>

      <p v-if="field.help_text" class="field-help">{{ field.help_text }}</p>
    </div>
    </div>
  </div>
</template>
