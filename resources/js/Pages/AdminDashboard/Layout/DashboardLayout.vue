<template>
    <!--Nav header-->
    <nav class=" fixed top-0 z-50 w-full  bg-green-200 border-b border-green-800 dark:bg-[#034515] shadow-lg">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
        
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-start">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
             </button>
            <a :href="route('index')" class="flex ml-2 md:mr-24">
              <img src="../../../../../public/images/webPage/logo1.png" class="h-14 mr-3" alt="Error" />
    
              <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">BINHS</span>
            </a>
          </div>
          <div class="flex items-center">
              <div class="flex items-center ml-3">
                <div class="text-gray-100 mx-2">{{ toUpperFirst(user.role) }}</div>
                
                <div>
                  <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-14 h-14 rounded-full bg-gray-200" :src="user.image ? appUrl+user.image:appUrl+defaultImage" alt="user photo">  
                  </button>
                </div>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                  <div class="px-4 py-3" role="none">
                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                      {{ user.fName }} 
                    </p>
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                      {{ user.email }}
                    </p>
                  </div>
                  <ul class="py-1" role="none">
                    <li>
                      <a :href="route('admin.showAdminPanel')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                    </li>
                    <li>
                      <a :href="route('user.profile.edit',{id:user.id})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Manage account</a>
                    </li>
                    
                    <li>
                      <Link :href="route('logout')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" as="button" method="delete">Sign out</Link>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
      </div>
    </nav>
    
    <!--side bar-->
    <aside id="logo-sidebar" class="fixed top-[80px] left-0 z-40 w-70 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
       <div class="h-full px-3 py-4 overflow-y-auto bg-gray-300 dark:bg-[#034515]">
        
            
          <ul class="space-y-2 font-medium">
             <li>
                <a :href="route('admin.showAdminPanel')" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-[#0fa54e] focus:bg-[#064922]" >
                   <i class="pi pi-chart-pie" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                   <span class="ml-3 " >Dashboard</span>
                </a>
             </li>
             
             <!-- user management-->
             <li v-if="user.role === 'admin'">
                <button type="button" class="flex items-center jus w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="user-management" data-collapse-toggle="user-management" >
                      <i class="pi pi-users" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="user-management" >Users Management</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul  id="user-management" class="hidden py-2 space-y-2">
                      <li >
                          <a  :href="route('admin.showAllUsers')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-users  scale-150 pr-3 text-gray-200" ></span> Display</a>
                      </li>
                      <li v-if="user.role === 'admin'">
                         <a :href="route('admin.approveUser.show')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><span class="pi pi-user-plus  scale-150 pr-3 text-gray-200" ></span>Pending</a>
                      </li>
                      <li v-if="user.role === 'admin'">
                         <a :href="route('admin.addUser')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><span class="pi pi-user-plus  scale-150 pr-3 text-gray-200" ></span> Add</a>
                      </li>
                </ul>
             </li>
             
             <!--SECTION MANAGEMENT-->
             <li >
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="section-example" data-collapse-toggle="section-example" >
                      <i class="pi pi-sitemap" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="section-example">Sections Management</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="section-example" class="hidden py-2 space-y-2">
                      <li >
                        
                          <a  :href="route('section.show')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-users  scale-150 pr-3 text-gray-200" ></span> Display</a>
                        
                      </li>
                      <li v-if="user.role === 'admin'" >
                         <a :href="route('section.add')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><span class="pi pi-user-plus  scale-150 pr-3 text-gray-200" ></span> Add</a>
                      </li>
                </ul>
             </li>

             <!--SECTION MANAGEMENT-->
            

             <!-- Questions Management-->

             <!-- <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="exam-management" data-collapse-toggle="exam-management" >
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white dark:group-focus:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="dropdown-example">Questions Management</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="exam-management" class="hidden py-2 space-y-2">
                      <li>
                        
                          <a  :href="route('question.all')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Display</a>
                        
                      </li>
                      <li>
                        
                        <a  :href="route('question.add')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Add</a>
                      
                      </li>
                      
        
                </ul>
             </li>              -->
             
             <!-- Questions Management-->

             <!--Quiz Management-->
             <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="quiz-management" data-collapse-toggle="quiz-management" >
                  <i class="pi pi-file-edit" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="quiz-management">Quiz Management</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="quiz-management" class="hidden py-2 space-y-2">
                      <li>
                        
                          <a  :href="route('quiz.show')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Display</a>
                        
                      </li>
                      <li v-if="user.role === 'instructor'">
                        
                        <a  :href="route('quiz.active')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Active</a>
                      
                      </li>
                      
                      <li v-if="user.role === 'instructor'">
                        
                        <a  :href="route('quiz.add')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Add Quiz</a>
                      
                      </li>
                      <li v-if="user.role === 'instructor'">
                        
                        <a  :href="route('quiz.pastDue')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Past Due</a>
                      
                      </li>
                      <li v-if="user.role === 'instructor'">
                        
                        <a  :href="route('quiz.results')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Quiz Results</a>
                      
                      </li>
                </ul>
             </li>      
             <!--Quiz Management-->

             <!--Web site management-->
             <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="website-management" data-collapse-toggle="website-management" >
                        <i class="pi pi-cloud-upload" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="website-management">Website Management</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="website-management" class="hidden py-2 space-y-2">
                    <li v-if="user.role === 'admin'">
                        
                        <a  :href="route('admin.post.all')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Display</a>
                      
                    </li>
                      <li v-if="user.role === 'instructor'">
                        
                          <a  :href="route('webPosts.all')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Display</a>
                        
                      </li>
                      <li v-if="user.role === 'instructor'">
                        
                        <a  :href="route('instructorWebPost.add')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Add</a>
                      
                      </li>
                      <li v-if="user.role === 'admin'">
                        
                        <a  :href="route('webPost.add')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Add</a>
                      
                      </li>
                </ul>
             </li>
             <!--Web site management-->
             

             <!--Student Grades-->
             <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="student-grades" data-collapse-toggle="student-grades" >
                  <i class="pi pi-calculator" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="student-grades">Student Grades</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="student-grades" class="hidden py-2 space-y-2">
                    <li >
                        <a  :href="route('student.grades.show')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Display</a>
                    </li> 
                </ul>
             </li>
             <li v-if="user.role === 'admin'">
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="backup-restore" data-collapse-toggle="backup-restore" >
                        <i class="pi pi-refresh" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="backup-restore">Backup & Restore</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="backup-restore" class="hidden py-2 space-y-2">
                    <li >
                        <a  :href="route('database.backup.show')" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Backup Files</a>
                    </li> 
                </ul>
             </li>
             <li >
                <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-[#0fa54e] focus:bg-[#0fa54e]" aria-controls="3d-management" data-collapse-toggle="3d-management" >
                        <i class="pi pi-box" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="3d-management">3D Management</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="3d-management" class="hidden py-2 space-y-2">
                    <li >
                        <a  href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Aprroved</a>
                    </li> 
                    <li v-if="user.role === 'admin'" >
                        <a  href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Pending</a>
                    </li>
                    <li >
                        <a  href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 "  ><span class="pi pi-list  scale-150 pr-3 text-gray-200" ></span>Add</a>
                    </li>
                </ul>
             </li>
             <hr>
             <li>
                <a href="#" class="flex gap-3 items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                  <i class="pi pi-power-off" style="color: rgb(197, 197, 197); font-size:1.5rem"></i>
                   <button type="button" @click="confirmSignOut">Sign out</button>
                   <!-- <Link :href="route('logout')" class=" ml-3 whitespace-nowrap" role="menuitem" as="button" method="delete">Sign out</Link> -->
                </a>
             </li>
          </ul>
       </div>
    </aside>
    
    <!-- main content -->
    <div class="p-4 sm:ml-64 ">
        <div class="p-4  rounded-lg dark:border-gray-700 mt-20  ">
            <slot  ></slot>
        </div>
    </div>
    
    </template>

<script setup>
import {Link, router} from '@inertiajs/vue3'
import Swal from 'sweetalert2';

const appUrl = '/storage/'
const defaultImage = 'Images/default.png'

const toUpperFirst = (word)=>{
  if(!word){
    return '';
  }
  else{
    //console.log("this: "+word[0].toUpperCase() + word.slice(1));
    return word[0].toUpperCase() + word.slice(1);
  }
  // if(word === 0){
  //   return ''
  // }
  // else
  // {
  //   return word.chartAt(0).toUpperCase()+word.slice(1);
  // }
}

defineProps({
  user:Object,
})

function confirmSignOut()
{
  Swal.fire({
    title:'Sign out',
    text:'Continue signing out?',
    icon:'question',
    confirmButtonText:'Yes, sign me out!',
    cancelButtonText:'Cancel',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    showCancelButton:true,
    allowOutsideClick:false,
    allowEscapeKey:false,
  }).then((result)=>{
     if(result.isConfirmed)
     {
        const logOutUrl = route('logout')

        router.delete(logOutUrl);
     }
  })
}
</script>