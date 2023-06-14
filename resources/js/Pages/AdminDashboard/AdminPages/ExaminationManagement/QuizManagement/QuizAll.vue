<template>
    <DashboardLayout :user="user" >
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">All Questions Page</span>  
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
                            Subject
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Grading Period
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Duration
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="quiz in quizzes.quizzes" :key="quiz.id" >
                    <tr class="bg-white border-b ">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ quiz.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ quiz.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.subject.name}}
                        </td>
                
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.grading_period }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.duration }} mins
                        </td>
                        <td>
                            <div class=" space-x-4">
                                <Link href="#" class="cursor-pointer" v-tooltip.left="'Delete Question'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link href="#" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit User'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'View full info'" @click="openModal(quiz.id)" ></span>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <!--MODAL-->
            <Dialog v-model:visible="visible" modal header="Question Info"  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                <div v-for="quiz in quizzes.quizzes" :key="quiz.id">
                    <div v-if="question.id === questionId"> 
                    <div><span class="text-xl">Title : {{ quiz.title }}</span></div> 
                    <div><span class="text-xl">Subject : {{ quiz.subject.name }}</span></div> 
                    <div><span class="text-xl">Grading Period : {{ quiz.grading_period }}</span></div> 
                    <div><span class="text-xl">Duration : {{ quiz.duration }}</span></div> 
                    <hr>
                    <div>Correct answer : <span class="text-green-500">{{ quiz.question. }}</span> </div> 
                    <div class="ml-10">
                            
                            <div>Option a : {{ question.choices.a }}</div> 
                            <div>Option b : {{ question.choices.b }}</div> 
                            <div>Option c : {{ question.choices.c }}</div> 
                            <div>Option d : {{ question.choices.d}}</div> 
                    </div>
                    
                    </div>
                </div>
                
                
                
            </Dialog>
            <!--MODAL---->
        </div>
        


        
    </DashboardLayout>
 </template>
 
 <script setup>
 
 import { usePage, Link } from '@inertiajs/vue3';
 import DashboardLayout from '../../../Layout/DashboardLayout.vue';
 import { ref } from 'vue';
 
 const user = usePage().props.user;
 
 const quizzes = defineProps({
    quizzes: Array,
 })

 const visible = ref(false);
 const questionId = ref(null);
 const openModal = (id)=> {
    visible.value = true
    questionId.value = id;
}


 </script>