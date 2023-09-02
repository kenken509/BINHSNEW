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
                            Items
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
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.question_count }} 
                        </td>
                        <td>
                            <div class=" flex space-x-4 ">
                                <Link :href="route('quiz.delete', {id: quiz.id})" class="cursor-pointer" v-tooltip.left="'Delete Question'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link :href="route('quiz.edit', {id:quiz.id})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'Preview'" @click="openModal(quiz.id)" ></span>
                                <span class="pi pi-send cursor-pointer hover:scale-150" style="color: slateblue" v-tooltip.left="'Send Quiz'" @click="showQuizModal(quiz.id)"></span>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <!--MODAL-->
            <Dialog v-model:visible="visible" modal header="Question Info"  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                <div v-for="quiz in quizzes.quizzes" :key="quiz.id">
                    <div v-if="quiz.id === quizId"> 
                    <div><span class="text-xl">Title : {{ quiz.title }}</span></div> 
                    <div><span class="text-xl">Subject : {{ quiz.subject.name }}</span></div> 
                    <div><span class="text-xl">Grading Period : {{ quiz.grading_period }}</span></div> 
                    <div><span class="text-xl">Duration : {{ quiz.duration }} mins</span></div> 
                    <div><span class="text-xl">Items : {{ quiz.question_count }} </span></div> 
                    <hr>
                    <div v-for="(question,index) in quiz.question" :key="question.id" class="my-2">
                        <div>Question # {{ index+1 }} : <span >{{ question.question }}</span> </div>
                        <div>Correct Answer : <span class="text-green-500">{{ question.correct_answer }}</span> </div> 
                        <div class="ml-10">
                            <div>Option a : {{ question.choices.option_a }}</div> 
                            <div>Option b : {{ question.choices.option_b }}</div> 
                            <div>Option c : {{ question.choices.option_c }}</div> 
                            <div>Option d : {{ question.choices.option_d }}</div>
                        </div>
                        <hr>
                    </div>
                    </div>
                </div>
                
                
                
            </Dialog>
            <!--MODAL---->

            <!--ACTIVATE QUIZ MODAL-->
            <Dialog v-model:visible="activateQuizModal" modal header="Send Quiz"  :style="{ width: '60vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
                <hr class="bg-gray-400 h-[2px] mb-2">
                <div>TO DO:</div>
                <div>1. If the currently logged-in user is an admin, allow them to choose the section to which the quiz will be given.</div>
                <div>2. PROVIDE A DATE INPUT THAT WILL LET THE USER CHOOSE THE START AND END DATE</div>
                <div>3. PROVIDE A BUTTON THAT WILL ACTIVATE THE QUIZ</div>
                
                <form @submit.prevent="submit">
                    <div class="mb-4">Grading Period: </div>
                    <div class="mb-4">
                        <Dropdown  v-model="selectedQuizSection" :options="instructorHandledSection" optionLabel="name"  placeholder="Select section" class="w-full md:w-14rem " />
                        <InputError :error="form.errors.section_id"/>
                    </div>

                    <div class="mb-4">Start Date: </div>
                    <div class="mb-4">
                        <span class="p-float-label">
                            <Calendar v-model="form.startDate" id="startDate" class="w-full"  />
                            <label for="startDate">Start date</label>                       
                        </span>
                        <InputError :error="form.errors.startDate"/>                    
                    </div>
                
                    <div class="mb-4">Due Date: </div>
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
                

            </Dialog>
            <!--ACTIVATE QUIZ MODAL-->
        </div>
        


        
    </DashboardLayout>
 </template>
 
 <script setup>
 
 import { usePage, Link, useForm } from '@inertiajs/vue3';
 import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
 import { onMounted, ref, watch } from 'vue';
 import InputError from '../../../../../GlobalComponent/InputError.vue'

 
 const user = usePage().props.user;
 
 const quizzes = defineProps({
    quizzes: Array,
    sections:Array
 })

 


 const quizId = ref(null);
 const visible = ref(false);
 const questionId = ref(null);
 const openModal = (id)=> {
    visible.value = true
    quizId.value = id;
}


const activateQuizModal = ref(false);
const selectedQuizSection = ref(null)
const instructorHandledSection = ref([]);

function sortSection(instructorSec)
{
    instructorSec.forEach((sec)=>{
        if(sec.instructor_id === user.id)
        {
            instructorHandledSection.value.push(sec);
        }
        else
        {
            
        }
    })
    
}


function showQuizModal(quizId)
{
    form.quiz_id = quizId;
    
    // form.section = selectedQuizSection.value.id
    activateQuizModal.value = !activateQuizModal.value

}

const form = useForm({
    quiz_id : null,
    startDate: null,
    endDate: null,
    subject_id:user.subject_id,
    section_id:null,
})

onMounted(()=>{
    sortSection(quizzes.sections);
})

const submit = ()=> form.post(route('quiz.send'));

watch(selectedQuizSection, (val)=>{
    form.section_id = val.id;
})
 </script>