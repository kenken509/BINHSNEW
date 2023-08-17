<template>
    <div>
        <div v-for="content in post.contents" :id="post.id" class="border border-2 border-gray-300 p-8 bg-gray-100 shadow-md my-8  rounded-md">
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ content.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(content.id) }}</span>
            </div>
            <div class="">
                <div class="border bg-black">
                    <div v-if="content.filename !== null" class="flex justify-center items-center">
                        <img :src="'/storage/'+content.filename" alt="error" class=" shadow-md"> 
                    </div>
                </div>
                <div class="mt-4">
                    <p class=" text-center whitespace-pre-line text-justify">{{ truncateText(content.content, 19) }} 
                        <Link :href="route('fullPost.show',{page:post.postPage, id:content.id})">
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
    contents:Array,
    postPage:String,
})

function dateCreated (id){
    let dateString;

    post.contents.forEach((post)=>{
        if(post.id === id){
            dateString = post.created_at
        }
    })

    const postDate = new Date(dateString)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

    return formattedDate;
}



</script>