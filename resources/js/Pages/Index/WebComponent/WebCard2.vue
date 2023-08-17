<template>
    <div>
        <div v-for="post in post.contents" :id="post.id" class="border border-2 p-8 bg-gray-100 shadow-md my-8">
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ post.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(post.id) }}</span>
            </div>
            <div class="">
                <div class="border ">
                    <div v-if="post.filename !== null" >
                        <img :src="'/storage/'+post.filename" alt="error" class="rounded-md shadow-md"> 
                    </div>
                </div>
                <div class="mt-4">
                    <p class=" text-center whitespace-pre-line text-justify">{{ post.content }} </p>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {computed} from 'vue'

const post =  defineProps({
    contents:Array,
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