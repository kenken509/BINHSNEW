<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">Add New Post</span>  
        </div>
        <div v-if="$page.props.flash.success" hidden>{{ reloadPage() }}</div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12   gap-4 w-full mt-12 ">
                <div class="w-full col-span-12 ">
                    <div class="pb-5 text-[18px] ">Title:</div>
                    <span class="p-float-label ">
                        <InputText id="title" v-model="form.title" class="w-full"/>
                        <label for="title">Enter post title</label>
                    </span>
                    
                    <div v-if="form.errors.title">
                        <InputError :error="form.errors.title"/>
                    </div>
                    
                </div>
                relod: {{ reload }}
                <div class="w-full col-span-12 ">
                    <div class="pb-5 text-[18px]">Content:</div>
                    <span class="p-float-label ">
                    <Textarea v-model="form.content" rows="5" cols="50" class="w-full"  />
                    <label for="title">Enter your post content here</label>
                    </span>
                    <div v-if="form.errors.content">
                        <InputError :error="form.errors.content"/>
                    </div>
                </div>

                <!--ATTACHMENTS CONTAINER-->
                <div class="col-span-12 md:col-span-3">
                    <label > Attachments :  </label>
                    
                </div>
                <!--IMAGE UPLOAD-->
                <div v-if="selectedAttachment && (selectedAttachment.name === 'Image')" class="col-span-12">
                    
                    <div class="border border-gray-300 border border-2 rounded-md border-gray-400 col-span-12 px-2 py-2">
                       

                        <div class="grid grid-cols-12 gap-3  items-center ">
                            <div v-for="(image,index) in existingImage" :key="image.name" class="flex justify-between w-full py-2 col-span-12 md:col-span-4 border border-gray-300 rounded-md shadow-md bg-gray-200" >
                                <div class="flex justify-between w-full  px-2">
                                    <img :src="appUrl+image.filename" alt="Image" class="w-[200px] h-[200px] rounded-md border border-2 border-gray-400 shadow-lg "/>
                                    <div class="flex flex-col justify-center mr-4">
                                        <Link :href="route('attachment.delete',{id: image.id })" as="button" method="delete" class="mb-2 p-4 border rounded-md bg-red-600 text-gray-300 hover:bg-red-700 hover:text-white ">Delete</Link>
                                        <button class="mt-2 p-4 border rounded-md bg-green-600 text-gray-300 hover:bg-green-700 hover:text-white">Update</button>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="fileError(errorsArray, 'images').length">
                           <InputError :error="'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb'"/>
                        </div>
                    </div>
                </div>
                
                <!--VIDEO UPLOAD-->
                <div v-if="selectedAttachment && (selectedAttachment.name === 'Video')" class="col-span-12">
                   
                    <div class="flex flex-col col-span-12  border-gray-300 border border-2 rounded-md border-gray-400 px-2 py-2">
                        <div class="w-full  my-1 py-2  border-b-2 border-gray-300">
                            <input id="test-id" type="file" multiple @input="addVideo" accept="video/mp4" required />
                            <div v-if="videoSizeError"><InputError :error="videoSizeError"/></div>
                            <div v-if="fileError(errorsArray, 'video').length">
                                <InputError :error="'The video file must ba a file of type: mp4, with a max size of 35mb'"/>
                            </div>
                        </div>
                        <div class="flex justify-center items-center   p-2">
                            
                            <div v-if="videoUrl" id="video-container">
                                <video :src="videoUrl" controls class="w-[500px] h-full"  ></video>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                
                <!--ATTACHMENTS CONTAINER-->    
                <!-- <div class="w-full col-span-12 mt-4">
                    <Button label="Reset" class="w-full " type="reset" @click="reset"/>
                </div> -->
                <div class="w-full col-span-12 mt-4">
                    <Button label="Submit" class="w-full " type="submit"/>
                </div>
            </div>
        </form>
    </DashboardLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import {ref, computed, onMounted} from 'vue'
import InputError from '../../../../GlobalComponent/InputError.vue'
import {Link} from '@inertiajs/vue3'

const postToEdit = defineProps({
    post:Object,
})
const appUrl = 'http://127.0.0.1:8000/storage/';
const user = usePage().props.user;
const deleteConfirm = usePage().props.flash.success;
const del = ref('');
function reloadPage(){
    
    location.reload()
}

const existingImage = ref([]);
const attachments = [
    {
        'name': 'None'
    },
    {
        'name': 'Image'
    },
    {
        'name': 'Video'
    }
]

const selectedAttachment = ref(postToEdit.post.attachments.length === 0 ? {'name':'None'} : {'name': postToEdit.post.attachments[0].type});
const errorsArray = computed(()=> Object.values(form.errors));
const fileError = (arr, word) => {
    return arr.filter( element => element.includes(word));
}


const form = useForm({
    author_id:user.id,
    attachment: null,
    subject_id:user.subject_id,
    title:postToEdit.post.title,
    content:postToEdit.post.content,
    status:'active',
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
        console.log(image.name);
        // form.images.push(image);
        // imageUrl.value.push(URL.createObjectURL(image));
    }
    console.log(imageUrl);
}

const videoSizeError = ref();
const videoSize = ref();
//at video input
const addVideo = (event)=>
{
    //console.log(event.target.files[0].size);
    videoSize.value = event.target.files[0].size;
    if(event.target.files[0].size > 35000000){
       videoSizeError.value = 'The video file must ba a file of type: mp4, with a max size of 35mb'
       
    }
    else
    {
        videoSizeError.value = '';
        const video = event.target.files[0]
        form.video = video;
        videoUrl.value = URL.createObjectURL(video);
    }
    
    
}



//reset the images in the form
const reset = ()=> {
    console.log(selectedAttachment.value);
    form.reset('images')
    form.reset('video')
    videoUrl.value = null;
    imageUrl.value = [];
};

//const resetVideo = ()=> form.reset('video');

const reload = ref(false)
if (reload.value) {
        location.reload();
    } 
onMounted(()=>{
   
   
    if(postToEdit.post.attachments.length)
    {
        if(postToEdit.post.attachments[0].type === 'Image')
        {
            postToEdit.post.attachments.forEach(image => {
                
                existingImage.value.push(image);
                
            });
        }
    }
});


// at form submit
const submit = () => {
    
    if(videoSize.value > 35000000)
    {
        console.log('oversized video');
    }
    else
    {
        form.post(route('instructorWebPost.store'),{ onSuccess: ()=> form.reset('images')})
    }
} ;


</script>