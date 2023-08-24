<template>
    
    <div class=" flex justify-center">
        
            <WebNavLayout2 :currentUser="user"  >
           
            </WebNavLayout2>
      
    </div>
    
    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
  
    <!--divider-->
    <div class=" h-[40px] border shadow-md "></div>
    <div class="flex  justify-center  ">
        <div v-if="$page.props.flash.success" class="j bg-green-300 mb-2 p-2 rounded-md text-gray-600 w-[90%] lg:w-[80%] border mt-2 mb-4">{{ $page.props.flash.success  }} </div>
    </div>
   
    <!--you are here-->
    <div class="flex  justify-center  ">
        
        <div class="w-[90%] lg:w-[80%] border mt-2 mb-4">You are here: {{ currentUrl }}</div>
    </div>
    
    <div class="flex justify-center">
        
        <div class=" w-[90%] lg:w-[80%]  max-h-[200px] lg:max-h-[720px]   overflow-hidden  ">
            <WebCarousel :carouselImages="carouselImages" :loggedUser="user"/>
            <!-- <WebCarousel :loggedUser="user" :carouselImages="carouselImages" /> -->
        </div>
    </div>
    
    <!--divider-->
    <div class=" h-[40px]   shadow-md"></div>
    
    <div class="flex justify-center mt-4 ">
        <div class="w-[90%] lg:w-[80%]">
            <WebCard :cardContent="cardContent"/>
        </div>
    </div>
    <div class="flex mt-4 w-full ">
        <div class="flex justify-center items-center  overflow-hidden  ">
            <WebFooter />
        </div>

    </div>
    
</template>

<script setup>
import WebCarouselLatest from './WebComponent/WebCarouselLatest.vue';
import WebNavLayout2 from './WebComponent/WebNavLayout2.vue';
import WebNavLayout from './WebComponent/WebNavLayout.vue';
import { computed } from '@vue/reactivity';
import {  usePage } from '@inertiajs/vue3';
import WebHeaderLayout from './WebComponent/WebHeaderLayout.vue'
import WebCarousel from './WebComponent/WebCarousel.vue';
import WebFooter from './WebComponent/WebFooter.vue';
import WebCard from './WebComponent/WebCard.vue';
import WebAbout from './WebComponent/WebAbout.vue';
import { ref, onMounted, onUnmounted } from 'vue'


defineProps({
    currentUrl:String,
    carouselImages:Array
})

const cardContent = {
    
    imageSrc:'./images/webPage/about1.jpg',
    content: 'YOU MAY LEARN MORE ABOUT BULIHAN NATIONAL INTEGRATED NATIONAL HIGH SCHOOL BY VISITING THE PAGE',
    buttnTitle: 'About Us',
    linkRoute: "route('show.about')",
    
}

const user = computed(() => usePage().props.user);
const clicked = ref(false)

const handleClick = ()=>{
    clicked.value = true
}

onMounted(()=>{
    document.addEventListener('click', handleClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleDocumentClick);
});

const replaceImage = ()=>{

}
</script>