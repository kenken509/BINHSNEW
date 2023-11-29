<template>
   <DashboardLayout :user="user">
    <div class="border-bot-only border-gray-600 shadow-md mb-4">
        <span class="text-[20px] font-bold text-gray-500">Edit Post Page</span> 
        {{ web.webPage }}
    </div>
    <!--About Page-->
    
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <!--About page-->
        <div v-if="web.webPage === 'About'" class="col-span-12">
            <div class="flex flex-col">
                <label for="title" >Title:</label>
                <InputText id="title" v-model="form.title" class="w-full" required/>
            </div>

            <div>
                <label for="content" >Content:</label>
                <Textarea v-model="form.content" rows="5" cols="50" class="w-full" id="content" required/>
            </div>

            <div class="w-full mt-4">
                <Button label="Submit" class="w-full " type="submit" />
            </div>
        </div>
        <!--About page-->

        <!--Contacts page-->
        <div v-if="web.webPage === 'Contacts'" class="col-span-12">
            <div>
                <div class="flex flex-col">
                    <h1 class="mb-6">Name: </h1>
                    <span class="p-float-label">
                        <InputText id="name" v-model="form.name" class="w-full" required/>
                        <label for="name" >Enter contact name...</label>
                        </span>
                </div>

                <div class="flex flex-col mt-4">
                    <h1 class="mb-6">Contact #:</h1>
                    <span class="p-float-label">
                        <InputNumber v-model="form.phoneNumber" inputId="withoutgrouping" :useGrouping="false"  id="phoneNumber" class="w-full"/>
                        <label for="phoneNumber">Phone number...</label>
                    </span>
                </div>
                <div class="mt-4">
                    <h1 class="mb-6">Email:</h1>
                    <span class="p-float-label">
                        <InputText id="email" v-model="form.email" class="w-full" type="email"/>
                        <label for="email">email address..</label>
                    </span>
                </div>
                <InputError :error="validationError"/>
            
                <div class="w-full mt-4">
                    <Button label="Submit" class="w-full " type="submit" />
                </div>
            </div>
        </div>
        <!--Contacts page-->

        <!--News Page-->
        <div v-if="web.webPage === 'News'" class="col-span-12">
            <div>
                <div class="flex flex-col">
                    <h1 class="mb-6">Title: </h1>
                    <span class="p-float-label">
                        <InputText id="name" v-model="form.title" class="w-full" required/>
                        <label for="name" >Enter news title...</label>
                        </span>
                </div>

                <div class="mt-4">
                    <h1 class="mb-6">Content: </h1>
                    <span class="p-float-label">
                        <Textarea v-model="form.content" rows="5" cols="50" class="w-full" id="newsContent" required/>
                        <label for="newsContent" >Enter news content</label>
                    </span>
                </div>

                <!--image-->
                <div class="w-full  my-1   py-2">
                    <h1 class="mb-6">Attachment: </h1>
                    <label for="fileInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                        Select a file... 
                    </label>
                    <div v-if="existingImage" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                        <h1 class="">{{ stringModifier(existingImage)  }}</h1> 
                        <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                            <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteImage" ></i>
                        </div>
                    </div>
                    <div v-else class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md">
                        <h1 class="">{{ attachmentFileName  }}</h1> 
                        <div v-if="attachmentFileName" class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                            <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteImage" ></i>
                        </div>
                    </div>
                    <input  type="file"  id="fileInput" multiple @input="addChangeImage" accept="image/*" hidden  ref="fileInputRef"/>
                    
                </div>

                <div v-if="existingImage" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md" >
                    <img :src="appUrl+existingImage" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                </div>
                <div v-if="imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md">
                    <img :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                </div>
                <!--image-->
                
                <div class="w-full mt-4">
                    <Button label="Submit" class="w-full " type="submit" />
                </div>
            </div>
        </div>
        <!--News Page-->

        <!--Download page-->
        <div v-if="web.webPage === 'Downloads'" class="col-span-12">
            <div>
                <div class="flex flex-col">
                    <h1 class="mb-6">Title: </h1>
                    <span class="p-float-label">
                        <InputText id="name" v-model="form.title" class="w-full" required/>
                        <label for="name" >Enter downloads title...</label>
                        </span>
                </div>

                <div class="mt-4">
                    <h1 class="mb-6">Content: </h1>
                    <span class="p-float-label">
                        <Textarea v-model="form.content" rows="5" cols="50" class="w-full" id="downloadsContent" required/>
                        <label for="downloadsContent" >Enter downloads content</label>
                    </span>
                </div>
                
                <div class="flex flex-col">
                    <h1 class="mb-6">Installer Link: </h1>
                    
                    <span class="p-float-label">
                        <InputText id="installerLink" v-model="form.installerLink" class="w-full" required/>
                        <label for="installerLink" >Enter downloads link...</label>
                    </span>
                    <div v-if="installerValidator" class="mt-2">
                            <InputError :error="installerValidator" />
                    </div>
                    <div v-if="isLoading">
                        <TestLinkLoadingSpinner :installerLink="form.installerLink"/>
                    </div>
                    
                </div>
                <!--installer file-->
                <div class="w-full  my-1   py-2">
                    <h1 class="mb-6">Attachment: </h1>
                    
                    <Dropdown  v-model="selectedAttachment" :options="attachmentOption" optionLabel="name" placeholder="Select media" class="w-full md:w-14rem " @change="handleSelectedAttachmentChange"/>
                    
                    <!--Image Attachment-->
                    <div v-if="selectedAttachment && selectedAttachment.name === 'Image'" class="mt-4">
                        <label for="imageAttachment" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                            Select image file...
                        </label>
                        
                        <div v-if="existingImage || attachmentFileName" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                            <h1 v-if="existingImage" class="">{{ stringModifier(existingImage) }}</h1> 
                            <h1 v-if="attachmentFileName" class="">{{ attachmentFileName }}</h1> 
                            <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteImage" ></i>
                            </div>
                        </div>
                        <div v-if="imageError" class="mt-2">
                            <InputError :error="imageError" />
                        </div>
                        <input type="file" accept="image/*" hidden id="imageAttachment" @input="addChangeImage"/>
                        <div v-if="existingImage || imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md mt-2" >
                            <img v-if="existingImage" :src="appUrl+existingImage" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                            <img v-if="imageUrl" :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                        </div>
                        
                    </div>
                    <!--Image Attachment-->

                    <!--video attachment-->
                    <div v-if="selectedAttachment && selectedAttachment.name === 'Video'" class="mt-4">
                        <label for="videoAttachment" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                            Select video file... {{ form.video }}
                        </label>
                        
                        <div v-if="existingVideo || attachmentFileName" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                            <h1 v-if="existingVideo" class="">{{ stringModifier(existingVideo) }}</h1>
                            <h1 v-if="attachmentFileName" class="">{{ attachmentFileName }}</h1>  
                            <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteVideo" ></i>
                            </div>
                        </div>

                        <div v-if="videoError" class="mt-2">
                            <InputError :error="videoError" />
                        </div>
                        <input type="file" accept="video/mp4" hidden id="videoAttachment" @input="addChangeVideo"/>
                        <div v-if="existingVideo || videoUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md mt-2" >
                            <video v-if="existingVideo" :src="appUrl+existingVideo" alt="Error" class="w-[50%] h-[50%] rounded-md relative" controls/>
                            <video v-if="videoUrl" :src="videoUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative" controls/>
                        </div>
                    </div>
                    <!--video attachment-->

                    <!--Media Attachment-->


                    <!--Installer-->
                    <!-- <div class="mt-8 ">
                        <h1 class="mb-2">Installer:</h1>
                        <label for="installerInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                            Select a file...
                        </label>
                        
                        <div v-if="existingInstaller || newInstaller" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                            <h1 v-if="existingInstaller" class="">{{ stringModifier(existingInstaller)}}</h1> 
                            <h1 v-if="newInstaller" class="">{{ newInstaller }}</h1> 
                        <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteInstaller" ></i>
                            </div>
                        </div>
                        <input  type="file"  id="installerInput" multiple @input="addChangeInstaller" accept=".exe" hidden  ref="fileInputRef" />
                        <div v-if="installerError" class="mt-2">
                            <InputError :error="installerError" />
                        </div>
                        
                    </div> -->
                    <!--Installer-->
                    
                </div>
                <!-- <div v-if="imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md" >
                    <img :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                </div> -->
                
                <!--image-->
                
                <hr class="my-4 border-t-2 border-gray-400">
                <div class="w-full mt-4">
                    <Button label="Submit" class="w-full " :disabled="form.processing" type="submit" />
                </div>
            </div>
        </div>
        <!--Download page-->
    </form>

   </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import InputError from '../../../../GlobalComponent/InputError.vue';
