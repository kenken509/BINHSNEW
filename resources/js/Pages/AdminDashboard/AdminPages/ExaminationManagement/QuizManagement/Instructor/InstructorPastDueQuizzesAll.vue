<template>
    <DashboardLayout :user="user" >
       
       <div class="border-bot-only border-gray-600 shadow-md mb-4">
           <span class="text-[20px] font-bold text-gray-500">All Past Due Quizzes Page</span>  
       </div>
       <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>
       <div class=" overflow-x-auto shadow-md sm:rounded-lg">
           <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              
               <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                   <tr>
                       <th scope="col" class="px-6 py-3">
                           ID#
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Title
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Section
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Start Date
                       </th>
                       <th scope="col" class="px-6 py-3">
                           End Date
                       </th>
                       
                      
                       
                   </tr>
               </thead>
               
               <tbody v-for="quiz in quizzes.quizzes" :key="quiz.id" >
                   
                   <tr class="bg-white border-b ">
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                       {{ quiz.id }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                       {{ quiz.quiz.title }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                           {{ quiz.section.name }}
                       </td>
               
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                           {{ formatDate(quiz.start_date) }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                           {{ formatDate(quiz.end_date) }}
                       </td>
                       
                       
                   </tr>
                   
               </tbody>
           </table>
       
       </div>
   </DashboardLayout>
</template>

<script setup>
import {usePage, Link} from '@inertiajs/vue3'
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';

const user = usePage().props.user;

const quizzes = defineProps({
   quizzes:Array,
})

function formatDate(inputDate) {
 const [year, month, day] = inputDate.split("-");
 const formattedDate = new Date(year, month - 1, day).toLocaleDateString("en-US", {
   month: "long",
   day: "numeric",
   year: "numeric",
 });
 
 return formattedDate;
}

</script>