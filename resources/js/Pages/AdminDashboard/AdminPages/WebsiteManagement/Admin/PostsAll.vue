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
            <Dialog v-model:visible="visible" modal header="Post Info"  :style="{ width: '75vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }" @update:visible="handleDialogClose">
                <div>
                    this is the preview modal with post id : {{ postId }}
                    
                    <div v-if="$page.props.flash.success" class="flex items-center rounded-md bg-[#28a745] my-4 h-8 "><span class="p-3 text-gray-200">{{ $page.props.flash.success }}</span></div>
                <div v-if="$page.props.flash.error" class="flex items-center rounded-md bg-red-600 my-4 h-8 "><span class="p-3 text-gray-200">{{ $page.props.flash.error }}</span></div>
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
                            <!--pending comments-->
                            <div>
                                <h1>Pending Comments:</h1>
                                <form @submit.prevent="approveComment">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Comment
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody v-for="comments in selectedPost.comments">
                                            
                                            <tr v-if="comments.status === 'private'" class="bg-white border-b ">
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 border-x-2">
                                                    {{ comments.content }} {{ comments.status }} {{ comments.user_id }} id: {{ comments.id }}
                                                </td>
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                                    <div class="flex space-x-2">
                                                        <button type="submit" class="bg-indigo-600 rounded-md p-2 hover:bg-indigo-400 shadow-lg border text-gray-200" @click="setJob('approve',comments.id)">Approve</button>
                                                        <button type="submit" class="bg-indigo-600 rounded-md p-2 hover:bg-indigo-400 shadow-lg border text-gray-200" @click="setJob('delete', comments.id)">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <!--pending comments-->

                            <!--Approved comments-->
                            <div >
                                <h1>Approved Comments:</h1>
                                <form @submit.prevent="approveComment" >
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        
                                        <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Comment
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                       
                                            <tbody v-for="comment in allPost.comments">
                                                    
                                                    <tr v-if="comment.status === 'public'">
                                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 border-x-2">
                                                            {{ comment.content }} id: {{ comment.id }}
                                                        </td>
                                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                                            <div class="flex space-x-2">
                                                                <button type="submit" class="bg-red-600 rounded-md p-2 hover:bg-red-400 shadow-lg border text-gray-200" @click="disapproveComment(comment.id)">Disapprove</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                
                                            </tbody>
                                        
                                    </table>
                                </form>
                            </div>
                            <!--Approved comments-->
                        </div>
                    </div>
                </div>
                
            </Dialog>
            <!--PREVIEW MODAL---->
        </div>
    </DashboardLayout>
    
</template>

<script setup>
import { usePage, Link, useForm } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { toUpperFirst,truncateText } from '../../../../Functions/Methods.vue'
import {ref, computed} from 'vue'
import { inject } from 'vue';




const handleDialogClose = (value) => {
  if (!value) {
    window.location.reload()
  }
};


const allPost = defineProps({
    posts: Array,
    comments: Array,
})

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


const setJob = (buttonClicked , id) =>{
    approvePendingCommentForm.job = buttonClicked;
    approvePendingCommentForm.comment_id = id;
}

const disapproveComment = (id) => {
    approvePendingCommentForm.comment_id = id;
    approvePendingCommentForm.job = 'disapprove';
    
}
const approvePendingCommentForm = useForm({
    comment_id:null,
    job:null,
})


 const approveComment = () => approvePendingCommentForm.post(route('comment.approve'));
</script>