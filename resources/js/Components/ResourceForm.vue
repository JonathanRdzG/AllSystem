<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    default: '',
  },
  form: {
    type: Object,
    required: true,
  },
  fields: {
    type: Array,
    default: () => [],
  },
  submitLabel: {
    type: String,
    default: 'Guardar',
  },
  processingLabel: {
    type: String,
    default: 'Guardando...',
  },
  cancelHref: {
    type: String,
    default: '',
  },
});

defineEmits(['submit']);

const fieldId = (name) => `field-${name.replace(/[^a-z0-9]+/gi, '-')}`;

const optionValue = (option) => {
  if (typeof option === 'object' && option !== null) {
    return option.value ?? option.id ?? '';
  }

  return option;
};

const optionLabel = (option) => {
  if (typeof option === 'object' && option !== null) {
    return option.label ?? option.name ?? option.title ?? option.value ?? option.id;
  }

  return option;
};

const submitText = computed(() => (props.form.processing ? props.processingLabel : props.submitLabel));
</script>

<template>
  <div class="space-y-5">
    <section class="panel-surface shell-gradient p-6 sm:p-8">
      <p class="mb-3 text-xs font-semibold uppercase tracking-[0.3em] text-teal-700">Edición operativa</p>
      <h1 class="section-heading">{{ title }}</h1>
      <p v-if="description" class="section-description mt-3 max-w-3xl">{{ description }}</p>
    </section>

    <form class="form-shell" @submit.prevent="$emit('submit')">
      <div class="form-grid">
        <template v-for="field in fields" :key="field.name">
          <div :class="field.fullWidth ? 'md:col-span-2' : ''">
            <div v-if="field.type === 'checkbox'" class="rounded-3xl border border-slate-200/80 bg-white/80 p-4">
              <label class="flex items-start gap-3">
                <input
                  :id="fieldId(field.name)"
                  v-model="form[field.name]"
                  type="checkbox"
                  class="mt-1 h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                >
                <span>
                  <span class="block text-sm font-semibold text-slate-900">{{ field.label }}</span>
                  <span v-if="field.help" class="field-help mt-1 block">{{ field.help }}</span>
                </span>
              </label>
            </div>

            <template v-else>
              <label class="field-label" :for="fieldId(field.name)">
                {{ field.label }}
                <span v-if="field.required" class="text-rose-500">*</span>
              </label>

              <textarea
                v-if="field.type === 'textarea'"
                :id="fieldId(field.name)"
                v-model="form[field.name]"
                class="field min-h-32"
                :placeholder="field.placeholder"
                :rows="field.rows ?? 4"
              />

              <select
                v-else-if="field.type === 'select'"
                :id="fieldId(field.name)"
                v-model="form[field.name]"
                class="field"
              >
                <option value="">{{ field.placeholder ?? 'Selecciona una opción' }}</option>
                <option v-for="option in field.options ?? []" :key="`${field.name}-${optionValue(option)}`" :value="optionValue(option)">
                  {{ optionLabel(option) }}
                </option>
              </select>

              <input
                v-else
                :id="fieldId(field.name)"
                v-model="form[field.name]"
                class="field"
                :type="field.type ?? 'text'"
                :placeholder="field.placeholder"
                :step="field.step"
                :min="field.min"
                :max="field.max"
                :autocomplete="field.autocomplete"
              >

              <p v-if="field.help" class="field-help">{{ field.help }}</p>
            </template>

            <p v-if="form.errors[field.name]" class="field-error">{{ form.errors[field.name] }}</p>
          </div>
        </template>
      </div>

      <slot name="after-fields" />

      <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200/80 pt-6 sm:flex-row sm:items-center sm:justify-end">
        <Link v-if="cancelHref" :href="cancelHref" class="btn-secondary w-full sm:w-auto">Cancelar</Link>
        <button type="submit" class="btn-primary w-full sm:w-auto" :disabled="form.processing">
          {{ submitText }}
        </button>
      </div>
    </form>
  </div>
</template>
