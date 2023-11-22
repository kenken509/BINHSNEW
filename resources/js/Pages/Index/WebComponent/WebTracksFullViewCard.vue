<template>
    <div>
       
        <div class="  border border-2 border-gray-300 p-8 bg-gray-100 shadow-md my-8 rounded-md">
            
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ post.post.title }}</span>
                <span class="text-[12px] text-gray-500 ">Author: {{ toUpperFirst(post.post.author.fName) }} {{ toUpperFirst(post.post.author.lName) }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(post.post.created_at) }}</span>
                
            </div>
            <div class="">
                
                <div v-if="post.post.attachments > 0"  class=" border bg-black ">
                    
                    <div v-if="attachmentType == 'Image'" class="flex justify-center " >
                        <img :src="'/storage/'+postImage" alt="error" class=" shadow-md"> 
                    </div>
                </div>
                <div class="mt-4">
                    <p class=" text-justify whitespace-pre-line text-justify">{{ post.post.content }}</p>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script setup>
import { toUpperFirst, truncateText } from '../../Functions/Methods.vue';
import { computed } from 'vue';

const post = defineProps({
    post:Object
})


const postImage = computed(()=>{

    return post.post.attachments[0].filename
})

const attachmentType = computed(()=>{
    return post.post.attachments[0].type
}) 

function dateCreated (id){
    let dateString;

    dateString = post.post.created_at

    const postDate = new Date(dateString)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

    return formattedDate;
}

</script>