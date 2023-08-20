<template>
    <div>
        <div v-for="content in post.contents" :key="post.id" class="border  border-gray-300 p-8 bg-gray-50 shadow-md my-8  rounded-md">
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ content.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(content.id) }}</span>
                <h1>Click here to <a class="text-blue-400" :href="'/storage/'+content.installerFileName" download> download</a> </h1>
            </div>
            <div class="">
                <div v-if="content.mediaType && content.mediaType==='image'" class="border bg-black">
                    <div  class="flex justify-center items-center">
                        <img :src="'/storage/'+content.mediaFileName" alt="error" class=" shadow-md"> 
                    </div>
                </div>
                <div v-if="content.mediaType && content.mediaType==='video'" class="border bg-black">
                    <div  class="flex justify-center items-center">
                        <video :src="'/storage/'+content.mediaFileName" alt="error" class=" shadow-md"  /> 
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