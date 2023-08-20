<template>
    <div class=" flex justify-center">
        <WebNavLayout2 :currentUser="user" />
    </div>
    <div class="flex justify-center  ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
    <div class="flex  justify-center   w-full   paragraph bg-gray-200 ">
        <div  class="w-[95%] md:w-[90%] lg:w-[80%] ">
            <WebDownloadsCard :contents="web.posts" :postPage="'downloads'"/>
        </div>
    </div>
    
    <WebFooter></WebFooter>
</template>


<script setup>
import WebDownloadsCard from '../WebComponent/WebDownloadsCard.vue'
import WebNavLayout2 from '../WebComponent/WebNavLayout2.vue'
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