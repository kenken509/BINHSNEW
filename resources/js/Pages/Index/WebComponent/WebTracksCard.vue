<template>
    <div class="w-full flex flex-col justify-center ">
        <div v-for="post in data.webPosts" :key="post.id" class="border border-2 border-gray-300 p-8 bg-gray-100 shadow-md my-8  rounded-md">
                    
            <div class=" flex flex-col mb-2">
                <div class="w-full  text-[30px] text-gray-800 font-serif mb-2">
                    {{ toUpperFirst(post.title)  }}
                </div>
                
                <div class="text-[12px] text-gray-400 ">
                    Author: {{ toUpperFirst(post.author.fName)  }} {{ toUpperFirst(post.author.lName)  }}
                </div>

                <div class="mb-2">
                    <span class="text-[12px] text-gray-400 "> {{ dateCreated(post.id) }}</span>
                </div>
            </div>
            <div>
                <div v-if="post.attachments.length && post.attachments[0].type === 'Image' " >
                    <img :src="'../storage/'+post.attachments[0].filename" alt="error" class="border  rounded-md shadow-gray-900 shadow-md"> 
                </div>

                <div v-if="post.attachments.length && post.attachments[0].type === 'Video'">
                    <video :src="'../storage/'+post.attachments[0].filename" controls class="border  rounded-md" ></video>
                </div>
                
                <div class=" whitespace-pre-line mt-4">
                    <p class="flex text-justify px-4">
                        {{ toUpperFirst(truncateText(post.content,10)) }} 
                        <Link :href="route('fullPost.show',{page:page, id:post.id})">
                            <span class="text-blue-500">read more...</span> 
                        </Link>
                    </p>
                    <div class="border border-t-black  border-x-transparent border-b-transparent pt-4 flex justify-between">
                        <i class="pi pi-thumbs-up-fill" style="color: slateblue; font-size: 1.25rem;"> 300  </i>
                        <i class="pi pi-thumbs-up hover:cursor-pointer" style="font-size: 1.25rem;" @click="()=>toggleLike(post.id)"> like</i>
                    </div>
                    
                </div>
            </div>
                
        </div>
    </div>
</template>

<script setup>
import {toUpperFirst} from '../../Functions/Methods.vue'
import {truncateText} from '../../Functions/Methods.vue'
import {Link, useForm} from '@inertiajs/vue3'

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

const form = useForm({
    web_post_id:null,
    type:'like',
})

function toggleLike(webPost){
    form.web_post_id = webPost
    form.post(route('post.toggleLike'),{preserveScroll:true});
};
</script>