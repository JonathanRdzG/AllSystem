<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Sales" :rows="rows" route-base="sales" :columns="['company_id', 'branch_id', 'customer_id', 'quote_id', 'user_id', 'status', 'sale_date', 'total']" /></AdminLayout></template>
