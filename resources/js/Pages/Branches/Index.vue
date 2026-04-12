<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Branches" :rows="rows" route-base="branches" :columns="['company_id', 'name', 'code', 'address', 'phone']" /></AdminLayout></template>
