<template>
    <DashboardLayout :user="user">
        <div class="flex justify-between items-center justify-between border-bot-only border-gray-600  ">
            <div class="">
                <span class="text-[20px] font-bold text-gray-500">Users Approval Page</span>
            </div>
            
            
            <div class="py-4">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " />
                </span>
            </div>
        </div>   
        
        <div v-if="$page.props.flash.success" class="flex items-center rounded-md bg-[#28a745] my-4 h-8 "><span class="p-3 text-gray-200">{{ $page.props.flash.success }}</span></div>
        <div v-if="$page.props.flash.error" class="flex items-center rounded-md bg-red-600 my-4 h-8 "><span class="p-3 text-gray-200">{{ $page.props.flash.error }}</span></div>
        
        <div class=" overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr>
                        <th scope="col" class="text-center px-6 py-3">
                            Student #
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Surname
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Subject
                        </th>
                        <th scope="col" class="text-center px-6 py-3">
                            Section
                        </th>
                        
                        <th scope="col" class="text-center px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="student in currentPageItems" >
                    <tr class="bg-white border-b ">
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ student.student_number }}
                        </td>
                        <td scope="row" class=" text-center px-6 py-4 font-medium text-gray-900  ">
                            {{ student.fName }}
                        </td>
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900  ">
                           {{ student.lName }}
                        </td>
                
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ student.email }}
                        </td>
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ student.subject.name }}
                        </td>
                        <td scope="row" class="text-center px-6 py-4 font-medium text-gray-900 ">
                            {{ student.section ?  student.section.name: null}}
                        </td>
                        
                        <td scope="row" class=" text-center px-6 py-4 font-medium text-gray-900 ">
                            <div class="flex  space-x-10 md:justify-around text-center   items-center">
                                <div class="cursor-pointer hover:scale-125">
                                    <span class="pi pi-check-circle text-green-600 scale-150 hover:scale-150" v-tooltip.left="'approve'" @click="approvalConfirmation(student.id)"></span>
                                </div>
                                
                                <div class="cursor-pointer hover:scale-125" v-tooltip.left="'reject'">
                                    <span class="pi pi-times-circle text-red-700 scale-150 hover:scale-150" @click="rejectConfirmation(student.id)"></span>
                                </div>
                                <!-- <Link :href="route('admin.aprprovedUser.reject',{id:student.id})" class="cursor-pointer hover:scale-125" v-tooltip.left="'reject'" as="button" method="delete" ><span class="pi pi-times-circle text-red-700 scale-150 hover:scale-150"></span></Link> -->
                                <!-- <Link :href="route('admin.aprprovedUser.approve',{id:student.id})" class="cursor-pointer hover:scale-125" v-tooltip.left="'approve'" ><span class="pi pi-check-circle text-green-600 scale-150 hover:scale-150"></span></Link> -->
                                <!-- <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'Preview'" @click="openModal(quiz.id)" ></span>
                                <span class="pi pi-send cursor-pointer hover:scale-150" style="color: slateblue" v-tooltip.right="'Activate'" @click="showQuizModal(quiz.id)"></span> -->
                            </div>   
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            
        </div>
        <div class="flex justify-center w-full space-x-4 mt-4" v-if="totalPages > 1">
            <div @click="prevPage" class="flex items-center  cursor-pointer hover:text-red-400">
                <i class="pi pi-angle-double-left cursor-pointer" style="font-size: 24px;"></i>
                
            </div>
            <div class="flex space-x-2">
                <div v-for="(number, index) in totalPages" class="hover:text-green-500 cursor-pointer" @click="changePageClick(index+1)" >
                    <div v-if="currentPage === index+1" class="border bg-green-700 px-2 rounded-lg text-gray-200" >{{ index+1 }}</div>
                    <div v-else class="px-2">{{ index+1 }}</div>
                </div>
            </div>
            <div @click="nextPage" class="flex items-center  cursor-pointer hover:text-green-400">
                <i class="pi pi-angle-double-right  " style="font-size: 24px;"></i>
            </div>
        </div>
    </DashboardLayout>
  
</template>

<script setup>
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import Pagination from '../../AdminComponents/Pagination.vue';
import {ref, computed, watch, onMounted } from 'vue'
import {Link, router, useForm, usePage} from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast';
import { toUpperFirst } from '../../../Functions/Methods.vue';
import Swal from 'sweetalert2';


const filteredData = ref([])
const searchField = ref(null);
const user = usePage().props.user;
const student = defineProps({
    students:Array,
})

onMounted(()=>{
    filteredData.value = student.students

    pageNumbers.length = totalPages.value;
    
})

watch(searchField,(val)=>{
    
    if(val === '')
    {
        filteredData.value = student.students
    }
    else
    {
        updateFilteredUsers();
    }
})

function updateFilteredUsers(){
    console.log('ito laman: '+searchField.value);
    if(searchField.value === '')
    {
        filteredData.value = "";
        //allUsersVisible.value = true;
    }
    else
    {
        //allUsersVisible.value = false
        filteredData.value = student.students.filter(user =>
        Object.values(user).some(value =>
            typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())
            )
        );
    }
    
}
function approvalConfirmation(userId)
{
    Swal.fire({
        title:'Approval Confirmation',
        text:'Are you sure you?',
        confirmButtonText:'Yes, approve it!',
        cancelButtonText:'Cancel',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        icon:'question',
    }).then((result)=>{
        if(result.isConfirmed)
        {
            const approveUrl = route('admin.aprprovedUser.approve',{id:userId})

            router.get(approveUrl);
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

function rejectConfirmation(userId)
{
    

    Swal.fire({
        title:'Rejection Confirmation',
        text:'Are you sure you?',
        confirmButtonText:'Yes, reject it!',
        cancelButtonText:'Cancel',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        icon:'question',
    }).then((result)=>{
        if(result.isConfirmed)
        {
            const url = route('admin.aprprovedUser.reject',{id:userId})

            router.delete(url);
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

//pagination logic
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