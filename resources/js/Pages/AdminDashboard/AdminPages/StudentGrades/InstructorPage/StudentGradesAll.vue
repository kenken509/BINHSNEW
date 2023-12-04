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
                <tbody v-for="grade in studentData.studentGrades" :key="grade.id">
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
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { usePage } from '@inertiajs/vue3';


const user = usePage().props.user;


const studentData = defineProps({
    studentGrades:Array,
})






</script>