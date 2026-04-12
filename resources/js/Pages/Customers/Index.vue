<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Customers" :rows="rows" route-base="customers" :columns="['company_id', 'branch_id', 'name', 'tax_id']" /></AdminLayout></template>
