<template>
    <div>
        <div class="  border border-2 border-gray-300 p-8 bg-gray-100 shadow-md my-8 rounded-md">
           
            <div class="flex flex-col mb-2">
                <span class="text-[24px] font-extrabold font-serif">{{ post.post.title }}</span>
                <span class="text-[12px] text-gray-500 ">{{ dateCreated(post.post.created_at) }}</span>
            </div>
            <div class="">
                <div class=" border bg-black ">
                    <div v-if="post.post.filename !== null" class="flex justify-center " >
                        <img :src="'/storage/'+post.post.filename" alt="error" class=" shadow-md"> 
                    </div>
                </div>
                <div class="mt-4">
                    <p class=" text-justify whitespace-pre-line text-justify">{{ post.post.content }}</p>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script setup>

const post = defineProps({
    post:Object
})

function dateCreated (id){
    let dateString;

    dateString = post.post.created_at

    const postDate = new Date(dateString)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

    return formattedDate;
}
</script>