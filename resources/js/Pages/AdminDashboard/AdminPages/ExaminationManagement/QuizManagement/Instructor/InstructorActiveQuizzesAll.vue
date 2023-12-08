<template>
    <DashboardLayout :user="user" >
       
       <div class="flex justify-between items-center border-bot-only border-gray-600 shadow-md mb-4 py-4">
           <span class="text-[20px] font-bold text-gray-500">Active Quizzes </span>  

           <div class="">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " @input="handleSearchFieldInput" />
                </span>
            </div>
       </div>
       <span class="text-red-500">TO DO: IMPLEMENT VIEW QUIZ</span>
       <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success)   }} </div>
       <div class=" overflow-x-auto shadow-md sm:rounded-lg">
           <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              
               <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                   <tr>
                       <th scope="col" class=" text-center px-6 py-3">
                           ID#
                       </th>
                       <th scope="col" class="text-center px-6 py-3">
                           Title
                       </th>
                       <th scope="col" class=" text-center px-6 py-3">
                           Section
                       </th>
                       <th scope="col" class=" text-center px-6 py-3">
                           Start Date
                       </th>
                       <th scope="col" class=" text-center px-6 py-3">
                           End Date
                       </th>
                       <th scope="col" class=" text-center px-6 py-3">
                           Info
                       </th>
                   </tr>
               </thead>
               
               <tbody v-for="quiz in currentPageItems" :key="quiz.id" >
                   
                   <tr v-for="instructorSection in user.handled_sections " class="text-center bg-white border-b ">
                       <td  v-if="instructorSection.id === quiz.section_id" scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.id }} 
                       </td>
                       <td  v-if="instructorSection.id === quiz.section_id" scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.quiz.title }}
                       </td>
                       <td  v-if="instructorSection.id === quiz.section_id" scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.section.name }}
                       </td>
               
                       <td  v-if="instructorSection.id === quiz.section_id" scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                           {{ formatDate(quiz.start_date) }} 
                       </td>
                       <td  v-if="instructorSection.id === quiz.section_id" scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                           {{ formatDate(quiz.end_date) }}
                       </td>
                       <td class=" text-center ">
                            <span class="pi pi-eye text-green-600 scale-150 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Grade Info'" @click="handleshowQuizInfo()"></span>
                        </td>
                       
                       <!-- <td  v-if="instructorSection.id === quiz.section_id">
                           <div class="flex px-6  space-x-6 ">
                                <span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Delete Active Quiz'" @click="confirmDelete(quiz.id)"></span> -->
                               <!-- <Link :href="route('sentQuiz.delete', {id: quiz.id})" class="cursor-pointer" v-tooltip.left="'Delete Active Quiz'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                           <!-- </div>    
                       </td> -->
                   </tr>
                   <Dialog v-model:visible="showQuizInfo" modal :test="selectedStudentGradeId"   :style="{ width: '90vw' } ">
                        
                        <div>
                            <span class=" font-extrabold text-[24px] text-gray-500">Quiz Information</span>
                            <div class="w-full">
                                <hr class="border-t-2 border-gray-500">
                            </div>
                        </div>
                        <div class="pl-2">
                            
                            <div class="flex items-center w-full mt-4">
                                <span class="text-[23px]">Title: <span class="underline underline-offset-[4px]">{{ quiz.quiz.title }}</span></span>
                            </div>
                            <div class="w-full ">
                                <span class="text-[23px]">Section: <span class="underline underline-offset-[4px]">{{ quiz.section.name }}</span></span>
                            </div>
                            <div class="w-full ">
                                <span class="text-[23px]">Grading Period: <span class="underline underline-offset-[4px]">{{ quiz.quiz.grading_period }}</span></span>
                                <hr class="border-t-2 border-gray-300 mt-2">
                            </div>
                            <div class="border border-2 rounded-md shadow-md mt-2 p-2">
                                <div class="w-full ">
                                    <span class="text-[23px]">Questions:</span>
                                </div>
                                <div v-for="(questions, index) in quiz.quiz.question" :key="quiz.id" class="w-full  ">
                                    <div>
                                        <div>
                                            <span class="text-[23px]">{{ index+1 }}. {{questions.question}}</span>
                                        
                                        </div>
                                        <div class="ml-11 mt-2"> 
                                            <span class="text-green-500 underline underline-offset-[4px]">
                                                Correct Answer: 
                                                <span >{{ questions.correct_answer }} <i class="pi pi-check" style="font-size: 1rem"></i></span>
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <div class=" ml-11">A. {{ questions.choices.option_a }}</div>
                                            <div class="ml-11">B. {{ questions.choices.option_b }}</div>
                                            <div class="ml-11">C. {{ questions.choices.option_c }}</div>
                                            <div class="ml-11">D. {{ questions.choices.option_d }}</div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <template #footer>
                            <Button label="Close" icon="pi pi-times" style="background-color: #4F46E5; color: whitesmoke;" @click="handleshowQuizInfo" text />
                            
                        </template>
                   </Dialog>
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
import {usePage, Link, router} from '@inertiajs/vue3'
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
import {ref, computed, onMounted, watch} from 'vue'
import Swal from 'sweetalert2'

const user = usePage().props.user;

const quizzes = defineProps({
   quizzes:Array,
})

onMounted(()=>{
    filteredData.value = quizzes.quizzes
    pageNumbers.value = totalPages.value
})

const updateQuizModal = ref(false);
function showUpdateQuizModal(quizId)
{
   
    form.quiz_id = quizId;
    
    // form.section = selectedQuizSection.value.id
    activateQuizModal.value = !activateQuizModal.value

    selectedSentQuiz.value = quizzes.sentQuiz.filter((quiz)=> quiz.quiz_id === quizId);

    availableSection.value = instructorHandledSection.value.filter((section) =>{
        return selectedSentQuiz.value.every((quiz)=> quiz.section_id !== section.id )
    })

}

function formatDate(inputDate) {
 const [year, month, day] = inputDate.split("-");
 const formattedDate = new Date(year, month - 1, day).toLocaleDateString("en-US", {
   month: "long",
   day: "numeric",
   year: "numeric",
 });
 return formattedDate;
}

function confirmDelete(quizId){
    Swal.fire({
        title:"Delete Active Quiz?",
        text:"You won't be able to revert this!",
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        allowOutsideClick: false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            router.delete(route('sentQuiz.delete', {id:quizId}))
        }

        else if (result.isDismissed) 
        {
            Swal.fire(
            'Cancelled',
            'Active quiz file is safe!',
            'error'
            )
        }
    })
}
function successMessage(message){
    Swal.fire({
        title: 'Success',
        text: message,
        icon: 'success',
        allowOutsideClick: false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            location.reload()
        }
    })
}

const filteredData = ref([])
const searchField  = ref(null)

function handleSearchFieldInput(){
    if(!searchField.value)
    {
        filteredData.value = quizzes.quizzes
    }
    else
    {
        filteredData.value = quizzes.quizzes.filter( quiz =>
            Object.values(quiz).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(quiz.quiz).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(quiz.section).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase()))
        )  
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

// quiz info modal logic

const showQuizInfo = ref(false);

const handleshowQuizInfo = () =>{
    showQuizInfo.value = !showQuizInfo.value
}
</script>