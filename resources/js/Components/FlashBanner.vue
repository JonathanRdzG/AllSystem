<script setup>
defineProps({
  success: {
    type: String,
    default: '',
  },
  error: {
    type: String,
    default: '',
  },
});
</script>

<template>
  <div v-if="success || error" class="panel-surface overflow-hidden">
    <div
      class="flex items-start gap-3 p-4 text-sm"
      :class="success ? 'border-l-4 border-emerald-500 bg-emerald-50/70 text-emerald-800' : 'border-l-4 border-rose-500 bg-rose-50/70 text-rose-800'"
    >
      <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          :d="success ? 'M5 13l4 4L19 7' : 'M12 9v4m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z'"
        />
      </svg>
      <p>{{ success || error }}</p>
    </div>
  </div>
</template>
