<template>
    <div>
        <div v-for="content in post.contents" :key="post.id" class="border  border-gray-300 p-8 bg-gray-50 shadow-md my-8  rounded-md">
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ content.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(content.id) }}</span>
                
                <div v-if="$page.props.user" class="flex space-x-2">
                    <h1>Click here to <a class="text-blue-400" :href="content.installerLink" target="_blank"  download @click="handleDownloadLinkClick(content.installerType)" > download</a> </h1>
                    <div v-if="content.installerType === 'android'">
                        <i class="pi pi-android text-green-500 " ></i>
                    </div>
                    <div v-else>
                        <i class="pi pi-microsoft text-blue-700 " style="font-size: 20px;"></i>
                    </div>
                </div>
                <div v-else>
                    <span class="text-red-500">Please sign in to download.</span>
                </div>
                
            </div>
            <div class="">
                <div v-if="content.mediaType && content.mediaType==='image'" class="border bg-black">
                    <div  class="flex justify-center items-center">
                        <img :src="'/storage/'+content.mediaFileName" alt="error" class=" shadow-md"> 
                    </div>
                </div>
                <div v-if="content.mediaType && content.mediaType==='video'" class="border bg-black">
                    <div  class="flex justify-center items-center">
                        <video :src="'/storage/'+content.mediaFileName" alt="error" class=" shadow-md"  /> 
                    </div>
                </div>
                <div class="mt-4">
                    <p class="  whitespace-pre-line text-justify">{{ truncateText(content.content, 19) }} 
                        <Link :href="route('fullPost.show',{page:post.postPage, id:content.id})">
                            <span class="text-blue-500">read more...</span> 
                        </Link>  
                    </p>
                   
                </div>
            </div>
            
        </div>
    </div>
    
</template>

<script setup>
import { truncateText } from '../../Functions/Methods.vue';
import {Link, useForm} from '@inertiajs/vue3'

const post =  defineProps({
    contents:Array,
    postPage:String,
})

function dateCreated (id){
    let dateString;

    post.contents.forEach((post)=>{
        if(post.id === id){
            dateString = post.created_at
        }
    })

    const postDate = new Date(dateString)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

    return formattedDate;
}

const record = useForm({
    type:'download_attempt',
    installerType:null 
})
// const handleDownloadLinkClick = (id)=>{
//     record.post(route('analytics.store'),{preserveScroll:true});
// }

async function handleDownloadLinkClick(installerType) {
  try {
        record.installerType = installerType;
        await record.post(route('analytics.store'), { preserveScroll: true });
        console.log('Visit recorded successfully!');
    } catch (error) {
        console.error('Error recording visit:', error.message);
    }
}

</script>