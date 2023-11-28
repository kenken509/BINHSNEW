<template>
    <div class="flex flex-col justify-center items-center p-2 border-b-2 mb-4">
        <span>this is a test page for uploading large file in chunks </span>
        <span v-if="file">{{ file.size }}</span>
    </div>
    
    <div class="flex justify-center items-center border border-gray-500 p-2 "> 
        <input type="file" @change="handleFileChange" />
        <button @click="startUpload" class="border rounded-md bg-blue-500 p-2 text-gray-200">Start Upload</button>
    </div>

    <!-- <div class="progress-bar" v-if="form.progress !== null"> 
      <div class="progress" :style="{ width: form.progress + '%' }"></div>
      <div class="flex justify-center items-center flex-col mb-4">
        <span>{{ form.progress.toFixed(2) }}%</span>
      </div>
      
    </div> -->
    
    <div v-if="form.progress" class="flex justify-center items-center">
        <p v-if="form.progress.toFixed(2) < 100" class="text-black ">{{ form.progress.toFixed(2)  }}</p>
    </div>
    
    <div v-if="form.progress" class="flex justify-center">
      <ProgressSpinner v-if="form.progress < 100" style="width: 50px; height: 50px;" strokeWidth="4" fill="var(--surface-ground)" animationDuration="1.5s" aria-label="Custom ProgressSpinner" />
    </div>
    
</template>

<script setup>
import { ref } from 'vue';
import { useForm  } from '@inertiajs/vue3';
import axios from 'axios';



const file = ref(null);
const chunkSize = 50*1024*1024 ; // 50MB per chunks 
const handleFileChange = ()=>{
    file.value = event.target.files[0];
    form.file = file.value;
    form.totalChunks = Math.ceil(file.value.size / chunkSize);
    form.currentChunk = 0;
    form.progress = null;
    console.log(file.value);
}

const form = useForm({
  file: null,
  totalChunks: 0,
  currentChunk: 0,
  progress: 0, // Add progress property

});

const startUpload = async () => {
  if (!file.value) {
    console.error('No file selected');
    return;
  }

  const totalChunks = Math.ceil(file.value.size / chunkSize);
  form.file = file.value
  form.totalChunks = totalChunks
  console.log("file size: "+file.value.size)
  console.log("chunk size :"+chunkSize);
  console.log(totalChunks);
  

  for (let i = 0; i < totalChunks; i++) {
    form.currentChunk = i+1;

    const start = i * chunkSize;
    const end = Math.min((i + 1) * chunkSize, file.value.size);
    const chunk = file.value.slice(start, end);
     // Log information about each file chunk
    console.log(`Uploading chunk ${form.currentChunk} of ${totalChunks}`);
    console.log(`Chunk start: ${start}, Chunk end: ${end}`);
    console.log(`Chunk size: ${chunk.size} bytes`)

    uploadChunk(chunk);
  }
}

// const uploadChunk =  (chunk)=>{
    
//     form.post('/upload/chunk', {chunk,totalChunks: form.totalChunks,currentChunk: form.currentChunk,
//         onSuccess: () => {
//           console.log(`Chunk ${form.currentChunk} uploaded successfully`);
//         },
//         onError: (errors) => {
//           console.error('Error uploading chunk:', errors);
//         },
//     });
    
// }

const uploadChunk = async (chunk) => {
  try {
    const response = await axios.post('/upload/chunk', chunk, {
      headers: {
        'Content-Type': 'application/octet-stream', // Set the content type appropriately
      },
      params: {
        totalChunks: form.totalChunks,
        currentChunk: form.currentChunk,
        originalFilename: file.value.name, // Pass the original filename
      },
      onUploadProgress: (progressEvent) => {
        // Calculate the progress percentage
        const progress = (form.currentChunk - 1 + progressEvent.loaded / chunk.size) / form.totalChunks * 100;
        form.progress = progress;
      },
    });
    
    console.log('server response: '+JSON.stringify(response.data, null, 2));

    //console.log(`Chunk ${form.currentChunk} uploaded successfully`);
  } catch (error) {
    console.error('Error uploading chunk:', error);
  }
};

</script>

<style scoped>
.progress-bar {
  margin-top: 10px;
  height: 20px;
  width: 100%;
  border: 1px solid #ccc;
  position: relative;
}

.progress {
  height: 100%;
  width: 0;
  background-color: #4caf50;
}

span {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #fff;
}


</style>