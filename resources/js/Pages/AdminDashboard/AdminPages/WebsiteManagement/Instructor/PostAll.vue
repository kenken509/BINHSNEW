<template>
    <DashboardLayout :user="user">
        
        <div class="flex justify-between items-center py-4 border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">All Posts</span> 
            <div class="">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " @input="handleSearchFieldInput" />
                </span>
            </div> 
        </div>
        <div v-if="$page.props.flash.success" ><span class="p-3 text-gray-200">{{ successMessage($page.props.flash.success)  }}</span></div>
            <div v-if="$page.props.flash.error" class="flex items-center rounded-md bg-red-600 my-4 h-8 "><span class="p-3 text-gray-200">{{ $page.props.flash.error }}</span></div>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg mt-5">
            
       
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
                            Media
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Author
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Content
                        </th>
                        
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="post in currentPageItems" :key="post.id" >
                    <tr class="bg-white border-b ">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ post.title }}
                        </td>

                        <td v-if="post.attachments.length " scope="row" class=" first-letter:px-6 py-4 font-medium text-gray-900  ">
                            <div v-for=" attachments in post.attachments" >
                                <img :src="'/storage/'+attachments.filename" alt="Error" class="w-[100px] h-[100px] rounded-md relative"/>
                            </div>                       
                        </td>
                        <td v-else scope="row" class=" px-6 py-4 font-medium text-gray-900  ">
                            <span>no media</span>
                        </td>
                       
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ toUpperFirst(post.author.lName)  }}, {{ toUpperFirst(post.author.fName)  }} 
                        </td>
                        
                        <td scope="row" class="items-center px-6 py-4 font-medium text-gray-900">
                            <span>{{ truncateText(post.content, 5) }}</span>
                        </td>
                       
                        
                        
                        <td>
                            <div class=" space-x-4">
                                <span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 cursor-pointer" @click="confirmDelete(post.id)"></span>
                                <!-- <Link :href="route('webPost.delete', {id:post.id })" class="cursor-pointer" v-tooltip.left="'Delete Post'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                                <Link :href="route('instructorWebPost.edit', { id:post.id })" class="cursor-pointer hover:dark:scale-125" v-tooltip.left="'Edit'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Preview'" @click="openModal(post.id)" ></span>
                            </div>    
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--PREVIEW MODAL-->
            <Dialog v-model:visible="visible" modal   :style="{ width: '75vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }" @update:visible="handleDialogClose">
                <div slot="header" style="border-bottom: 2px solid #e2e8f0;">
                   <span class="text-[30px] font-bold text-gray-500">Post Information</span>
                </div>
                <div class="relative" >
                    
                    <div v-for="selectedPost in allPost.posts">
                        <div v-if="selectedPost.id === postId" class="flex flex-col mt-4">
                            <span class="text-[20px] font-bold"> {{ selectedPost.title }}</span>
                            <span class="text-[12px]"> Author:  {{ toUpperFirst(selectedPost.author.lName)  }}, {{ toUpperFirst(selectedPost.author.fName)  }} </span>
                                
                            <div v-if="selectedPost.attachments.length "  class=" first-letter:px-6 py-4 font-medium text-gray-900  ">
                                <div v-for=" attachments in selectedPost.attachments" >
                                    <img :src="'/storage/'+attachments.filename" alt="Error" class="w-full h-full rounded-md relative"/>
                                </div>                       
                            </div>
                            <div v-else  class="flex justify-center px-6 py-4 font-medium text-gray-900 border border-2 border-gray-200 shadow-md rounded-md my-2 ">
                                <span>no media</span>
                            </div>
                            <p>
                                {{ selectedPost.content }}
                            </p>
                        </div>
                    </div>
                </div>
                
            </Dialog>
            <!--PREVIEW MODAL---->
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
import { usePage, Link, useForm, router } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { toUpperFirst,truncateText } from '../../../../Functions/Methods.vue'
import {ref, computed, watch, onMounted} from 'vue'
import Swal from 'sweetalert2';



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
// const expandedPosts = ref([]);

// const allowRead = ()=>{
//     readMore.value = !readMore.value
//     console.log(readMore.value);
// }



const selectedPostId = ref(null);
const openModal = (id)=>{
    visible.value = !visible.value
    postId.value = id;
    selectedPostId.value = id;
    
    
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


const postsWithPrivateComments = computed(() => { 
    
  return allPost.posts.filter((post) => {
    return post.id === selectedPostId.value && post.comments.some((comment) => comment.status === 'private');
  });
});

 const approveComment = () => approvePendingCommentForm.post(route('comment.approve'));

 // alerts function

function confirmDelete(postId){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false,
        }).then((result) => {
            
        if (result.isConfirmed) {
            const deleteUrl = route('webPost.delete', {id:postId });

            router.delete(deleteUrl)
            // Swal.fire(
            // 'Deleted!',
            // 'Your file has been deleted.',
            // 'success'
            // )
        }else if (result.isDismissed) 
        {
            Swal.fire(
            'Cancelled',
            'Your post file is safe!',
            'error'
            )
        }
    })
}

function successMessage(message){
    Swal.fire({
        title: 'Success',
        text: message,
        icon: 'success',
        allowOutsideClick: false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            location.reload()
        }
    })
}

onMounted(()=>{
    filteredData.value = allPost.posts
    pageNumbers.length = totalPages.value
})

// search logic
const filteredData = ref([])
const searchField  = ref(null)

function handleSearchFieldInput(){
    if(!searchField.value)
    {
        filteredData.value = quizzes.quizzes
    }
    else
    {
        filteredData.value = allPost.posts.filter( post =>
            Object.values(post).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) ||
            Object.values(post.author).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase())) 
        )  
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