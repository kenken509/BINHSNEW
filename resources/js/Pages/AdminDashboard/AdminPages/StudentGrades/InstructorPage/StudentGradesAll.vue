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
                        <th scope="col" class="px-6 py-3 text-center">
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
                            <span class="pi pi-eye text-green-600 scale-150 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Grade Info'" @click="handleGradeInfoModal(grade.id)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!--Grade info modal-->
            <div v-if="showGradeInfo" class="card flex justify-content-center userInfo "  >
                <Dialog v-model:visible="showGradeInfo" modal :test="selectedStudentGradeId"   :style="{ width: '90vw' } ">
                    
                   <div ref="printable">
                        <!-- Add your header content here -->
                        <div class="flex flex-col justify-center items-center w-full bg-[#034515] header-container-1 " >
                            <div class=" w-[100%] text-center text-2xl font-semibold header-container-2">
                                
                                <div class="flex w-[100%] justify-between p-2 items-center font-sans header-container-3 ">
                                    <div class="flex items-center w-[100%] md:w-[70%] left-header">
                                        <div class="flex "><img :src="'/storage/Images/logo1.png'" alt="TLE Logo" class="w-[100px] logo"/></div>
                                        <div class="flex flex-col items-start ml-2 w-[100%] md:w-[70%] school-info-container ">
                                            <span class="text-[20px] leading-tight mb-[2px] tracking-wider text-gray-200 school-acro">BINHS</span>
                                            <span class="  md:inline-block text-[7px] md:text-[12px] text-gray-300  leading-tight mb-[2px]">Bulihan Integrated National Highschool</span>
                                            <span class=" hidden md:inline-block text-[12px] text-gray-300  leading-tight mb-[2px]">Brgy. Old Bulihan, Silang, Philippines</span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="flex flex-col justify-end items-end mr-4 invisible w-0 md:w-60  md:visible space-y-1  pt-2 right-header-container ">
                                        <span class="text-[12px] text-center leading-tight w-[200px] text-gray-200 flex items-center   ">
                                            <svg class="h-5 w-5 text-gray-200"  width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                                            <span class="text-[12px] text-center  text-gray-200 ml-2 ">Contact #: 0924-123-4567</span>
                                            
                                        </span>
                                        <div class="flex items-center w-[200px]  ">
                                            <svg class="h-5 w-5 text-gray-200 "  width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="3 9 12 15 21 9 12 3 3 9" />  <path d="M21 9v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />  <line x1="3" y1="19" x2="9" y2="13" />  <line x1="15" y1="13" x2="21" y2="19" /></svg>
                                            <span class="text-[12px] text-center  text-gray-200 ml-2 ">
                                                email: bulihan@gmail.com
                                            </span>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    
                        <div class="w-full mt-2">
                            <hr class="border-t-4 border-black">
                        </div>
                        <div class="flex justify-center table-title-container">
                            <span class="text-gray-700 text-[18px] font-semibold mt-2 table-title">Student Grades Information</span>
                        </div>
                        <div class="w-full mt-2">
                            <hr class="border-t-2 border-gray-400">
                        </div>
                        <div v-for="student in currentPageItems"  class=" overflow-x-auto shadow-md rounded-lg table-div-container">  
                        <div  v-if="(student.id === selectedStudentGradeId)" >
                                <div class="p-2">
                                    <div class="flex flex-col md:flex-row justify-between text-gray-700 text-[20px] my-2 student-info-container">
                                        <span>Name: {{ student.student.lName }}, {{ student.student.fName }}</span>
                                        <span>Section: {{ student.student.section.name }}</span>
                                    </div>
                                    <table v-for="quizzes in student.student.student_active_quiz" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                                        <thead class="text-xs text-gray-200 uppercase bg-green-700 table-header ">
                                            <tr  >
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    ID#
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    title
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    grading period
                                                </th>
                                                
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    date taken
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    items
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    score
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    grade
                                                </th>
                                                
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.id }}
                                            </td>
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.quiz.title }}
                                            </td>
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.grading_period }}
                                            </td>
                                            
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ dateFormat(quizzes.updated_at)  }}
                                            </td>
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.quiz.question.length }}
                                            </td>
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.quiz_score  }}
                                            </td>
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.quiz_grade  }}
                                            </td>
                                            <td  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ quizzes.status  }}
                                            </td>

                                        </tbody>
                                    </table>
                                </div> <!--here-->
                        </div>
                        </div>
                    </div> 
                    <template #footer>
                        <Button label="Close" icon="pi pi-times" @click="showGradeInfo = false" text />
                        <Button label="Print" icon="pi pi-check" @click="printDiv" />
                    </template>
                </Dialog>
            </div>
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

