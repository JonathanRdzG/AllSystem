<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Companies" :rows="rows" route-base="companies" :columns="['name', 'legal_name', 'tax_id', 'email', 'phone']" /></AdminLayout></template>
