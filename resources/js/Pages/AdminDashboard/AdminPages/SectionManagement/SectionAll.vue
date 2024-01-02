<template>
    <DashboardLayout :user="user">
        <div class="flex items-center sm:flex-col md:flex-row  lg:justify-between border-bot-only py-2 border-gray-600  mb-4">
            <span class="text-[20px] font-bold text-gray-500">All Sections </span>  

            <div class="">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " @input="handleSearchFieldInput" />
                </span>
            </div>
        </div>
        <span class="text-red-500">TO DO: COMPLETE THE STUDENTS PRINT DESIGN</span>
        <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
        <div class=" overflow-x-auto shadow-md rounded-lg ">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr v-if="user.role === 'instructor'">
                        <th scope="col" class="px-6 py-3 text-center">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Instructor
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Subject
                        </th> 
                        <th v-if="sections.sections" scope="col" class="px-6 py-3 text-center">
                            Students
                        </th>
                    </tr>

                    <tr v-if="user.role === 'admin'">
                        <th scope="col" class="px-6 py-3 ">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3 ">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 ">
                            Subject
                        </th>
                        <th v-if="sections.sections" scope="col" class="px-6 py-3 ">
                            Instructor
                        </th>
                        <th v-if="sections.sections" scope="col" class=" text-center px-6 py-3 ">
                            Students
                        </th>
                        <th v-if="sections.sections" scope="col" class="px-6 py-3 ">
                            Action
                        </th>
                    </tr>
                </thead>
                

                <tbody v-if="user.role === 'admin'" v-for="section in currentPageItems" :key="section.id" >
                    <tr class="bg-white border-b ">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ section.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ section.name }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ section.subject.name}}
                        </td>
                        
                        <td v-for="instructor in section.instructors" scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ instructor.lName }}, {{  instructor.fName }}
                        </td>
                        <td class="text-center px-6 ">
                            <span class="pi pi-eye text-green-600 scale-150 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'View students'" @click="showStudentsModal(section.id)"></span>
                        </td>
                        <td>
                            <div  class=" space-x-4 px-2">
                                <span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 mx-2 cursor-pointer" @click="deleteConfirmation(section.id)"></span> 
                                 <!-- <Link :href="route('section.delete', {section:section.id})" class="cursor-pointer" v-tooltip.left="'Delete Section'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 mx-2"></span></Link> -->
                                 <Link :href="route('section.edit', {id:section.id})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit Section'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                            </div>    
                        </td>
                    </tr>
                </tbody>
                



                <tbody v-if="user.role === 'instructor'" v-for="section in currentPageItems" :key="section.id" class="" >
                    <div >
                        <div ></div>
                    </div>
                    
                    <tr v-for="instructorSection in section.instructors"  class="bg-white border-b ">
                        <td v-if="instructorSection.id === user.id" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                            {{ section.id }}
                        </td>
                        <td v-if="instructorSection.id === user.id" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                            {{ instructorSection.lName }}, {{ instructorSection.fName }}
                        </td>
                        <td  v-if="instructorSection.id === user.id" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                            {{ section.name }}
                        </td>
                        <td  v-if="instructorSection.id === user.id"  scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                            {{ section.subject.name}}
                        </td>
                        

                        <!-- comment this part-->
                        <!-- <div v-for="students in sections.studentUser" >
                            <td v-if="(students.section_id === section.id) && students.role === 'student' " scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                                {{ students.fName }} 
                            </td>
                        </div> -->
                        <!-- comment this part-->
                        <td  v-if="instructorSection.id === user.id" class=" text-center ">
                            <span class="pi pi-eye text-green-600 scale-150 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'View students'" @click="showStudentsModal(section.id)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            

            <!--Modal-->
            <div class="card flex justify-content-center userInfo">
                <Dialog v-model:visible="visible" modal    :style="{ width: '90vw' } ">
                    <div ref="printable">
                        <div class="flex flex-col justify-center items-center w-full bg-green-700 header-container-1 mb-2 rounded-md">
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
                        <div class="section-info-container">
                            <div v-for="section in sections.sections" class="flex justify-between mx-2 section-info-data ">
                                <div>
                                    <div v-if="selectedSection === section.id">
                                    <span class="text-black font-bold">Instructor:</span>  {{ section.instructors[0].fName }}, {{ section.instructors[0].lName }}
                                    </div>
                                    
                                </div>
                                <div>
                                    <div v-if="selectedSection === section.id">
                                        <span class="text-black font-bold">Section: </span> {{ section.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class=" overflow-x-auto shadow-md rounded-lg mt-2">   <!-- v-for="students in sections.studentUser" -->
                            <table   class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                                <thead class="text-xs text-gray-200 uppercase bg-green-700 table-header ">
                                    <tr >
                                        <td colspan="5">
                                            <div class="flex justify-center font-bold text-lg border-bot-only py-2 student-table-title">
                                                STUDENTS
                                            </div>
                                        </td>
                                    </tr>
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
                                
                                    <tbody v-for="section in sections.sections"  >
                                        <tr  v-for="student in section.student"  class="bg-white border-b ">
                                            <td v-if="student.section.id === selectedSection" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ student.id }}
                                            </td>
                                           
                                            <td v-if="student.section.id === selectedSection" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ student.lName }}, {{ student.fName }}
                                            </td>
                                            <td v-if="student.section.id === selectedSection" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ student.email }} 
                                            </td>
                                            
                                            <td v-if="student.section.id === selectedSection" scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                                                {{ student.gender }} 
                                            </td>
                                        </tr>
                                    </tbody>
                                
                                
                            </table>
                        </div>
                    </div>
                    <template #footer>
                        <Button label="Close" icon="pi pi-times" @click="visible = false" text />
                        <Button label="Print" icon="pi pi-check" @click="printDiv" autofocus />
                    </template> 
                </Dialog>
            </div>
            
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
import { computed, onMounted, ref, watch } from 'vue';
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';


