<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import CrudIndex from '../../Components/CrudIndex.vue';
defineProps({ rows: Object });
</script>
<template><AdminLayout><CrudIndex title="Users" :rows="rows" route-base="users" :columns="['company_id', 'branch_id', 'name', 'email', 'password']" /></AdminLayout></template>