import TestLinkLoadingSpinner from '../../../../GlobalComponent/TestLinkLoadingSpinner.vue';
import { usePage,useForm } from '@inertiajs/vue3';
import {ref, computed, onMounted} from 'vue';
import { toLowerFirst,toUpperFirst } from '../../../../Functions/Methods.vue'
import axios from 'axios';

const user = usePage().props.user
const appUrl = 'http://127.0.0.1:8000/storage/';
const web = defineProps({
    post:Object,
    webPage:String,
})

const attachmentOption = ref([
    {'name':'Image'},
    {'name':'Video'},
])

const existingImage = ref(null);
const existingVideo = ref(null);
const existingInstaller = ref(null);
const selectedAttachment = ref({'name':null});
onMounted(()=>{
    existingImage.value = web.post.filename ? web.post.filename : web.post.mediaFileName;
    selectedAttachment.value.name = web.post.mediaType ? toUpperFirst(web.post.mediaType) : null;
    existingInstaller.value = web.post.installerFileName;
    existingVideo.value = web.post.mediaFileName;
})

const form = useForm({
    id:web.post.id,
    page:web.webPage,
    title:web.post.title,
    content:web.post.content,

    name:web.post.name,
    phoneNumber:web.post.phoneNumber,
    email:web.post.email,

    mediaType:web.post.mediaType,
    image:web.post.filename ? web.post.filename: web.post.mediaFileName,
    video:web.post.filename ? web.post.filename: web.post.mediaFileName,
    installer:web.post.installerFileName,
    installerLink:web.post.installerLink,
})

