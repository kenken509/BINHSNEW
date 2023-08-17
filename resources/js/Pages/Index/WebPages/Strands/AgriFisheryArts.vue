<template>
    <div class=" flex justify-center">
        <WebNavLayout2 :currentUser="user"  />
    </div>

    <div class="flex justify-center  ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
    <div class=" mb-4 ">
        <WebTracksCard :webPosts="web.posts" :page="'afa'"/>
    </div>
    <WebFooter />
</template>

<script setup>

import WebHeaderLayout from '../../WebComponent/WebHeaderLayout.vue'
import WebTracksCard from '../../WebComponent/WebTracksCard.vue'
import WebFooter from '../../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue';
import WebNavLayout2 from '../../WebComponent/WebNavLayout2.vue'



const user = usePage().props.user
const web = defineProps({
    posts: Array,
});



</script>