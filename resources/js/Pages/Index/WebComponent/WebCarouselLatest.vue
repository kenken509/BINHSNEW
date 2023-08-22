<template>
    <Swiper
      class="border-b-2 border-t-2 cursor-grab border-gray-500 max-w-screen-lg m-auto p-4 mt-24"
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
        v-for="(text, index) in swiperTextBase"
        :key="index"
        class="pb-14 sm:flex sm:justify-evenly"
      >
        <div>
          <h1>{{ text.author }}</h1>
          <p>{{ text.description }}</p>
          <img :src="text.image" alt="error" />
        </div>
      </swiper-slide>
    </Swiper>
  </template>
  
  <script setup>
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import { Autoplay, Pagination } from 'swiper/modules';
  import 'swiper/css';
  import 'swiper/css/pagination';
  import { ref } from 'vue';
  
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
  