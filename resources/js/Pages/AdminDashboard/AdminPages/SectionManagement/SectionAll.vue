<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">All Sections Page</span>  
        </div>
        <!-- <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div> -->
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Subject
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="section in sections.sections" :key="section.id" >
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
                
                        
                        <td>
                            <div class=" space-x-4">
                                <Link href="#" class="cursor-pointer" v-tooltip.left="'Delete Question'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link href="#" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit User'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            
           
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';


const user = usePage().props.user;

const sections = defineProps({
    sections:Array,
});

</script>