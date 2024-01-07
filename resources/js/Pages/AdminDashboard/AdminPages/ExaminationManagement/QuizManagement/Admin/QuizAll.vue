<template>
    <DashboardLayout :user="user" >
        <div class="flex justify-between items-center border-bot-only border-gray-600 shadow-md mb-4 pb-4">
            <span class="text-[20px] font-bold text-gray-500"> QUIZZES</span>  
            <div class="">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " @input="handleSearchFieldInput" />
                </span>
            </div>
            
        </div>
       
        <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr>
                        <th scope="col" class="text-center px-6 py-3">
                            ID#
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Subject
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Grading Period
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Duration
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Items
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="quiz in currentPageItems" :key="quiz.id" >
                    <tr class="bg-white border-b ">
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                        {{ quiz.id }}
                        </td>
                        <td scope="row" class=" text-center px-6 py-4 font-medium text-gray-900  ">
                        {{ quiz.title }}
                        </td>
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.subject.name}}
                        </td>
                
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.grading_period }}
                        </td>
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.duration }} mins
                        </td>
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.question_count }} 
                        </td>
                        <td scope="row" class=" text-center px-6 py-4 font-medium text-gray-900 ">
                            <div class=" space-x-6 text-center   items-center">
                                <!-- <Link :href="route('quiz.delete', {id: quiz.id})" class="cursor-pointer" v-tooltip.left="'Delete Quiz'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                                <!-- <Link :href="route('quiz.edit', {id:quiz.id})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link> -->
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'Preview'" @click="openModal(quiz.id)" ></span>
                                <!-- <span class="pi pi-send cursor-pointer hover:scale-150" style="color: slateblue" v-tooltip.right="'Activate'" @click="showQuizModal(quiz.id)"></span> -->
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
            <Dialog v-model:visible="activateQuizModal" modal header="Activate Quiz"  :style="{ width: '60vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                <hr class="bg-gray-400 h-[2px] mb-2">
                <div>TO DO:</div>
                <div>1. If the currently logged-in user is an admin, allow them to choose the section to which the quiz will be given.</div>
                <div>2. PROVIDE A DATE INPUT THAT WILL LET THE USER CHOOSE THE START AND END DATE</div>
                <div>3. PROVIDE A BUTTON THAT WILL ACTIVATE THE QUIZ</div>
                
               
                
            </Dialog>
            <!--ACTIVATE QUIZ MODAL-->
        </div>

        <div class="flex justify-center w-full space-x-4 mt-4" v-if="totalPages > 1">
            <div @click="prevPage"  class="flex items-center  cursor-pointer hover:text-red-400">
                <i class="pi pi-angle-double-left cursor-pointer" style="font-size: 24px;"></i>
                
            </div>
            <div class="flex space-x-2" >
                <div v-for="(number, index) in totalPages" class="hover:text-green-500 cursor-pointer" @click="changePageClick(index+1)" >
                    <div v-if="currentPage === index+1" class="border bg-green-700 px-2 rounded-lg text-gray-200" >{{ index+1 }}</div>
                    <div v-else class="px-2">{{ index+1 }}</div>
                </div>
            </div>
            <div @click="nextPage"  class="flex items-center  cursor-pointer hover:text-green-400">
                <i class="pi pi-angle-double-right  " style="font-size: 24px;"></i>
            </div>
        </div>
    
    </DashboardLayout>
 </template>
 
 <script setup>
 
 import { usePage, Link } from '@inertiajs/vue3';
 import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
 import { ref, onMounted, computed, watch } from 'vue';
 
 const user = usePage().props.user;
 
 const quizzes = defineProps({
    quizzes: Array,
 })

 const quizId = ref(null);
 const visible = ref(false);
 const questionId = ref(null);
 const openModal = (id)=> {
    visible.value = true
    quizId.value = id;
}

const activateQuizModal = ref(false);
const activateQuizId = ref(null);
const showQuizModal = (id) => {
    activateQuizId.value = id;
    activateQuizModal.value = !activateQuizModal.value;
}
onMounted(()=>{
    filteredData.value = quizzes.quizzes
    pageNumbers.length = totalPages.value
})
// search logic
const searchField = ref(null);
const filteredData = ref([])

function handleSearchFieldInput(){
    if(!searchField.value)
    {
        filteredData.value = quizzes.quizzes
        console.log('null')
    }
    else
    {
        
        filteredData.value = quizzes.quizzes.filter(quiz =>
            Object.values(quiz).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(quiz.subject).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase()))
        );        
    } 
}

// pagination logic
const itemsPerPage = ref(10);
const currentPage = ref(1);


const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage.value));
const pageNumbers = ref([]);
watch(currentPage,(val)=>{
    console.log(val);
})
const currentPageItems = computed(() => {
    
  const start = (currentPage.value - 1) * itemsPerPage.value; 
  const end = start + itemsPerPage.value;
  
  return filteredData.value.slice(start, end);
}); 

const nextPage = () => {
    
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const changePageClick = (index)=>
{
    currentPage.value = index;
}

// print logic

 </script>