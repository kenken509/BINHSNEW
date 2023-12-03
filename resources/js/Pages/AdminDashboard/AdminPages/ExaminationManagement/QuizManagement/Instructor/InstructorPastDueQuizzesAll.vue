<template>
    <DashboardLayout :user="user" >
       
       <div class="flex justify-between py-4 border-bot-only border-gray-600 shadow-md mb-4">
           <span class="text-[20px] font-bold text-gray-500">All Past Due Quizzes Page</span>  

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
                       <th scope="col" class="px-6 py-3">
                           ID#
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Title
                       </th>
                       <th scope="col" class="px-6 py-3">
                           Grading Period
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
               
               <tbody v-for="quiz in currentPageItems" :key="quiz.id" >
                   
                   <tr class="bg-white border-b ">
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                       {{ quiz.id }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                       {{ quiz.quiz.title }}
                       </td>
                       <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                       {{ quiz.quiz.grading_period }}
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
import {usePage, Link} from '@inertiajs/vue3'
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
import {ref, computed, onMounted, watch} from 'vue'

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

onMounted(()=>{
    filteredData.value = quizzes.quizzes
    pageNumbers.length = totalPages.value
})

// search logic
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

</script>