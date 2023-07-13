<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">Add New Post</span>  
        </div>
        title
        content
        attachment
        <form @submit.prevent="submit">
            <div class="grid grid-cols-12   gap-4 w-full mt-12 ">
                <div class="w-full col-span-12 ">
                    <div class="pb-5 text-[18px] ">Title:</div>
                    <span class="p-float-label ">
                        <InputText id="title" v-model="form.title" class="w-full"/>
                        <label for="title">Enter post title</label>
                    </span>
                    <!-- <InputError :error="form.errors.fName"/> -->
                </div>

                <div class="w-full col-span-12 ">
                    <div class="pb-5 text-[18px]">Content:</div>
                    <span class="p-float-label ">
                    <Textarea v-model="form.content" rows="5" cols="50" class="w-full"  />
                    <label for="title">Enter your post content here</label>
                    </span>
                    <!-- <InputError :error="form.errors.fName"/> -->
                </div>

                <!--IMAGE UPLOAD-->
                <div class="pb-5 text-[18px]">Image:</div>
                <div class="border border-red-300 border-2  col-span-12 p-2">
                    <div class="w-full bg-red-200 my-1">
                        <input id="test-id" type="file" multiple @input="addImage" accept="image/jpeg" placeholder="lskdjfsdf"/>
                        
                        <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress> -->
                        <!-- <div v-if="imageErrors.includes('this image')"><InputError :error="'Image file type must be in jpg,png format. Maximum size: 3mb'" /></div> -->
                    </div>
                    <div class="flex gap-3">
                        <div v-for="(image,index) in form.images" :key="image.name" class="flex flex-row my-2">
                            <div>
                                <img :src="imageUrl[index]" alt="Image" class="w-[100px] h-[100px] rounded-md"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--VIDEO UPLOAD-->
                <div class="pb-5 text-[18px]">Video:</div>
                <div class="flex flex-col col-span-12 border border-red-300">
                    <div class="w-full bg-red-200 my-1">
                        <!-- <input id="test-id" type="file"  @input="addVideo" accept="video/mp4"  /> -->
                        <FileUpload mode="basic" name="demo[]" url="./upload.php" accept="video/*" :maxFileSize="35000000" @input="addVideo" />
                        <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress> -->
                        <!-- <div v-if="imageErrors.includes('this image')"><InputError :error="'Image file type must be in jpg,png format. Maximum size: 3mb'" /></div> -->
                    </div>
                    <div class="flex justify-center items-center">
                        
                        <div v-if="videoUrl" id="video-container">
                            <video :src="videoUrl" controls class="w-[500px] h-full"  ></video>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="w-full col-span-12">
                    <Button label="Reset" class="w-full " type="reset" @click="reset"/>
                </div>
                <div class="w-full col-span-12">
                    <Button label="Submit" class="w-full " type="submit"/>
                </div>
            </div>
        </form>
    </DashboardLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import {ref} from 'vue'


const user = usePage().props.user;


const form = useForm({
    author_id:user.id,
    subject_id:user.subject_id,
    title:null,
    content:null,
    status:'public',
    images:[],
    video:null,
    created_by:user.id,
})

// temporary image address...
const imageUrl = ref([]);
const videoUrl = ref();
//at image input
const addImage = (event)=>
{
    for(const image of event.target.files)
    {
        form.images.push(image);
        imageUrl.value.push(URL.createObjectURL(image));
    }
    console.log(imageUrl);
}

//at video input
const addVideo = (event)=>
{
    const video = event.target.files[0]
    form.video = video;
    videoUrl.value = URL.createObjectURL(video);
    
    console.log(videoUrl);
    console.log('im here');
}



//reset the images in the form
const reset = ()=> {
    form.reset('images')
    form.reset('video')
    videoUrl.value = null;
    imageUrl.value = [];
};

//const resetVideo = ()=> form.reset('video');





// at form submit
const submit = () => {
    form.post(route('webPost.store'),{ onSuccess: ()=> form.reset('images')})
    
} ;


</script>