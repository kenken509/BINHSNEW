<template>
    
    <div class=" flex justify-center bg-red-200">

        <WebNavLayout2 :currentUser="user"></WebNavLayout2>
        
    </div>
    <div class="flex justify-center   ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
    
    <div class="w-full flex justify-center bg-gray-200">
        <div class="w-[95%] md:w-[90%] lg:w-[80%] ">
            <div v-for="post in web.posts" :key="post.id" class="mt-10 mb-10 border border-gray-300 shadow-md rounded-md bg-gray-50  ">
                <div class="flex justify-center py-2">
                    <span class="text-[40px] font-extrabold font-serif">{{ post.title }}</span>
                </div>
                <div class="p-5">
                    <p class=" text-justify paragraph">{{ post.content }}</p>
                </div>
                
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

<style scoped>

    .paragraph{
        white-space: pre-line;
    }

</style>