const user = usePage().props.user;




const sections = defineProps({
    sections:Array,
    studentUser:Array,
});


onMounted(()=>{
    filteredData.value = sections.sections
    pageNumbers.length = totalPages.value;
})

const visible = ref(false);
const selectedSection = ref(null);

const showStudentsModal = (id)=>{
    visible.value = !visible.value
    selectedSection.value = id;
}
    
// alert codes

function deleteConfirmation(sectionId)
{
    Swal.fire({
        title:'Deletion Confirmation',
        text:"You won't be able to revert this action!",
        icon:"warning",
        showCancelButton:true,
        confirmButtonText:'Yes, delete it!',
        cancelButtonText:'Cancel',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        allowOutsideClick:false,
        allowEscapeKey:false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            const deleteUrl = route('section.delete', {section:sectionId})

            router.delete(deleteUrl);
        }

        if(result.isDismissed)
        {
            Swal.fire({
                title:'Canceled',
                text:'Your action was canceled!',
                icon:'error',
                confirmButtonColor: '#3085d6',
            })
        }
    })
}

function successMessage(message)
{
    Swal.fire({
        title:'Success',
        text:message,
        icon:'success',
        allowOutsideClick:false,
        allowEscapeKey:false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            location.reload();
        }
    })
}

// search field logic
const searchField = ref(null);
const filteredData = ref([])




function handleSearchFieldInput(){

    if (!sections.sections || sections.sections.length === 0) {
        // Handle the case where sections.sections is undefined or an empty array
        console.error('No sections available');
        return;
    }

    if(!searchField.value)
    {
        filteredData.value = sections.sections
        console.log('null')
    }
    else
    {
        
        filteredData.value = sections.sections.filter(section =>
            Object.values(section).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(section.subject).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            section.instructors.some(instructor => 
                Object.values(instructor).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())
            )
    )
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

const createFinalGrade = (id) => {
    return computed(()=>{
        console.log(id)
    })
}


//PRINT DIV LOGIC
const printable = ref(null);
function printDiv() {
    const printContents = printable.value.innerHTML;
     // Create a new windows
     const printWindow = window.open('', '_blank');

    // Write the printable content to the new window
    printWindow.document.write('<html><head><title>Section Info</title>');

    //Manually include some Tailwind CSS styles
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: "Arial", sans-serif; background-color:white; }');
    printWindow.document.write('.text-red-500 { color: #ef4444; }'); // Example Tailwind class 

    printWindow.document.write('.logo{ width: 100px; height: 100px}')
    printWindow.document.write('.header-container-1{background-color: #046C4E; padding:4px}')
    printWindow.document.write('.header-container-3{ display:flex; justify-content: space-between; color:whitesmoke   }')
    printWindow.document.write('.left-header{ display:flex; align-items:center }')
    printWindow.document.write('.right-header-container{ display:flex; flex-direction: column;   justify-content:center; align-items:center;  margin-right:10px;}')
    printWindow.document.write('.school-info-container{ display:flex; flex-direction: column; margin-left:2px}')

    printWindow.document.write('.section-info-container{ margin-bottom:2px; margin-top:10px; }')
    printWindow.document.write('.section-info-data{ display:flex; justify-content:space-between; align-items:center;  padding:0px 4px 0px 4px }')
    printWindow.document.write('th{ color:whitesmoke; padding:10px; text-transform: uppercase; }') //
    printWindow.document.write('td{ text-align:center; padding:2px; border:1px solid black; }')
    printWindow.document.write('.student-table-title{ color:whitesmoke; padding:4px; font-size:20px; font-weight: bold;}')


    //table style
    printWindow.document.write('table{ width:100% }')
    printWindow.document.write('.table-header{ background-color: #046C4E }')
    
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
</script>