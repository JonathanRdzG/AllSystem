<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Quotes" :rows="rows" route-base="quotes" :columns="['company_id', 'branch_id', 'customer_id', 'user_id', 'status', 'valid_until', 'total']" /></AdminLayout></template>
