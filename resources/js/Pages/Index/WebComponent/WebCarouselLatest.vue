<template>
    <Swiper
      class="border-b-2 border-t-2 cursor-grab border-gray-500 w-[100%] m-auto p-4  " 
      :modules="modules"
      :space-between="28"
      :loop="true"
      :pagination="{ clickable: true }"
      :autoplay="{
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      }"
    >
      <swiper-slide
        v-for="(carouselImage, index) in images.image"
        :key="index"
        class="pb-4 sm:flex sm:justify-evenly  "
      >
          <img :src="'/storage/'+carouselImage.filename" alt="error"  class="w-[100%] max-h-[200px] md:max-h-[400px] lg:max-h-[600px] object-cover"/>
        
      </swiper-slide>
    </Swiper>
  </template>
  
  <script setup>
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import { Autoplay, Pagination } from 'swiper/modules';
  import 'swiper/css';
  import 'swiper/css/pagination';
  import { ref } from 'vue';
  

  const images = defineProps({
    image:Array
  })
  const swiperTextBase = ref([
    {
      author: 'elon musk',
      description: 'wher something is important enogh, you do it even if odds are not in your favor.',
      image: '/images/webPage/carousel1.jpg',
    },
    {
      author: 'Aries musk',
      description: 'wher something is important enogh, you do it even if odds are not in your favor.',
      image: '/images/webPage/carousel2.jpg',
    },
    {
      author: 'elon musk',
      description: 'wher something is important enogh, you do it even if odds are not in your favor.',
      image: '/images/webPage/carousel3.png',
    },
  ]);
  
  const modules = [Pagination, Autoplay];


  
  </script>
  
  <style scoped>
/* Define the aspect ratio for the container */
.aspect-ratio-container {
  position: relative;
  overflow: hidden;
}

/* Define the aspect ratio using padding-top */
.aspect-ratio-content {
  padding-top: 56.25%; /* 9 / 16 = 0.5625 (56.25%) for 16:9 aspect ratio */
}

/* Ensure the image fills the container */
img.object-cover {
  object-fit: cover;
}
</style>