<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">Add New Post</span>  
        </div>
        
        <form @submit.prevent="addPostConfirmation">
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
                    <label > Attachment : </label>
                    <Dropdown  v-model="selectedAttachment" :options="attachments" optionLabel="name" placeholder="None" class="w-full md:w-14rem " @change="reset"/>
                </div>
                <!--IMAGE UPLOAD-->
                <div v-if="selectedAttachment && (selectedAttachment.name === 'Image')" class="col-span-12">
                    
                    <div class="border border-gray-300 border border-2 rounded-md border-gray-200 col-span-12 px-2 py-2">
                        <div class="w-full  my-1   py-2">
                            <label for="fileInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                                Select a file...
                            </label>
                            <input  type="file"  id="fileInput" multiple @input="addImage" accept="image/*" hidden  ref="fileInputRef"/>
                            <!-- <FileUpload mode="basic" multiple name="imageUpload" @input="addImage" accept="image/jpeg" :maxFileSize="1000000" /> -->
                            <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress> -->
                            
                           
                            
                        </div>

                        <div v-if="form.images.length" class="flex gap-3 flex-wrap border border-2 border-gray-400 shadow-md p-4 rounded-md">
                            <div v-for="(image,index) in form.images" :key="image.name" class="py-2" >
                                <div>
                                    <div class="relative border border-gray-400 rounded-md shadow-md ">
                                        <img :src="imageUrl[index]" alt="Image" class="w-[100px] h-[100px] rounded-md relative"/>
                                        <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                            <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteImage(index)" ></i>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="fileError(errorsArray, 'images').length">
                           <InputError :error="'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb'"/>
                        </div>
                        <div v-if="$page.props.flash.error" ><InputError :error="$page.props.flash.error"/></div>
                    </div>
                </div>
                
                <!--VIDEO UPLOAD-->
                <div v-if="selectedAttachment && (selectedAttachment.name === 'Video')" class="col-span-12">
                   
                    <div class="flex flex-col col-span-12  border-gray-300 border border-2 rounded-md border-gray-400 px-2 py-2">
                        <div class="w-full  my-1 py-2   border-gray-300">
                            <label for="videoInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                                Select a file...
                            </label>
                            <input id="videoInput" type="file" multiple @input="addVideo" accept="video/mp4" hidden  />
                            
                            
                        </div>
                        <div class="flex flex-col justify-center items-center border  border-gray-300 rounded-md p-2">
                            
                            <div v-if="videoUrl" id="video-container" >
                                <video :src="videoUrl" controls class="w-[500px] h-full border border-gray-300 shadow-md rounded-md"  ></video>
                                
                            </div>
                            <div>
                                <div v-if="videoSizeError"><InputError :error="videoSizeError"/></div>
                                <div v-if="fileError(errorsArray, 'video').length" >
                                    <InputError :error="'The video file must ba a file of type: mp4, with a max size of 35mb'"/>
                                </div>
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
import {ref, computed} from 'vue'
import InputError from '../../../../GlobalComponent/InputError.vue'
import Swal from 'sweetalert2';


const user = usePage().props.user;
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

const selectedAttachment = ref(null);
const errorsArray = computed(()=> Object.values(form.errors));
const fileError = (arr, word) => {
    return arr.filter( element => element.includes(word));
}


const form = useForm({
    author_id:user.id,
    attachment: selectedAttachment,
    subject_id:user.subject_id,
    title:null,
    content:null,
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
        form.images.push(image);
        imageUrl.value.push(URL.createObjectURL(image));
    }
    // Reset the file input
    const fileInputRef = $refs.fileInputRef;
    if (fileInputRef) {
        fileInputRef.value = null;
    }
    console.log(imageUrl);
}
const deleteImage = (index)=>{
    form.images.splice(index, 1);
    imageUrl.value.splice(index, 1);
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

// alert codes

function addPostConfirmation()
{
    Swal.fire({
        title:'Add New Post',
        text:'Are you sure?',
        icon:'question',
        showCancelButton:true,
        cancelButtonText:'Cancel',
        allowOutsideClick:false,
        confirmButtonText:'Yes,add new post!',

    })
}

</script>