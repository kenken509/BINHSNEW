<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Web Posts Page</span>  
        </div>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700 ">
                    <tr>
                            <th scope="col" class="px-6 py-3">
                                ID#
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Post Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Author
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Content
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Media
                            </th>
                            
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                            
                        </tr>
                        
                </thead>
                <tbody>
                    
                    <tr v-for="post in post.posts" class="hover:bg-red-200 cursor-pointer border border-gray-300">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.author_id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify">
                            {{ post.content }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            ATTACHMENTS HERE
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            action here
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

const user = usePage().props.user

const post = defineProps({
    posts:Array,
    about:Array,
    contacts:Array,
})

</script>