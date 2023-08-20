<template>
<DashboardLayout :user="user">
    <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Post Page</span>  
        </div>
        <form @submit.prevent="submit" enctype="multipart/form-data">
        
            
        </form>

</DashboardLayout>

</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.user;

</script>