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
    
    <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
    <div v-if="$page.props.flash.error" >{{ errorMessage($page.props.flash.error) }} </div>
    
   
    <!--you are here-->
    <div class="flex  justify-center  ">
        
        <div class="w-[90%] lg:w-[80%] border mt-2 mb-4">You are here: {{ currentUrl }}</div>
    </div>
    
    <div class="flex justify-center">
        
        <div class=" w-[90%] lg:w-[80%]  max-h-[200px] md:max-h-[400px] lg:max-h-[720px]   overflow-hidden  ">
            <!-- <WebCarouselLatest :image="carouselImages" :loggedUser="user"/> -->
            <WebCarousel :loggedUser="user" :carouselImages="carouselImages" />
        </div>
    </div>
    
    <!--divider-->
    <div class=" h-[40px] border shadow-md "></div>
    <div class="flex justify-center w-full">
        <div class="flex justify-center mt-8 w-[90%] lg:w-[80%]">
            <span class="font-serif text-[30px] lg:text-[50px] tracking-wider  text-gray-800 ">Latest News</span>
        </div>
    </div>
    
    <div class="flex justify-center  ">
        <div class="w-[90%] lg:w-[80%]">
           <IndexCard :newsPost="newsPost"/>
        </div>
    </div>
    <div class=" h-[40px] border shadow-md "></div>
    <div class="flex mt-4 w-full ">
        <div class="flex justify-center items-center  overflow-hidden  ">
            <WebFooter />
        </div>

    </div>
    
</template>

<!-- <script setup>
import IndexCard from './IndexComponent/IndexCard.vue';
import WebNavLayout2 from './WebComponent/WebNavLayout2.vue';
import Swal from 'sweetalert2';
import { computed } from '@vue/reactivity';
import {  useForm, usePage } from '@inertiajs/vue3';
import WebHeaderLayout from './WebComponent/WebHeaderLayout.vue'
import WebCarousel from './WebComponent/WebCarousel.vue';
import WebFooter from './WebComponent/WebFooter.vue';
import { router } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted, onBeforeUnmount  } from 'vue'


defineProps({
    currentUrl:String,
    carouselImages:Array,
    newsPost:Object,
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

const currentSchoolYear = ref(null);
const currentMonth = ref(null);

const form = useForm({
    year:null,
});

/* const submit = ()=>{
     console.log('submitted');
     form.post(route('schoolYear.store'));
 } */

onMounted(()=>{
    document.addEventListener('click', handleClick)
    window.addEventListener('beforeunload', cleanup);
    document.addEventListener('visibilitychange', cleanup);
    const isFirstVisit = checkFirstVisit();

    if (isFirstVisit) {
        // Record the new visit to the Laravel backend
        recordVisitOnBackend();
    } else {
        // It's a refresh, do nothing or perform necessary actions
    }

    if (!sessionStorage.getItem('firstVisit')) {
        localStorage.setItem('firstVisit', 'true');
        sessionStorage.setItem('firstVisit', 'true');
    }
    
})

const cleanup = () => {
    // if(isTabClosing())
    // {
    //     localStorage.removeItem('firstVisit');
    // }
    if (document.visibilityState === 'hidden') {
        localStorage.removeItem('firstVisit');
    }
};

onBeforeUnmount(() => {
  // Cleanup tasks, such as clearing local storage
  
  window.removeEventListener('beforeunload', cleanup);
  //cleanup();
});

const isRefreshEvent = () => {
    // Check if the navigation is due to a refresh
    return performance.navigation.type === performance.navigation.TYPE_RELOAD;
};

const isTabClosing = () => {
    const navigationType = performance.navigation.type;

    // Check if the navigation is not a regular reload, back/forward, or navigate action
    return navigationType !== performance.navigation.TYPE_RELOAD &&
           navigationType !== performance.navigation.TYPE_BACK_FORWARD &&
           navigationType !== performance.navigation.TYPE_NAVIGATE;
};

function successMessage(message)
{
    Swal.fire({
        title:'Success',
        text:message+'!',
        icon:'success',
        allowOutsideClick:false,
        allowEscapeKey:false
    }).then((result)=>{
        if(result.isConfirmed)
        {
            flashClear.get(route('clear.flash.messages'), {preserveScroll:true});
        }
    })
}

const flashClear = useForm({
    clear:null,
})

function errorMessage(message)
{
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: message+'!',
        
    }).then((result)=>{
        if(result.isConfirmed)
        {
            flashClear.get(route('clear.flash.messages'), {preserveScroll:true});
        }
    })
}

const checkFirstVisit = () => {
  return !localStorage.getItem('firstVisit');
};

const recordVisitOnBackend = () => {
  
    router.post(route('analytics.store'),{preserveScroll:true}); 
  // Set 'firstVisit' key in localStorage
  localStorage.setItem('firstVisit', 'true');
};
</script> -->

<script setup>
import IndexCard from './IndexComponent/IndexCard.vue';
import WebNavLayout2 from './WebComponent/WebNavLayout2.vue';
import Swal from 'sweetalert2';
import { computed } from '@vue/reactivity';
import { useForm, usePage } from '@inertiajs/vue3';
import WebHeaderLayout from './WebComponent/WebHeaderLayout.vue'
import WebCarousel from './WebComponent/WebCarousel.vue';
import WebFooter from './WebComponent/WebFooter.vue';
import { router } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount } from 'vue'

defineProps({
  currentUrl: String,
  carouselImages: Array,
  newsPost: Object,
})

const user = computed(() => usePage().props.user);
const clicked = ref(false)

const handleClick = () => {
  clicked.value = true
}


onMounted(() => {
  document.addEventListener('click', handleClick);

  const isFirstVisit = sessionStorage.getItem('firstVisit');
  

  if (!isFirstVisit) {
    // If it's the first visit, set the variable to true and store it in sessionStorage
    sessionStorage.setItem('firstVisit', 'true');

    // Store information in the database (simulated asynchronous operation)
    // Replace this with your actual database integration logic
    recordVisit();
  }
})

function successMessage(message) {
  Swal.fire({
    title: 'Success',
    text: message + '!',
    icon: 'success',
    allowOutsideClick: false,
    allowEscapeKey: false
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}

const flashClear = useForm({
  clear: null,
})

const record = useForm({
    type:'visit',
})

function errorMessage(message) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: message + '!',
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}

const checkFirstVisit = () => {
  return !localStorage.getItem('firstVisit');
};

async function recordVisit() {
  try {
        await record.post(route('analytics.store'), { preserveScroll: true });
        console.log('Visit recorded successfully!');
    } catch (error) {
        console.error('Error recording visit:', error.message);
    }
}

</script>