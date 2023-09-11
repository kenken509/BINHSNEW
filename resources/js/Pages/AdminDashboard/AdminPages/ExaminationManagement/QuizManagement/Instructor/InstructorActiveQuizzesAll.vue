<template>
    <DashboardLayout :user="user" >
       
       <div class="border-bot-only border-gray-600 shadow-md mb-4">
           <span class="text-[20px] font-bold text-gray-500">All Active Quizzes Page</span>  
       </div>
       <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success)   }} </div>
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
                       
                       <th scope="col" class="  px-6 py-3">
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
                       
                       <td>
                           <div class="flex px-6  space-x-6 ">
                                <span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Delete Active Quiz'" @click="confirmDelete(quiz.id)"></span>
                               <!-- <Link :href="route('sentQuiz.delete', {id: quiz.id})" class="cursor-pointer" v-tooltip.left="'Delete Active Quiz'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                           </div>    
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
import {usePage, Link, router} from '@inertiajs/vue3'
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
import {ref} from 'vue'
import Swal from 'sweetalert2'

const user = usePage().props.user;

const quizzes = defineProps({
   quizzes:Array,
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
</script>