<template>
    <div class=" flex justify-center">
        <WebNavLayout2 :currentUser="user" />
    </div>
    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>

    <div class="flex  justify-center mt-5 w-full paragraph">
        
        <div class="w-[95%] md:w-[90%] lg:w-[80%]">
            <WebTracksFullViewCard :post="web.post"/>
        </div>
    </div>
    
    <WebFooter></WebFooter>
   
</template>

<script setup>
import WebFullViewCard from '../../WebComponent/WebFullViewCard.vue'
import WebNavLayout2 from '../../WebComponent/WebNavLayout2.vue'
import WebHeaderLayout from '../../WebComponent/WebHeaderLayout.vue'
import WebFooter from '../../WebComponent/WebFooter.vue'
import { usePage } from '@inertiajs/vue3'
import WebTracksFullViewCard from '../../WebComponent/WebTracksFullViewCard.vue'

const user = usePage().props.user

const web = defineProps({
    post: Array,
});



</script>