<template>
    <DashboardLayout :user="user" >
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
           <span class="text-[20px] font-bold text-gray-500">Quizzes Results Page</span>  
       </div>
       
       <div class=" overflow-x-auto shadow-md sm:rounded-lg">
           <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              
               <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                   <tr>
                       <th scope="col" class="px-6 py-3">
                           Student Full Name
                       </th>
                       <th scope="col" class="px-6 py-3">
                            Section
                       </th>
                       <th scope="col" class="px-6 py-3">
                            Quiz Title
                       </th>
                       <th scope="col" class="px-6 py-3">
                            Score
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Grade
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Status
                       </th>
                   </tr>
               </thead>
               
               <tbody v-for="student in results.studentResults" :key="student.id" >
                   
                   <tr class="bg-white border-b ">
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ student.student.lName }}, {{ student.student.fName }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ student.student.section.name }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                          {{ student.quiz.title }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                          {{ student.quiz_score }} / {{ student.quiz.question.length }}
                       </td>
               
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                        
                        <span v-if="student.quiz_grade < 70" class="text-red-600">
                            {{ student.quiz_grade }} % 
                        </span>
                        <span v-else >
                            {{ student.quiz_grade }} % 
                        </span>
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                        <span v-if="student.status === 'lapse'" class="text-red-600">
                            {{ student.status }}
                        </span>
                        <span v-else >
                            {{ student.status }}  
                        </span>
                       </td>
                   </tr>
               </tbody>
           </table>
           
            <!--ACTIVATE QUIZ MODAL-->
            <!-- <Dialog v-model:visible="updateQuizModal" modal header="Send Quiz"  :style="{ width: '60vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
                <hr class="bg-gray-400 h-[2px] mb-2">
                
                <form @submit.prevent="submit">
                    <div class="mb-4 mt-4 text-[18px] font-bold text-gray-600">Section : </div>
                    <div class="mb-4">
                        <Dropdown  v-model="selectedQuizSection" :options="availableSection" optionLabel="name"  placeholder="Select section" class="w-full md:w-14rem " />
                        <InputError :error="form.errors.section_id"/>
                    </div>

                    <div class="mb-4 text-[18px] font-bold text-gray-600">Start Date: </div>
                    <div class="mb-4">
                        <span class="p-float-label">
                            <Calendar v-model="form.startDate" id="startDate" class="w-full"  />
                            <label for="startDate">Start date</label>                       
                        </span>
                        <InputError :error="form.errors.startDate"/>                    
                    </div>
                
                    <div class="mb-4 text-[18px] font-bold text-gray-600">Due Date: </div>
                    <div class="mb-4">
                        <span class="p-float-label">
                            <Calendar v-model="form.endDate" id="startDate" class="w-full"  />
                            <label for="startDate">Due date</label>                       
                        </span>
                        <InputError :error="form.errors.endDate"/>                    
                    </div>

                    <div class="w-full mt-6 ">
                        <Button label="Submit" class="w-full" type="submit"/>
                    </div>
                </form>
                

            </Dialog> -->
            <!--ACTIVATE QUIZ MODAL-->
       </div>
    </DashboardLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';

const user = usePage().props.user
const results = defineProps({
    studentResults:Array,
})
</script>