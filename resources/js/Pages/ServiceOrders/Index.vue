<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="ServiceOrders" :rows="rows" route-base="service-orders" :columns="['company_id', 'branch_id', 'customer_id', 'assigned_user_id']" /></AdminLayout></template>
