<template>
 
    <StudentDashboardLayout >
    
        <div class="col-span-6 md:col-span-5 border-b-2 border-b-gray-600">
            <span class="text-[20px] font-bold text-gray-500">Quizzes Results Page</span>
        </div>
        
        <div class=" overflow-x-auto shadow-md rounded-lg bg-red-300  mt-4">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr class="">
                        <th scope="col" class="px-6 py-3 ">
                            Grading Period
                        </th>
                        <th scope="col" class="px-6 py-3 ">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 ">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-3 ">
                            Score
                        </th>
                        <th  scope="col" class="px-6 py-3 ">
                           Grade
                        </th>
                        <th  scope="col" class="px-6 py-3 ">
                           Status
                        </th>
                        
                    </tr>
                </thead>
                <tbody >
                    <tr v-for="quiz in quiz.quizResults"  class="bg-white border-b ">
                        
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.grading_period }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.quiz.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.quiz.question.length }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.quiz_score }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                           {{ quiz.quiz_grade }} %
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                           {{ quiz.status }} 
                        </td>
                             
                        <!-- <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                           
                        </td>  -->
                             
                        <!-- <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            <div  class=" space-x-4 px-2">
                                <Link :href="route('quiz.begin',{id:quiz.quiz.id})" class="cursor-pointer" v-tooltip.left="'Take Quiz'"   ><span class="pi pi-check text-green-700 scale-110 hover:dark:scale-150 mx-2"></span></Link>
                            </div>    
                        </td> -->
                    </tr>
                    
                </tbody>
            </table>
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
        quizResults:Array,
    })
    
    </script>