<template>
    <div>
      <input type="file" @change="select">
      <!-- <progress :value="progress"></progress> -->
      <button type="button" @click="upload" class="border p-2 bg-blue-600 text-gray-100">upload</button>
    </div>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { ref, computed } from 'vue';
  
  const file = ref(null);
  const chunks = ref([]);
  let uploaded = ref(0);
  
  const progress = computed(() => Math.floor((uploaded.value * 100) / file.value.size));
  
  const formData = computed(() => {
    const formData = new FormData();
    formData.set('is_last', chunks.value.length === 1);
    formData.set('file', chunks.value[0], `${file.value.name}.part`);
    return formData;
  });
  
  const config = computed(() => ({
    method: 'POST',
    data: formData.value,
    url: '/api/upload',
    headers: {
      'Content-Type': 'application/octet-stream'
    },
    onUploadProgress: event => {
      uploaded.value += event.loaded;
    }
  }));
  
  const select = (event) => {
    file.value = event.target.files[0];
    createChunks();
  };
  
  const upload = () => {
    axios(config.value).then(response => {
      chunks.value.shift();
      console.log("res: "+response);
    }).catch(error => {
      console.log(error)
    });
  };
  
  const createChunks = () => {
    const size = 2048;
    const numChunks = Math.ceil(file.value.size / size);
  
    for (let i = 0; i < numChunks; i++) {
      chunks.value.push(file.value.slice(
        i * size, Math.min(i * size + size, file.value.size), file.value.type
      ));
    }
  };

  </script>
  