<template>
        <div class=" flex justify-center">
            <WebNavLayout :currentUser="user" />
        </div>

        <div class="flex justify-center mt-[68px] ">
            <div class="w-full max-h-[500px] overflow-hidden ">
                <WebHeaderLayout/> 
            </div>
        </div>
        <div class=" mb-4 ">
            <WebTracksCard :webPosts="web.posts"/>
        </div>
        <WebFooter />
</template>

<script setup>
import WebNavLayout from '../../WebComponent/WebNavLayout.vue'
import WebHeaderLayout from '../../WebComponent/WebHeaderLayout.vue'
import WebTracksCard from '../../WebComponent/WebTracksCard.vue'
import WebFooter from '../../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue';




const user = usePage().props.user
const web = defineProps({
    posts: Array,
});



</script>