const deleteImage = ()=>{
    form.image = null;
    form.mediaType = null;
    existingImage.value = null;
    attachmentFileName.value = null;
    imageUrl.value = null;
    selectedAttachment.value = null;
}

const deleteVideo = ()=> {
    form.video = null;
    form.mediaType = null;
    existingVideo.value = null;
    videoUrl.value = null;
    selectedAttachment.value = null;
    
}
const deleteInstaller = ()=>{
    existingInstaller.value = null;
    form.installer = null;
}

const imageUrl = ref(null);
const videoUrl = ref(null);
const attachmentFileName = ref(null);

const addChangeImage = (event)=> {
    existingImage.value = null;
    form.image = event.target.files[0]
    form.mediaType = 'image';
    attachmentFileName.value = event.target.files[0].name
    imageUrl.value = URL.createObjectURL(event.target.files[0]);
}

const addChangeVideo = ()=>{
    existingVideo.value = null;
    form.video = event.target.files[0];
    form.mediaType = 'video';
    attachmentFileName.value = event.target.files[0].name;
    videoUrl.value = URL.createObjectURL(event.target.files[0]);
}

const newInstaller = ref(null);
const addChangeInstaller = (event)=>{
    existingInstaller.value = null;
    newInstaller.value = event.target.files[0].name;
    form.installer = event.target.files[0];
}

function stringModifier(myString){
    let separator = '_'
    const index = myString.indexOf(separator);
    return index !== -1 ? myString.slice(index+1) : myString
}

const handleSelectedAttachmentChange = ()=>{
   
    form.image = null;
    form.video = null;
    form.mediaType = selectedAttachment.value.name;
    existingImage.value = null;
    existingVideo.value = null;
    imageUrl.value = null;
    videoUrl.value = null;
    attachmentFileName.value = null;
}

