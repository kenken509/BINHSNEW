<template>
    <DashboardLayout :user="user">
            <!-- flow bite tables-->
            <div class="flex flex-col ">
                <div class="flex justify-between items-center justify-between border-bot-only border-gray-600  py-2">
                    <div class="">
                        <span class="text-[20px] font-bold text-gray-500">All Users Page</span>
                    </div>
                    
                    <div class="">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="searchField" placeholder="search " />
                        </span>
                    </div>
                    <!-- <div v-if="user.role === 'admin'" class="col-span-6 md:col-span-1 item-center">
                        <form @submit.prevent="submit">
                            <Dropdown  v-model="selectedRole" :options="filter" optionLabel="role" placeholder="Sort by role" class="w-full md:w-14rem " />
                        </form> 
                    </div> -->
                </div>
                <div v-if="$page.props.flash.success" ><span class="p-3 text-gray-200">{{ successMessage($page.props.flash.success)  }}</span></div>
                <div v-if="$page.props.flash.error" class="flex items-center rounded-md bg-red-600 my-4 h-8 "><span class="p-3 text-gray-200">{{ $page.props.flash.error }}</span></div>
                <!--SEARCHED USER-->
                <div v-if="filteredUser" class="overflow-x-auto sm:-mx-6 lg:-mx-8 mt-4 overflow-x">
                    
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-x-scroll">
                            <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b font-medium dark:border-neutral-500 bg-gray-300">
                                <tr>
                                <th scope="col" class="px-6 py-4">ID #</th>
                                <th scope="col" class="px-6 py-4">Picture</th>
                                <th scope="col" class="px-6 py-4">Full name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Added by:</th>
                                <th scope="col" class="px-6 py-4">Updated by:</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                v-for="user in filteredUser"
                                :key="user.id"
                                
                                class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-gray-300">
                                    
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ user.id}}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        
                                        <Image :src="user.image ? appUrl+user.image:appUrl+defaultImage" alt="Image" width="60" preview>
                                            <template #indicator>
                                                <i class="pi pi-eye"></i>
                                            </template>
                                        </Image>     
                                    </td>  
                                    
                                    <td class="whitespace-nowrap px-6 py-4"><span v-if="user.lName">{{ toUpperFirst(user.lName)  }}</span>, <span v-if="user.fName">{{ toUpperFirst(user.fName)  }}</span> <span v-if="user.mName">{{ user.mName.substring(0,1).toUpperCase() }}</span>.</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.email }} </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.role }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        
                                        <div v-for="(creator,index) in users.data" :key="index">
                                            <p v-if="creator.id === user.created_by">{{creator.role }} {{ creator.fName }}</p>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        
                                        <div v-for="(editor,index) in users.data" :key="index">
                                            <p v-if="editor.id === user.updated_by">{{editor.role }} {{ editor.fName }}</p>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class=" space-x-6" >
                                            <div v-if="$page.props.flash.success"><Toast position="top-left" /> </div>
                                            
                                        
                                            <span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 cursor-pointer"  @click="deleteConfirmation(user.id)"></span>

                                            <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'View full info'" @click="openModal(user.id)" ></span>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--SEARCHED USER-->

                <!--ALL USERS-->
                <div v-if="allUsersVisible" class="overflow-x-auto sm:-mx-6 lg:-mx-8 mt-4 overflow-x">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-x-scroll">
                            <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b font-medium dark:border-neutral-500 bg-gray-300">
                                <tr>
                                <th scope="col" class="px-6 py-4">ID #</th>
                                <th scope="col" class="px-6 py-4">Picture</th>
                                <th scope="col" class="px-6 py-4">Full name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Added by:</th>
                                <th scope="col" class="px-6 py-4">Updated by:</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                v-for="user in users.data"
                                :key="user.id"
                                
                                class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-gray-300">
                                    
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ user.id}}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        
                                        <Image :src="user.image ? appUrl+user.image:appUrl+defaultImage" alt="Image" width="60" preview>
                                            <template #indicator>
                                                <i class="pi pi-eye"></i>
                                            </template>
                                        </Image>     
                                    </td>  
                                    
                                    <td class="whitespace-nowrap px-6 py-4"><span v-if="user.lName">{{ toUpperFirst(user.lName)  }}</span>, <span v-if="user.fName">{{ toUpperFirst(user.fName)  }}</span> <span v-if="user.mName">{{ user.mName.substring(0,1).toUpperCase() }}</span>.</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.role }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        
                                        <div v-for="(creator,index) in users.data" :key="index">
                                            <p v-if="creator.id === user.created_by">{{creator.role }} {{ creator.fName }}</p>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        
                                        <div v-for="(editor,index) in users.data" :key="index">
                                            <p v-if="editor.id === user.updated_by">{{editor.role }} {{ editor.fName }}</p>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class=" space-x-6" >
                                            <div v-if="$page.props.flash.success"><Toast position="top-left" /> </div>
                                            
                                        
                                            <span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Delete User'" @click="deleteConfirmation(user.id)"></span>
                                            <!-- <Link :href="route('admin.userDelete', {user: user.id})" class="cursor-pointer" v-tooltip.left="'Delete User'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                                            <!-- <Link :href="route('admin.editUser', {id:user.id} )" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit User'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link> -->
                                            <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'View full info'" @click="openModal(user.id)" ></span>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--ALL USERS-->

                <div v-if="users.data.length && allUsersVisible" class="w-full flex justify-center mt-8 mb-8">
                    <Pagination :links="users.links"/>    
                </div>
                <!--Modal-->
                <div class="card flex justify-content-center userInfo" >
                    
                    <Dialog v-model:visible="visible" modal   :userId="userId" :style="{ width: '50vw' } " >
                        <template #header class="w-full border-bot-only">
                            <div class="dialog-header ">
                                <h2 class="font-bold text-[24px]">User Info</h2>                           
                            </div>
                        </template>
                        <div v-if="!filteredUser" v-for="user in users.data" :key="user.id" id="testingPrinting" >
                            <!-- Header slot -->
                       
                            <div v-if="user.id === userId">
                                <div class="flex flex-col  space-y-2 border-bot-only mb-4 pb-2 ">
                                    <img :src="user.image ? appUrl+user.image:appUrl+defaultImage" alt="error" class="w-[100px] h-[100px]"/>
                                    <p><span class="font-bold ">Role:&nbsp;</span>  {{ user.role }}</p>
                                </div>
                               
                                
                                <div class=" grid grid-cols-2">
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col lg:flex-row">
                                            <span class="font-bold ">First Name:&nbsp; </span> {{ user.fName }}
                                        </p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col lg:flex-row"><span class="font-bold ">Middle Name:&nbsp; </span>{{ user.mName }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col lg:flex-row"><span class="font-bold ">Last Name:&nbsp; </span>{{ user.lName }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">

                                        <p class="flex flex-col lg:flex-row"><span class="font-bold ">Gender:&nbsp; </span>{{ user.gender }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col lg:flex-row"><span class="font-bold ">Civil Status:&nbsp; </span>{{ user.civilStatus }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col lg:flex-row" ><span class="font-bold ">Email:&nbsp; </span>{{ user.email }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col md:flex-row"><span class="font-bold ">Birthday:&nbsp; </span> {{ user.birthDate }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col md:flex-row"><span class="font-bold ">Age:&nbsp; </span> {{ user.age }}</p>
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <p class="flex flex-col lg:flex-row"><span class="font-bold ">Contact #:&nbsp; </span> {{ user.phoneNumber }}</p>
                                    </div>
                                    <div class="flex">
                                        <span class="font-bold ">Subject:&nbsp;</span>  
                                        <div v-if="user">
                                            <div v-if="user.subject">
                                                <div v-if="user.subject.name">{{ user.subject.name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="user.role === 'student'" class="col-span-2 lg:col-span-1">
                                        <p ><span class="font-bold ">Section: </span> {{ user.section.name }}</p>
                                    </div>
                                    
                                    <div v-if="user.role === 'instructor'" class="col-span-2 lg:col-span-1">
                                        <span class="font-bold ">Handled Sections: </span>
                                        
                                        <div v-for="(section, index) in user.instructor_sections" :key="index" >
                                            <p> {{ section.name }} </p>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                

                            </div>
                           
                        </div>
                        <!-- filtered user-->
                        <div v-else v-for="(user, index) in filteredUser" :key="index" id="testingPrinting">
                            <div v-if="user.id === userId">
                                <img :src="user.image ? appUrl+user.image:appUrl+defaultImage" alt="error" class="w-[50px] h-[50px]"/>
                                <h1 class="border-bot-only">User Info</h1>
                                <p>Role: filtered {{ user.role }} </p>
                                <p>First Name: {{ user.fName }}</p>
                                <p>Middle Name: {{ user.mName }}</p>
                                <p>Last Name: {{ user.lName }}</p>
                                <p>Gender: {{ user.gender }}</p>
                                <p>Civil Status: {{ user.civilStatus }}</p>
                                <p >Email: {{ user.email }}</p>
                                <p>Birthday: {{ user.birthDate }}</p>
                                <p>Age: {{ user.age }}</p>
                                <p>Contact #: {{ user.phoneNumber }}</p>
                                <p>Subject: <div v-if="user"><div v-if="user.subject"><div v-if="user.subject.name">{{ user.subject.name }}</div></div></div></p>
                                <p v-if="user.role === 'student'">Section: {{ user.section.name }}</p>
                                <div v-if="user.role === 'instructor'">
                                    Handled Sections:
                                    <div v-for="(section, index) in user.instructor_section" :key="index" >
                                        <p> {{ section.name }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- filtered user-->
                        <template #footer>
                            <div class=" border-t-2 pt-2">
                                <Button label="Close" icon="pi pi-times" @click="visible = false" raised  />
                            </div>   
                            <!-- <Button label="Print" icon="pi pi-check" @click="printPage('testingPrinting')" autofocus /> -->
                        </template>
                    </Dialog>
                </div>
            </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import Pagination from '../../AdminComponents/Pagination.vue';
import {ref, computed, watch, onMounted } from 'vue'
import {Link, useForm, usePage, router} from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast';
import { toUpperFirst } from '../../../Functions/Methods.vue';
import Swal from 'sweetalert2';
import printJS from 'print-js'

const searchField = ref('');
const allUsersVisible = ref(false);

const specificElement = ref(null);

onMounted(() => {
  // Assuming you have an element with the ID 'myElement'
  specificElement.value = document.getElementById('printElement');
});

const filter = ref([
    {
        'role':'All',
        'value': 'all'
    },
    {
        'role':'Admin',
        'value': 'admin'
    },
    {
        'role': 'Instructor',
        'value': 'instructor'
    },
    {
        'role': 'Student',
        'value': 'student'
    }
])
const visible = ref(false);
const userId =ref(1)
const selectedRole = ref(null);
const selectedFilter = useForm({
    role : null,
});

watch(selectedRole,(val) =>{
    // do something!
    selectedFilter.role = val.value

    const submit = selectedFilter.post(route('admin.showAllUsers'),{
        preserveScroll: true,
    })
    
})
//


const props = defineProps({
   users:Object,
   allUsers:Array,
})
const exist = ref([]);

onMounted(()=>{
    allUsersVisible.value = true;
})
const filteredUser = ref("");
watch(searchField, (newSearchField )=>{
    
    updateFilteredUsers();
})

function updateFilteredUsers(){
    console.log('ito laman: '+searchField.value);
    if(searchField.value === '')
    {
        filteredUser.value = "";
        allUsersVisible.value = true;
    }
    else
    {
        allUsersVisible.value = false
        filteredUser.value = props.allUsers.filter(user =>
        Object.values(user).some(value =>
            typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())
            )
        );
    }
    
}




const user = usePage().props.user;



//modal toggler
const openModal = (id)=> {
    visible.value = true
    userId.value = id
    
    
}

// print
const printPage = (divName)=>{
    printJS('testingPrinting', 'html');
}

const appUrl = '/storage/'
const defaultImage = 'images/default.png'

// alert codes

function deleteConfirmation(userId)
{
    Swal.fire({
        title:'Delete confirmation',
        text:"You won't be able to revert this!",
        icon:'warning',
        confirmButtonText:'Yes, delete it!',
        cancelButtonText:'Cancel',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        allowOutsideClick:false,
        allowEscapeKey:false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            const userDeleteUrl = route('admin.userDelete', {user: userId});

            router.delete(userDeleteUrl);
        }

        if(result.isDismissed)
        {
            Swal.fire({
                title:'Canceled',
                text:'Your action was canceled!',
                icon:'error',
            })
        }
    })
}

function successMessage(message)
{
    Swal.fire({
        title:'Success',
        text:message+'!',
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

</script>