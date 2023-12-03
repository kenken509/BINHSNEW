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
        {{ handledSections }}  
        <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
        <div class=" overflow-x-auto shadow-md rounded-lg ">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr v-if="user.role === 'instructor'">
                        <th scope="col" class="px-6 py-3 text-center">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Subject
                        </th>
                        <th v-if="sections.sections" scope="col" class="px-6 py-3 text-center">
                            Instructor
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
                        <th v-if="sections.sections" scope="col" class="px-6 py-3 ">
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
                        
                        <td v-if="section.instructor" scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ section.instructor.fName+', '+ section.instructor.lName }}
                        </td>
                        <td class=" px-6 ">
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
                    <tr  class="bg-white border-b ">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                            {{ section.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                        {{ section.name }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-center ">
                            {{ section.subject.name}}
                        </td>
                        <td v-if="section.instructor" scope="row" class="px-6 py-4 font-medium text-gray-900  text-center">
                            {{ section.instructor.fName+', '+ section.instructor.lName }}
                        </td>
                        <!-- <div v-for="students in sections.studentUser" >
                            <td v-if="(students.section_id === section.id) && students.role === 'student' " scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                                {{ students.fName }} 
                            </td>
                        </div> -->
                        
                        <td class=" text-center ">
                            <span class="pi pi-eye text-green-600 scale-150 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'View students'" @click="showStudentsModal(section.id)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            

            <!--Modal-->
            <div class="card flex justify-content-center userInfo">
                <Dialog v-model:visible="visible" modal    :style="{ width: '90vw' } ">
                    <div class=" overflow-x-auto shadow-md rounded-lg ">   <!-- v-for="students in sections.studentUser" -->
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
import { DialogDescription, MenuItems } from '@headlessui/vue';
import Swal from 'sweetalert2';


const user = usePage().props.user;

const instructorSections = ref([]);
const handledSections = computed(()=>{
    
    sections.sections.forEach((section) =>{
        if(section.instructor_id === user.id)
        {
            instructorSections.value.push(section);
        }
    })
    
})



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
            Object.values(section.instructor).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) 
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