<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Products" :rows="rows" route-base="products" :columns="['company_id', 'category_id', 'unit_id', 'sku', 'name', 'cost', 'price']" /></AdminLayout></template>
