<template>
        <div class=" flex justify-center">
        
        <WebNavLayout :currentUser="user">
        
        </WebNavLayout>
  
        </div>

        <div class="flex justify-center mt-[68px]">
            <div class="w-full max-h-[500px] overflow-hidden ">
                <WebHeaderLayout/> 
            </div>
        </div>
        
        <div v-for="post in web.posts" :key="post.id" class="flex justify-center mt-[68px] mx-[300px]">
            
            <div class="w-full bg-red-100">{{ post.title }}</div>
            <div v-if="post.attachments.length && post.attachments[0].type === 'Image' ">
                <img :src="'../storage/'+post.attachments[0].filename" alt="error"> <!-- src="http://127.0.0.1:8000\storage\Images\4PHYE8BacPVq8SVX8CLDM8bh2IZuiL0yQT1PazbF.png" -->
            </div>
            <div v-else>hindi picture</div>
        </div>
</template>

<script setup>
import WebNavLayout from '../../WebComponent/WebNavLayout.vue'
import WebHeaderLayout from '../../WebComponent/WebHeaderLayout.vue'
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue';


const user = usePage().props.user
const web = defineProps({
    posts: Array,
});

const BASE_URL =  ref('http://127.0.0.1:8000');

</script>