<template>
    
    <StudentDashboardLayout >
        <div class="col-span-6 md:col-span-5 border-b-2 border-b-gray-600 mb-4">
            <span class="text-[20px] font-bold text-gray-500 ">Active Quizzes Page</span>
        </div>

        <div class=" overflow-x-auto shadow-md rounded-lg bg-red-300  ">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr class="">
                        <th scope="col" class="px-6 py-3 ">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 ">
                            Start Date
                        </th>
                        <th  scope="col" class="px-6 py-3 ">
                            End Date
                        </th>
                        <th  scope="col" class="px-6 py-3 ">
                            Items
                        </th>
                        <th  scope="col" class="px-6 py-3 ">
                            Duration
                        </th>
                        <th  scope="col" class="px-6 py-3  ">
                            Take Quiz
                        </th>
                    </tr>
                </thead>
                <tbody >
                    <tr v-for="quiz in quiz.quizzes" :key="quiz.id" class="bg-white border-b ">
                        
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.quiz.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.start_date }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.end_date }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.quiz.question.length }}
                        </td>     
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                           {{ quiz.quiz.duration }} mins 
                        </td> 
                             
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            <div  class=" space-x-4 px-2">
                                <Link :href="route('quiz.begin',{id:quiz.quiz.id})" class="cursor-pointer" v-tooltip.left="'Take Quiz'"   ><span class="pi pi-check text-green-700 scale-110 hover:dark:scale-150 mx-2"></span></Link>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <!--Modal-->
            <!-- <div class="card flex justify-content-center userInfo">
                <Dialog v-model:visible="visible" modal   :userId="userId" :style="{ width: '90vw' } ">
                    <div class=" overflow-x-auto shadow-md rounded-lg ">  
                        <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                            <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                                <tr  >
                                    <th scope="col" class="px-6 py-3 text-center">
                                        ID#
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Email
                                    </th>
                                    <th v-if="sections.sections" scope="col" class="px-6 py-3 text-center">
                                        Gender
                                    </th>
                                    
                                </tr>
                            </thead>

                            <tbody v-for="students in sections.studentUser">
                                <tr v-if="(students.section_id === selectedSection) && students.role === 'student' " class="bg-white border-b ">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                        {{ students.id }}
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                        {{ students.fName }}, {{ students.lName }}
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                        {{ students.email }} 
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                        {{ students.gender }} 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <template #footer>
                        <Button label="Close" icon="pi pi-times" @click="visible = false" text />
                        <Button label="Print" icon="pi pi-check" @click="printPage" autofocus />
                    </template>
                </Dialog>
            </div> -->
            {{ quizzesId }} filtered {{ filteredQuizzes }}
        </div>
        
        <div class="border-t-4 border-black mt-2">
            {{ quiz.studentFinishedQuizzes }} aries {{ quiz.quizzes }} 
        </div>
    </StudentDashboardLayout>
      
    
    
       
      
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import StudentDashboardLayout from '../TestPages/StudentDashboard/StudentDashboardLayout.vue'
import { Link } from '@inertiajs/vue3'
import {ref, onMounted, computed} from 'vue'

const appUrl = '/storage/'
const defaultImage = 'Images/default.png';

const user = usePage().props.user
const quiz = defineProps({
    quizzes:Array,
    currentUser:Object,
    studentFinishedQuizzes:Array,
})

const quizzesId = quiz.studentFinishedQuizzes.map((item)=> item.quiz_id);
const filteredQuizzes = quiz.quizzes.filter(item => quizzesId.includes(item.quiz_id));

onMounted(()=>{
    studentActiveQuizzes
    console.log(studQuiz.value)
})
</script>