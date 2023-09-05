<template>
 
<StudentDashboardLayout >

    <div class="col-span-6 md:col-span-5 border-b-2 border-b-gray-600">
        <span class="text-[20px] font-bold text-gray-500">Quizzes Page</span>
    </div>

</StudentDashboardLayout>
    
   
  
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import StudentDashboardLayout from '../TestPages/StudentDashboard/StudentDashboardLayout.vue'
import { Link } from '@inertiajs/vue3'

const appUrl = '/storage/'
const defaultImage = 'Images/default.png';

const user = usePage().props.user
const quiz = defineProps({
    quizzes:Array,
    
})

</script>