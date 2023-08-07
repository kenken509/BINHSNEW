<template>
    <div class=" flex justify-center">
        <WebNavLayout :currentUser="user" />
    </div>
    <div class="flex justify-center mt-[68px] ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
    <div class="flex flex-col justify-center mt-5 mx-[10%]">
        <div v-for="post in web.posts" :key="post.id" class="mt-10 mb-10">
            <div class="flex justify-center">
                <span class="text-[40px] font-extrabold">{{ post.title }}</span>
            </div>

            <div class="px-5">
                <p class=" text-center">{{ post.content }}</p>
            </div>
            <div v-if="post.mediaType === 'image'">
                <img :src="appUrl+post.mediaFileName" alt="error"/>
            </div>  

            <div v-if="post.mediaType === 'video'">
                <video :src="appUrl+post.mediaFileName" alt="error" controls/>
            </div>
            <h1>Click here to <a class="text-blue-400" :href="appUrl+post.installerFileName" download> download</a> </h1>
        </div>
    </div>
    
    <WebFooter></WebFooter>
</template>


<script setup>
import WebNavLayout from '../WebComponent/WebNavLayout.vue'
import WebHeaderLayout from '../WebComponent/WebHeaderLayout.vue'
import WebTracksCard from '../WebComponent/WebTracksCard.vue'
import WebFooter from '../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import { ref,computed } from 'vue';

const user = usePage().props.user
const appUrl = 'http://127.0.0.1:8000/storage/';
const web = defineProps({
    posts: Array,
});



</script>