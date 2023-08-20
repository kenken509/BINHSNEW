<template>
    <div class=" flex justify-center">
        <WebNavLayout2 :currentUser="user" />
    </div>
    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
 
    <div class="flex  justify-center mt-5 w-full paragraph ">
        <div class="  border border-2 border-gray-300 p-8 bg-gray-100 shadow-md my-8 rounded-md w-[95%] md:w-[90%] lg:w-[80%]">
        
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ post.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(post.id) }}</span>
                <h1>Click here to <a class="text-blue-400" :href="'/storage/'+post.installerFileName" download> download</a> </h1>
                <!-- <span class="text-[12px] text-gray-500 ">{{ dateCreated(post.post.created_at) }}</span> -->
            </div>
            <div class="">
                <div class=" border bg-black ">
                    <div v-if="post.mediaType && post.mediaType === 'image'" class="flex justify-center " >
                        <img :src="'/storage/'+post.mediaFileName" alt="error" class=" shadow-md"> 
                    </div>
                    <div v-if="post.mediaType && post.mediaType === 'video'" class="flex justify-center " >
                        <video :src="'/storage/'+post.mediaFileName" alt="error" class=" shadow-md"/> 
                    </div>
                </div>
                <div class="mt-4">
                    <p class=" text-justify whitespace-pre-line text-justify">{{ post.content }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <WebFooter></WebFooter>
   
</template>

<script setup>
import WebFullViewCard from '../../WebComponent/WebFullViewCard.vue'
import WebNavLayout2 from '../../WebComponent/WebNavLayout2.vue'
import WebHeaderLayout from '../../WebComponent/WebHeaderLayout.vue'
import WebTracksCard from '../../WebComponent/WebTracksCard.vue'
import WebFooter from '../../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue';

const user = usePage().props.user

const web = defineProps({
    post: Array,
});

function dateCreated (id){
    let dateString;
    dateString = web.post.created_at

    const postDate = new Date(dateString)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

    return formattedDate;
}


</script>