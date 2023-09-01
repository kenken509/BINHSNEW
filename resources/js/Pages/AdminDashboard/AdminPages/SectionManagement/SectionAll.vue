<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">All Sections Page</span>  
        </div>
        {{ handledSections }}
        <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>
        <div class=" overflow-x-auto shadow-md rounded-lg ">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr>
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
                </thead>
                <tbody v-if="user.role === 'admin'" v-for="section in sections.sections" :key="section.id" >
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
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ section.subject.name}}
                        </td>
                        <td v-if="section.instructor" scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ section.instructor.fName+', '+ section.instructor.lName }}
                        </td>
                
                        
                        <td>
                            <div  class=" space-x-4 px-2">
                                <Link :href="route('section.delete', {section:section.id})" class="cursor-pointer" v-tooltip.left="'Delete Section'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 mx-2"></span></Link>
                                <Link :href="route('section.edit', {id:section.id})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit Section'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
                
                <tbody v-if="user.role === 'instructor'" v-for="section in instructorSections" :key="section.id" class="" >
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
                <Dialog v-model:visible="visible" modal   :userId="userId" :style="{ width: '90vw' } ">
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
        
    </DashboardLayout>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';
import { DialogDescription } from '@headlessui/vue';


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

const visible = ref(false);
const selectedSection = ref(null);

const showStudentsModal = (id)=>{
    visible.value = !visible.value
    selectedSection.value = id;
}
    


</script>