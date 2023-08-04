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
        <div v-for="post in web.posts" :key="post.id" class="mt-5 mb-5">
           
            <div class="flex justify-center">
                <span class="text-[24px] font-extrabold">{{ post.title }}</span>
            </div>
            <div class="px-5">
                <div>
                    <p class=" text-center">{{ post.content }} </p>
                    
                    <div v-if="post.filename !== null">
                        <img :src="'http://127.0.0.1:8000/storage/'+post.filename" alt="error"> 
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    
    <WebFooter></WebFooter>
    <div class="flex justify-center items-center w-screen h-screen">
        <span class="text-[24px]">CONTACT PAGE: <span class="text-red-500 text-[24px]">UNDER CONSTRUCTION</span></span>
    </div>
    <div class="flex justify-center items-center w-screen h-screen">
        <span class="text-[24px]">NEWS PAGE: <span class="text-red-500 text-[24px]">UNDER CONSTRUCTION</span></span>
    </div>
</template>

<script setup>
import WebNavLayout from '../WebComponent/WebNavLayout.vue'
import WebHeaderLayout from '../WebComponent/WebHeaderLayout.vue'
import WebTracksCard from '../WebComponent/WebTracksCard.vue'
import WebFooter from '../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue';

const user = usePage().props.user

const web = defineProps({
    posts: Array,
});


</script>