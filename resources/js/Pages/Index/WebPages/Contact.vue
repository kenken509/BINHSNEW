<template>
    <div class=" flex justify-center">
        <WebNavLayout2 :currentUser="user" />
    </div>
    <div class="flex justify-center  ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
    <div class="flex justify-center w-full my-4">
        <span class="font-serif text-[30px] tracking-wider font-bold ">Contact us</span>
    </div>
    <div class="flex justify-center">
        <hr class="border border-b-1 border-gray-300 shadow shadow-md w-[90%] lg:w-[80%]">
    </div>
    
    <div class="flex flex-col justify-center mt-5 mx-[10%]">
        <div v-for="post in web.posts" :key="post.id" class="mt-5 mb-5">
            <div class="flex flex-col lg:flex-row justify-center items-center ">
                <span class="text-[20px] lg:text-[24px] font-serif ">Name:&nbsp; </span>
                <span class="text-[20px] lg:text-[24px] font-serif ">{{ post.name }}</span>
            </div>

            <div class="flex justify-center items-center">
                <span class="font-serif text-[14px] text-gray-700">Phone Number:&nbsp; </span>
                <span class="font-serif text-[14px] text-gray-700">{{ post.phoneNumber }}</span>
            </div>

            <div class="flex justify-center items-center">
                <span class="font-serif text-[14px] text-gray-700">Email:&nbsp; </span>
                <span class="font-serif text-[14px] text-gray-700"> {{ post.email }}</span>
            </div>
            <div class="flex justify-center items-center text-gray-500">
                ---
            </div>
        </div>
       
    </div>
    
    <WebFooter></WebFooter>
    <div class="flex justify-center items-center w-screen h-screen">
        <span class="text-[24px]">CONTACT PAGE: <span class="text-red-500 text-[24px]">UNDER CONSTRUCTION</span></span>
    </div>
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