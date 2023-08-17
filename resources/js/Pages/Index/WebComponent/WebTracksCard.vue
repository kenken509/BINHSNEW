<template>
     <div v-for="post in data.webPosts" :key="post.id" class="flex flex-col  justify-center mt-[50px] md:mx-[250px] border border-gray-300 shadow-md rounded-md p-2 bg-gray-200">
                
            <div class="w-full  text-[30px] text-gray-800 font-serif mb-2">
                {{ toUpperFirst(post.title)  }}
            </div>
            
            <div class="text-[12px] text-gray-400 ">
                Author: {{ toUpperFirst(post.author.fName)  }} {{ toUpperFirst(post.author.lName)  }}
            </div>

            <div class="mb-2">
                <span class="text-[12px] text-gray-400 ">Date: {{ dateCreated(post.id) }}</span>
            </div>
            
            <div v-if="post.attachments.length && post.attachments[0].type === 'Image' " >
                <img :src="'../storage/'+post.attachments[0].filename" alt="error" class="border  rounded-md shadow-gray-900 shadow-md"> <!-- src="http://127.0.0.1:8000\storage\Images\4PHYE8BacPVq8SVX8CLDM8bh2IZuiL0yQT1PazbF.png" -->
            </div>

            <div v-if="post.attachments.length && post.attachments[0].type === 'Video'">
                <video :src="'../storage/'+post.attachments[0].filename" controls class="border  rounded-md"></video>
            </div>
            <div class="my-5 border-b border-2 border-gray-300">
                
            </div>
            <div class=" whitespace-pre-line">
                <p class="flex text-justify px-4">
                    {{ toUpperFirst(truncateText(post.content,10)) }} 
                    <Link :href="route('fullPost.show',{page:page, id:post.id})">
                        <span class="text-blue-500">read more...</span> 
                    </Link>
                </p>
                  
            </div>
    </div>
</template>

<script setup>
import {toUpperFirst} from '../../Functions/Methods.vue'
import {truncateText} from '../../Functions/Methods.vue'
import {Link} from '@inertiajs/vue3'

const data = defineProps({
    webPosts:Array,
    page:String,
})

function dateCreated (id){
    let dateString;

    data.webPosts.forEach((post)=>{
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