const imageError = ref(null);
const installerError = ref(null);
const installerValidator = ref(null);
const videoError = ref(null);
const isLoading = ref(false);
const submit = ()=> {
    // alert(selectedAttachment.value.name)
    
    // Regular expression to match Google Drive download links
    const googleDriveRegex = /^https:\/\/drive\.google\.com\/.*$/;
    const googleDriveLinkStatus = ref(null);
    

    if(web.webPage === 'Downloads')
    {
        console.log('media attachment: '+form.mediaType)
        if(form.mediaType === null)
        {

            // check if the installer link isa a valid googledrive link
            // check if the link is providing a file for download
            if(!form.installerLink)
            {
                installerValidator.value = 'Installer Link Field is required!'
            }
            else
            {
                
                async function validate(){
                    if(googleDriveRegex.test(form.installerLink))
                    {
                        try{
                            isLoading.value = true;
                            await testGoogleDriveLink();

                            console.log(googleDriveLinkStatus)
                            if(!googleDriveLinkStatus.value)
                            {
                                isLoading.value = false;
                                installerValidator.value = "The system cannot reach your Gdrive link, please ensure to provide a working link."
                                console.log(installerValidator.value);
                            }
                            else
                            {
                                isLoading.value = false;
                                installerValidator.value = ""
                                console.log('working gdrive link');
                                form.post(route('editAboutPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                            }
                        }catch(err)
                        {
                            isLoading.value = false;
                            console.log("errrrroooorrr: "+err);
                        }  
                    }
                    else
                    {
                        isLoading.value = false;
                        installerValidator.value = 'Please provide a valid google drive link. ex: https://drive.google.com/your-download-link' 
                    }
                }
                validate();
                
            }

        }

        if(form.mediaType && toLowerFirst(form.mediaType) === 'image')
        {
            if(form.image)
            {
                //existing image was not changed
                if(form.image === web.post.mediaFileName)
                {
                    
                    async function validate(){
                        if(googleDriveRegex.test(form.installerLink))
                        {
                            try{
                                isLoading.value = true;
                                await testGoogleDriveLink();

                                console.log(googleDriveLinkStatus)
                                if(!googleDriveLinkStatus.value)
                                {
                                    isLoading.value = false;
                                    installerValidator.value = "The system cannot reach your Gdrive link, please ensure to provide a working link."
                                    console.log(installerValidator.value);
                                }
                                else
                                {
                                    isLoading.value = false;
                                    installerValidator.value = ""
                                    console.log('working gdrive link');
                                    form.post(route('editAboutPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                                }
                            }catch(err)
                            {
                                isLoading.value = false;
                                console.log("errrrroooorrr: "+err);
                            }  
                        }
                        else
                        {
                            isLoading.value = false;
                            installerValidator.value = 'Please provide a valid google drive link. ex: https://drive.google.com/your-download-link' 
                        }
                    }
                    validate();  
                }
                else // if image was changed
                {
                    if((form.image.type === 'image/png' && form.image.size <= 3000000) || (form.image.type === 'image/jpeg' && form.image.size <= 3000000) || (form.image.type === 'image/jpg' && form.image.size <= 3000000))
                    {
                        async function validate(){
                            if(googleDriveRegex.test(form.installerLink))
                            {
                                try{
                                    isLoading.value = true;
                                    await testGoogleDriveLink();

                                    console.log(googleDriveLinkStatus)
                                    if(!googleDriveLinkStatus.value)
                                    {
                                        isLoading.value = false;
                                        installerValidator.value = "The system cannot reach your Gdrive link, please ensure to provide a working link."
                                        console.log(installerValidator.value);
                                    }
                                    else
                                    {
                                        isLoading.value = false;
                                        installerValidator.value = ""
                                        console.log('working gdrive link');
                                        form.post(route('editAboutPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                                    }
                                }catch(err)
                                {
                                    isLoading.value = false;
                                    console.log("errrrroooorrr: "+err);
                                }  
                            }
                            else
                            {
                                isLoading.value = false;
                                installerValidator.value = 'Please provide a valid google drive link. ex: https://drive.google.com/your-download-link' 
                            }
                        }
                        validate();
                    }
                    else //sdfsdf
                    {
                        imageError.value = 'Image file must be a type of : JPG or PNG! with maximum file size of 3mb'
                    }
                    
                }
               
            }
            else
            {
                imageError.value = 'Image field is required';
            }  
        }

        if(form.mediaType && toLowerFirst(form.mediaType) === 'video')
        {
            
            if(form.video)
            {
                
                //existing video was not changed
                if(form.video === web.post.mediaFileName)
                {
                    async function validate(){
                        if(googleDriveRegex.test(form.installerLink))
                        {
                            try{
                                isLoading.value = true;
                                await testGoogleDriveLink();

                                console.log(googleDriveLinkStatus)
                                if(!googleDriveLinkStatus.value)
                                {
                                    isLoading.value = false;
                                    installerValidator.value = "The system cannot reach your Gdrive link, please ensure to provide a working link."
                                    console.log(installerValidator.value);
                                }
                                else
                                {
                                    isLoading.value = false;
                                    installerValidator.value = ""
                                    console.log('working gdrive link');
                                    form.post(route('editAboutPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                                }
                            }catch(err)
                            {
                                isLoading.value = false;
                                console.log("errrrroooorrr: "+err);
                            }  
                        }
                        else
                        {
                            isLoading.value = false;
                            installerValidator.value = 'Please provide a valid google drive link. ex: https://drive.google.com/your-download-link' 
                        }
                    }
                    validate(); 
                }
                else // if video was changed
                {
                    
                    if((form.video.type === 'video/mp4' && form.video.size <= 50000000))
                    {
                        async function validate(){
                            if(googleDriveRegex.test(form.installerLink))
                            {
                                try{
                                    isLoading.value = true;
                                    await testGoogleDriveLink();

                                    console.log(googleDriveLinkStatus)
                                    if(!googleDriveLinkStatus.value)
                                    {
                                        isLoading.value = false;
                                        installerValidator.value = "The system cannot reach your Gdrive link, please ensure to provide a working link."
                                        console.log(installerValidator.value);
                                    }
                                    else
                                    {
                                        isLoading.value = false;
                                        installerValidator.value = ""
                                        console.log('working gdrive link');
                                        form.post(route('editAboutPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                                    }
                                }catch(err)
                                {
                                    isLoading.value = false;
                                    console.log("errrrroooorrr: "+err);
                                }  
                            }
                            else
                            {
                                isLoading.value = false;
                                installerValidator.value = 'Please provide a valid google drive link. ex: https://drive.google.com/your-download-link' 
                            }
                        }
                        validate();
                    }
                    else //sdfsdf
                    {
                        videoError.value = 'Video file must be a type of : MP4! with maximum file size of 50mb'
                    }
                    
                }
            }
            else
            {
                videoError.value = 'Video field is required!'
            }
        }
        
    }
    
    //form.post(route('editAboutPost.store'))

    
    // test google drive link
    async function testGoogleDriveLink() {

        try {
        // Attempt to fetch the content of the Google Drive link
            const response = await axios.get(form.installerLink, { maxRedirects: 0 });

            // Check if the response is a redirection (3xx) to the home page
            if (response.status >= 300 && response.status < 400 && response.headers.location === 'https://drive.google.com/') {
                googleDriveLinkStatus.value = false;
                console.log(googleDriveLinkStatus.value);
                
            } else {
                //Otherwise, consider it accessible
                googleDriveLinkStatus.value = response.status >= 200 && response.status < 300;
                console.log(googleDriveLinkStatus.value);
            }
        } 
        catch (error) {
            // Handle errors, e.g., the link is not accessible
            console.error('Error testing Google Drive link: bajkket');
            googleDriveLinkStatus.value = false;
            console.log(googleDriveLinkStatus.value);
        }
    }
      
};
</script>