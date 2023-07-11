<template>
    <DashboardLayout :user="user">
        
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
        
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
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
                            Comments
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="post in allPost.posts" :key="post.id" >
                    <tr class="bg-white border-b ">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ post.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ toUpperFirst(post.author.lName)  }}, {{ toUpperFirst(post.author.fName)  }} 
                        </td>
                        
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            
                            <div v-if="readMore">
                                {{ post.content }}  <button class="text-blue-300 hover:text-blue-500" @click="allowRead">read less</button>
                            </div>
                            <div v-else>
                                {{ truncateText(post.content, 5) }} <button class="text-blue-300 hover:text-blue-500" @click="allowRead">read more</button>
                            </div>
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <div v-if="!post.attachments">---</div>
                            <div v-else>{{ post.attachments }}</div>
                            
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.comments.length }}
                        </td>
                        <td>
                            <div class=" space-x-4">
                                <Link href="" class="cursor-pointer" v-tooltip.left="'Delete Question'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link href="" class="cursor-pointer hover:dark:scale-125" v-tooltip.left="'Edit'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Preview'" @click="openModal(post.id)" ></span>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <!--PREVIEW MODAL-->
            <Dialog v-model:visible="visible" modal header="Post Info"  :style="{ width: '75vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                <div>
                    this is the preview modal with post id : {{ postId }}
                    <hr>
                    <div v-for="selectedPost in allPost.posts">
                        <div v-if="selectedPost.id === postId">
                            <h1>Title: {{ selectedPost.title }}</h1>
                            <h1>Author:  {{ toUpperFirst(selectedPost.author.lName)  }}, {{ toUpperFirst(selectedPost.author.fName)  }} </h1>
                            <p>
                                <div v-if="readMore">
                                Content:

                                    {{ selectedPost.content }}  <button class="text-blue-300 hover:text-blue-500" @click="allowRead">read less</button>
                                </div>
                                <div v-else>
                                Content:

                                    {{ truncateText(selectedPost.content, 5) }} <button class="text-blue-300 hover:text-blue-500" @click="allowRead">read more</button>
                                </div>
                            </p>
                            <div>
                                Comments:
                                <div v-for="comments in selectedPost.comments">
                                    {{ comments.content }} {{ comments.status }} {{ comments.user_id }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </Dialog>
            <!--PREVIEW MODAL---->
        </div>
    </DashboardLayout>
    
</template>

<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { toUpperFirst,truncateText } from '../../../../Functions/Methods.vue'
import {ref} from 'vue'

const user = usePage().props.user;

const readMore = ref(false);
const visible = ref(false);
const postId = ref();

const allowRead = ()=>{
    readMore.value = !readMore.value
    console.log(readMore.value);
}

const openModal = (id)=>{
    visible.value = !visible.value
    postId.value = id;
    
}

const allPost = defineProps({
    posts: Array,
})
</script>