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
    <!-- <div class="flex  justify-center  ">
        
        <div class="w-[90%] lg:w-[80%] border mt-2 mb-4">You are here: {{ currentUrl }}</div>
    </div> -->
    
    <!-- <div class="flex justify-center mt-2"> -->
        
        <!-- <div class=" w-[90%] lg:w-[80%]  max-h-[200px] md:max-h-[400px] lg:max-h-[720px]   overflow-hidden  "> -->
            <!-- <WebCarouselLatest :image="carouselImages" :loggedUser="user"/> -->
            <!-- <WebCarousel :loggedUser="user" :carouselImages="carouselImages" /> -->
        <!-- </div> -->
    <!-- </div> -->

    <!--NEW CAROUSEL-->
    <div class="flex justify-center overflow-hidden">
      <div class="w-[90%] lg:w-[86%] mt-10  max-h-[200px] md:max-h-[400px] lg:max-h-[1020px]  flex justify-center ">
        <Carousel :value="data.carouselImages" :numVisible="1" :numScroll="1" :responsiveOptions="responsiveOptions" circular :autoplayInterval="3000">
          <template #item="slotProps">
              <div class="border-1 surface-border border-round  w-[100%] flex justify-center items-center object-cover ">
                  <div class="mb-3  w-[90%] ">
                      <img :src="'/storage/'+slotProps.data.filename" :alt="slotProps.data.name" class="w-full h-full shadow-md max-h-[500px]  " />
                  </div>
              </div>
          </template>
        </Carousel>
      </div>
    </div>
    <!--NEW CAROUSEL-->
     
    <!--divider-->
    <hr>
   <div>
    
   </div>
    <div class="flex justify-center w-full mt-4">
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


const products = ref(null)
const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '1199px',
        numVisible: 3,
        numScroll: 1
    },
    {
        breakpoint: '767px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '575px',
        numVisible: 1,
        numScroll: 1
    }
]);

const data =  defineProps({
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
    allowOutsideClick:false,
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