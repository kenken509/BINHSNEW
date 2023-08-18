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
                    {{ updateForm.errors.image }}
                </div>
                
                <!--IMAGE UPLOAD-->
                <div v-if="selectedAttachment && (selectedAttachment.name === 'Image')" class="col-span-12">
                    
                    <div class="border border-gray-300 border border-2 rounded-md border-gray-400 col-span-12 px-2 py-2">
                        <div class="  mb-4 mt-2">
                            <label for="addNewImage" class="cursor-pointer bg-[#4338CA] hover:bg-indigo-700 hover:text-white py-3 px-3 border border-blue-500 shadow-md rounded-md text-gray-100">Add Image...</label>
                            <input id="addNewImage" type="file" accept="image/*" @input="addNewImage($event)"  hidden/>
                        </div>
                        
                        <div class="grid grid-cols-12 gap-3  items-center ">
                            <div v-for="(image,index) in existingImage" :key="image.name" class="flex justify-between w-full py-2 col-span-12 md:col-span-4 border border-gray-300 rounded-md shadow-md bg-gray-200" >
                                <div class="flex justify-between w-full  px-2">
                                    <img :src="appUrl+image.filename" alt="Image" class="w-[200px] h-[200px] rounded-md border border-2 border-gray-400 shadow-lg "/>
                                    <div class="flex flex-col justify-center mr-4">
                                        
                                        <Link v-if="postToEdit.post.attachments.length > 1" :href="route('attachment.delete',{id: image.id })" as="button" method="delete" class="mb-2 p-4 border rounded-md bg-red-600 text-gray-300 hover:bg-red-700 hover:text-white ">Delete</Link>
                                        <label for="imageUpdate" class="mt-2 p-4 border rounded-md bg-green-600 text-gray-300 hover:bg-green-700 hover:text-white cursor-pointer">Update</label>
                                        <input id="imageUpdate" type="file" accept="image/*" @input="updateImage($event, image.id, image.filename)" hidden />
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
                        <div class="flex flex-col w-full  my-1 py-2  border-b-2 border-gray-300">
                            <label for="addVideo" class=" cursor-pointer bg-[#4338CA] hover:bg-indigo-700 hover:text-white py-3 px-3 border border-blue-500 shadow-md rounded-md text-gray-100 mb-2 md:w-[128px]">Replace file...</label>
                            <input id="addVideo" type="file"  @input="updateVideo($event,postToEdit.post.attachments[0].id )" accept="video/mp4"  hidden/>
                            <div v-if="videoSizeError"><InputError :error="videoSizeError"/></div>
                            <div v-if="fileError(errorsArray, 'video').length">
                                <InputError :error="'The video file must ba a file of type: mp4, with a max size of 35mb'"/>
                            </div>
                            <div v-if="$page.props.errors.video"><InputError :error="$page.props.errors.video"/></div>
                        </div>
                        <div class="flex justify-center items-center   p-2">
                            
                            <div v-if="postToEdit.post.attachments" id="video-container">
                                <video :src="appUrl+videoUrl" controls class="w-[500px] h-full"  ></video>
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






// temporary image address...
const imageUrl = ref([]);
const videoUrl = ref(postToEdit.post.attachments.length ? postToEdit.post.attachments[0].filename: null); //postToEdit.post.attachments[0].filename
//at image input
// const addImage = (event)=>
// {
//     for(const image of event.target.files)
//     {
//         console.log(image.name);
//         // form.images.push(image);
//         // imageUrl.value.push(URL.createObjectURL(image));
//     }
//     console.log(imageUrl);
// }

// image update logics ************************

const updateImage = (event, imageId, imageFilename) => {
    
   // Your code to update the image goes here
   updateForm.imageId = imageId;
   updateForm.image = event.target.files;
   updateForm.existingFilename = imageFilename

   updateForm.post(route('attachment.image.update'), {
        preserveScroll: true,
        onSuccess: () => {updateForm.reset('image', 'imageId', 'existingFilename')},
   })
}

const addNewImage = (event) => {
    
    addImageForm.image = event.target.files;
    
    addImageForm.post(route('attachment.addNewImage.update'),{
        preserveScroll: true,
        onSuccess: () => {updateForm.reset('image')},
    })
}

const addImageForm = useForm({
    type:'image',
    web_post_id:postToEdit.post.id,
    image:null,
})

const updateForm = useForm({
    imageId:null,
    existingFilename:null,
    image:null,
})
// image update logics ************************





// video update logics ************************
const videoSizeError = ref();
const videoSize = ref();

const updateVideoForm = useForm({
    id:null,
    video:null,
});
const updateVideo = (event, videoId)=>
{
    //console.log(event.target.files[0].size);
    videoSize.value = event.target.files[0].size;
    if(event.target.files[0].size > 35000000){
       videoSizeError.value = 'The video file must ba a file of type: mp4, with a max size of 35mb'
       
    }
    else
    {
        updateVideoForm.id = videoId;
        updateVideoForm.video = event.target.files[0];

        updateVideoForm.post(route('attachment.video.update'), {
            preserveScroll: true,
            onSuccess: () => {updateForm.reset('image')},
        });
    }
    
    
}
// video update logics ************************


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

const form = useForm({
    id: postToEdit.post.id,
    author_id:user.id,
    subject_id:user.subject_id,
    title:postToEdit.post.title,
    content:postToEdit.post.content,
    updated_by:user.id,
    
})

// at form submit
const submit = () => {
    
    if(videoSize.value > 35000000)
    {
        console.log('oversized video');
    }
    else if(postToEdit.post.attachments.length < 1)    
    {   
        console.log('must have at least 1 image');
    }
    else
    {
        form.post(route('instructorWebPost.update'),{ onSuccess: ()=> form.reset('images')})
    }
} ;


</script>