<template>
    <div>
        <div  class="border  border-gray-300 p-8 bg-gray-50 shadow-md my-8  rounded-md">
            <div v-if="post.newsPost" class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ post.newsPost.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(post.newsPost.created_at) }}</span>
            </div>
            <div v-if="post.newsPost" class="">
                
                <div class="border bg-black">
                    <div class="flex justify-center items-center">
                        <img :src="'/storage/'+post.newsPost.filename" alt="error" class=" shadow-md"> 
                    </div>
                    
                </div>
                <div class="mt-4">
                    <p class=" text-center whitespace-pre-line text-justify">{{ truncateText(post.newsPost.content, 19) }} 
                        <Link :href="route('fullPost.show',{page:'news', id:post.newsPost.id})">
                            <span class="text-blue-500">read more...</span> 
                        </Link>  
                    </p>
                    
                </div>
            </div>
            
        </div>
    </div>
    
</template>

<script setup>
import {computed} from 'vue'
import { truncateText } from '../../Functions/Methods.vue';
import {Link} from '@inertiajs/vue3'

const post =  defineProps({
    newsPost:Object,
})

function dateCreated (createdAt){
    
    const postDate = new Date(createdAt)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

    return formattedDate;
}



</script>