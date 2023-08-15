<template>
    
    <div class=" flex justify-center bg-red-200">

        <WebNavLayout2 :currentUser="user"></WebNavLayout2>
        
    </div>
    <div class="flex justify-center   ">
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
            
        </div>
    </div>
    
    <WebFooter></WebFooter>
</template>

<script setup>
import WebNavLayout2 from '../WebComponent/WebNavLayout2.vue'
import WebHeaderLayout from '../WebComponent/WebHeaderLayout.vue'
import WebTracksCard from '../WebComponent/WebTracksCard.vue'
import WebFooter from '../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue';

const user = usePage().props.user

const web = defineProps({
    posts: Array,
});
</script>