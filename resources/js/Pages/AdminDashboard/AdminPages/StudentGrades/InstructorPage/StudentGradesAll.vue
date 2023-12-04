<template>
    <DashboardLayout :user="user">
        <div class="flex items-center sm:flex-col md:flex-row  lg:justify-between border-bot-only py-2 border-gray-600  mb-4">
            <span class="text-[20px] font-bold text-gray-500">Student Grades</span>  
            <div class="">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " @input="handleSearchFieldInput" />
                </span>
            </div>
        </div>
         
        <div class=" overflow-x-auto shadow-md rounded-lg " >
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" >
                <thead class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <tr class="  text-xs text-gray-300 uppercase bg-green-800 ">
                        <th colspan="3" class="text-center text-[14px] font-bold py-2">
                            Student info
                        </th>
                        <th colspan="4" class="text-center text-[14px] font-bold border-x-[1px] py-2 border-gray-500">
                            Student 
                        </th>
                        <th colspan="3" class="text-center text-[14px] font-bold py-2">
                            Assessment 
                        </th>
                    </tr>
                    <tr class="text-xs text-gray-200 uppercase bg-green-700  ">
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>ID</span>
                        </th>
                        <tH scope="col" class="px-6 py-3 text-center">
                            <span>NAME</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>SECTION</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center border-l-[1px] border-gray-500 ">
                            <span>FIRST</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>SECOND</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>THIRD</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center border-r-[1px] border-gray-500">
                            <span>FOURTH</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>FINAL</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>STATUS</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <span>Action</span>
                        </th>

                    </tr>
                </thead>
                <tbody v-for="grade in currentPageItems" :key="grade.id">
                    <tr  class="bg-white border-b ">
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center ">
                            {{ grade.student.student_number }}
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center ">
                            {{ grade.student.lName }}, {{ grade.student.fName }} 
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center  ">
                            {{ grade.student.section.name }}
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center border-l-[1px] border-gray-500 ">
                            {{ grade.first_grading }}
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center ">
                            {{ grade.second_grading }}
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center ">
                            {{ grade.third_grading }}
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center border-r-[1px] border-gray-500">
                            {{ grade.fourth_grading }}
                        </td>
                        <td  scope="row" class=" py-4 font-medium text-gray-900 text-center ">
                            <span class="text-red-500" v-if="grade.fourth_grading < 1">
                                pending 
                            </span>
                            <span v-else>
                                {{ grade.final_grade }}
                            </span>
                        </td>
                        <td scope="row" class=" py-4 font-medium text-gray-900 text-center ">
                            <span class="text-red-500" v-if="grade.fourth_grading < 1">
                                pending 
                            </span>
                            <span v-else>
                                dev data
                            </span>
                        </td>
                        <td class=" text-center ">
                            <span class="pi pi-eye text-green-600 scale-150 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Grade Info'" @click="showStudentsModal(section.id)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!--Grade info modal-->
            <!-- <div class="card flex justify-content-center userInfo">
                <Dialog v-model:visible="visible" modal    :style="{ width: '90vw' } ">
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
            <!--Grade info modal-->
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
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { usePage } from '@inertiajs/vue3';
import {ref,onMounted,computed,watch} from 'vue'


const user = usePage().props.user;


const studentData = defineProps({
    studentGrades:Array,
})

onMounted(()=>{
    filteredData.value = studentData.studentGrades
    pageNumbers.length = totalPages.value;
})


// search field logic
const searchField = ref(null);
const filteredData = ref([])




function handleSearchFieldInput(){

    if (!studentData.studentGrades || studentData.studentGrades === 0) {
        // Handle the case where sections.sections is undefined or an empty array
        console.error('No sections available');
        return;
    }

    if(!searchField.value)
    {
        filteredData.value = studentData.studentGrades
        console.log('null')
    }
    else
    {
        
        filteredData.value = studentData.studentGrades.filter(grades =>
            Object.values(grades).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(grades.student).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(grades.student.section).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase()))
            
            
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


</script>