import { usePage, useForm } from '@inertiajs/vue3';
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

// grade info logic
const showGradeInfo = ref(false);
const selectedStudentGradeId = ref(null)

const handleGradeInfoModal = (studentGradeId) =>{
    showGradeInfo.value = !showGradeInfo.value
    selectedStudentGradeId.value = studentGradeId
    
}

const flashClear = useForm({
  clear: null,
})

const printable = ref(null);

function printDiv() {
    const printContents = printable.value.innerHTML;
    const originalContents = document.body.innerHTML;

    // Create a new windows
    const printWindow = window.open('', '_blank');

    // Write the printable content to the new window
    printWindow.document.write('<html><head><title>Quiz Information</title>');
    
    //Manually include some Tailwind CSS styles
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: "Arial", sans-serif; background-color:white; }');
    printWindow.document.write('.text-red-500 { color: #ef4444; }'); // Example Tailwind class 
    
   
    printWindow.document.write('.header-container-1{background-color: #034515; padding:4px}')
    printWindow.document.write('.header-container-2{   }')
    printWindow.document.write('.header-container-3{ display:flex; justify-content: space-between; color:whitesmoke   }')
    printWindow.document.write('.logo{ width: 100px; height: 100px}')
    printWindow.document.write('.left-header{ display:flex; align-items:center }')
    printWindow.document.write('.right-header-container{ display:flex; flex-direction: column;   justify-content:center; align-items:center;  margin-right:10px;}')
    printWindow.document.write('.school-info-container{ display:flex; flex-direction: column; margin-left:2px}')
        
    //printWindow.document.write('.table-title-container{ display:flex; justify-content:center }')
    
    //<div class="flex flex-col md:flex-row justify-between text-gray-700 text-[20px] my-2 student-info-container">
    printWindow.document.write('.student-info-container{ display:flex; justify-content:space-between; align-items:center; padding:4px; }')
    printWindow.document.write('table{ width:100% }')
    printWindow.document.write('.table-title{ grid-column: span 4;  }')
    printWindow.document.write('th{ color:whitesmoke; padding:10px; text-transform: uppercase; }')
    printWindow.document.write('th{ color:whitesmoke; padding:10px; text-transform: uppercase; }')
    printWindow.document.write('td{ text-align:center; padding:2px; }')
    printWindow.document.write('.table-header{ background-color: #034515 }')
    //Include other styles as needed
    printWindow.document.write('</style>');

    // Complete the head section and start the body
    printWindow.document.write('</head><body>');
    
    // Add the printable content
    printWindow.document.write(printContents);

    // Complete the body and HTML
    printWindow.document.write('</body></html>');
    printWindow.document.close();
        
    // Use setTimeout to ensure that the styles are applied before printing
    setTimeout(() => {
        printWindow.print();
        printWindow.onafterprint = () => {
            printWindow.close();
            showGradeInfo.value = false; // Close the modal after printing
        };
    }, 1000); // Adjust the delay as needed
}

function dateFormat(inputDate) {
    const date = new Date(inputDate);

    // Check if date is valid
    if (isNaN(date.getTime())) {
        console.error('Invalid date');
        return null;
    }

    const months = [
        'Jan', 'Feb', 'March', 'April',
        'May', 'June', 'July', 'Aug',
        'Sept', 'Oct', 'Nov', 'Dec'
    ];

    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    let hours = date.getHours();
    const minutes = date.getMinutes();
    const ampm = hours >= 12 ? ' pm' : ' am';

    // Convert hours to 12-hour format
    hours = hours % 12;
    hours = hours === 0 ? 12 : hours;

    const formattedDate = `${month} ${day}, ${year} ${hours}:${minutes < 10 ? '0' : ''}${minutes}${ampm}`;

    return formattedDate;
}





</script>