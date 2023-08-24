<template>
  <InputError :error="imageValidationError" />

  <!--test swiper-->
  
  
  
  <!--test swiper-->
  <div
  id="carouselExampleControls"
  class="relative"
  data-te-carousel-init
  data-te-carousel-slide>
  <!--Carousel items--> 
  
  <div
  
  class="relative w-full overflow-hidden after:clear-both after:block after:content-['']">
  <!--First item-->
      
      <div
        class="relative  float-left -mr-[100%] w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none"
        data-te-carousel-item
        data-te-carousel-active>
        <div class="relative">
          <img
            :src="'/storage/'+user.carouselImages[0].filename"
            class=" w-[100%] max-h-[200px] md:max-h-[px] lg:max-h-[600px] object-cover "
            alt="Wild Landscape"
          />
          <!-- Text overlay for the first image -->
          <div v-if="user.loggedUser && user.loggedUser.role === 'admin'" class="absolute  flex justify-center items-center inset-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[35%] h-[10%]  lg:w-[15%] text-white z-50 text-[10px] lg:text-[16px]">
            <label for="image-replace1" class="file-input-label bg-green-800 px-4 py-2 rounded-md cursor-pointer font-serif">
              Replace Image
            </label>
            <input type="file" id="image-replace1" @change="replaceImage($event, user.carouselImages[0].id)" accept="image/*" hidden ref="fileInputRef"/>
          </div>
        </div> 
      </div>
  <!--Second item-->
      <div
        class="relative block float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none object-contain"
        data-te-carousel-item>
       
          <img
            :src="'/storage/'+user.carouselImages[1].filename"
            class=" w-[100%] max-h-[200px]  lg:max-h-[600px] object-cover "
            alt="Wild Landscape"
          />
          <!-- Text overlay for the first image -->
          
        
        <div v-if="user.loggedUser && user.loggedUser.role === 'admin'" class="absolute  flex justify-center items-center inset-1/2 transform -translate-x-1/2 -translate-y-1/2  w-[35%] h-[10%]  md:w-[20%]  text-white z-50 text-[10px] lg:text-[16px]">
            <label for="image-replace2" class="file-input-label bg-green-800 px-4 py-2 rounded-md cursor-pointer font-serif">
              Replace Image
            </label>
            <input type="file" id="image-replace2" @input="replaceImage($event, user.carouselImages[1].id)" accept="image/*" hidden ref="fileInputRef"/>
          </div>
      </div>
  <!--Third item-->
      <div
        class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none"
        data-te-carousel-item>
        <div class="relative">
          <img
            :src="'/storage/'+user.carouselImages[2].filename"
            class="w-[100%] max-h-[200px] lg:max-h-[600px] object-cover "
            alt="Wild Landscape"
          />
          <!-- Text overlay for the first image -->
          <div v-if="user.loggedUser && user.loggedUser.role === 'admin'" class="absolute  flex justify-center items-center inset-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[35%] h-[10%]  lg:w-[15%]  text-white z-50 text-[10px] lg:text-[16px]">
            <label for="image-replace3" class="file-input-label bg-green-800 px-4 py-2 rounded-md cursor-pointer font-serif">
              Replace Image
            </label>
            <input type="file" id="image-replace3" @input="replaceImage($event, user.carouselImages[2].id)" accept="image/*" hidden ref="fileInputRef"/>
          </div>
        </div> 
      </div>
</div>

<!--Carousel controls - prev item-->
<button
  class="absolute bottom-0 left-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none"
  type="button"
  data-te-target="#carouselExampleControls"
  data-te-slide="prev">
  <span class="inline-block h-8 w-8">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="h-6 w-6">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
  </span>
  <span
    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
    >Previous</span
  >
</button>
<!--Carousel controls - next item-->
<button
  class="absolute bottom-0 right-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none"
  type="button"
  data-te-target="#carouselExampleControls"
  data-te-slide="next">
  <span class="inline-block h-8 w-8">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="h-6 w-6">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
  </span>
  <span
    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
    >Next</span
  >
</button>
  </div>
</template>
<script setup>

import { Link,useForm,usePage } from '@inertiajs/vue3'
import {ref} from 'vue'
import InputError from '../../GlobalComponent/InputError.vue';
import {Swiper, SwiperSlide} from 'swiper/vue'



const imageValidationError = ref(null);
const form = useForm({
id:null,
filename:null,
user:user.loggedUser ? user.loggedUser.id: null,
})

function replaceImage(event,id){

const allowedExtensions = /\.(jpg|jpeg|png)$/i;


console.log(event.target.files[0].name);
form.id = id 
form.filename = event.target.files[0];

if(!allowedExtensions.test(form.filename.name) || form.filename.size > 3000000)
{
    imageValidationError.value = 'Image file must be of type: JPG, JPEG, PNG with maximum size of 3mb! ';
}
else
{
    form.post(route('carousel.replace.image'));
}

}

const user = defineProps({
 loggedUser:Object,
 carouselImages:Array,
})




</script>