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

                <!--installer file-->
                <div class="w-full  my-1   py-2">
                    <h1 class="mb-6">Attachment: </h1>
                    
                    <Dropdown  v-model="selectedAttachment" :options="attachmentOption" optionLabel="name" placeholder="Select media" class="w-full md:w-14rem " @change="handleSelectedAttachmentChange"/>
                    <span class="text-red-500 font-extrabold">last update ok na ung attachment sa Image..installer naman </span>
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
                            Select video file... 
                        </label>
                        <div v-if="downloadPageVideoValidator" class="mt-2">
                            <InputError :error="downloadPageVideoValidator" />
                        </div>

                        <div v-if="videoUrl" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                            <h1 class="">{{ downloadAddVideoFileName }}</h1> 
                            <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteVideo" ></i>
                            </div>
                        </div>
                        <input type="file" accept="video/mp4" hidden id="videoAttachment" @input="downloadAddVideo"/>
                        <div v-if="videoUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md mt-2" >
                            <video :src="videoUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative" controls/>
                        </div>
                    </div>
                    <!--video attachment-->

                    <!--Media Attachment-->

                    <div class="mt-8 ">
                        <h1 class="mb-2">Installer:</h1>
                        <label for="installerInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                            Select a file... 
                        </label>
                        
                        <div v-if="installerFileName" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                            <h1 class="">{{ installerFileName }}</h1> 
                        <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteFile" ></i>
                            </div>
                        </div>
                        <input  type="file"  id="installerInput" multiple @input="addFile" accept=".exe" hidden  ref="fileInputRef" />
                        <div v-if="installerValidator" class="mt-2">
                            <InputError :error="installerValidator" />
                        </div>
                        
                    </div>
                    
                </div>
                <!-- <div v-if="imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md" >
                    <img :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                </div> -->
                
                <!--image-->
                <hr class="my-4 border-t-2 border-gray-400">
                <div class="w-full mt-4">
                    <Button label="Submit" class="w-full " type="submit" />
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
import { usePage,useForm } from '@inertiajs/vue3';
import {ref, computed, onMounted} from 'vue';
import { toLowerFirst,toUpperFirst } from '../../../../Functions/Methods.vue'

const user = usePage().props.user
const appUrl = 'http://127.0.0.1:8000/storage/';
const web = defineProps({
    post:Object,
    webPage:Object,
})

const attachmentOption = ref([
    {'name':'Image'},
    {'name':'Video'},
])

const existingImage = ref(null);
const selectedAttachment = ref({'name':null});
onMounted(()=>{
    existingImage.value = web.post.filename ? web.post.filename : web.post.mediaFileName;
    selectedAttachment.value.name = toUpperFirst(web.post.mediaType)
    
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
    installer:null
})

const deleteImage = ()=>{
    form.image = null;
    form.mediaType = null;
    existingImage.value = null;
    attachmentFileName.value = null;
    imageUrl.value = null;
    selectedAttachment.value = null;
}

const imageUrl = ref(null);
const attachmentFileName = ref(null);
const addChangeImage = (event)=> {
    existingImage.value = null;
    form.image = event.target.files[0]
    form.mediaType = 'image';
    attachmentFileName.value = event.target.files[0].name
    imageUrl.value = URL.createObjectURL(event.target.files[0]);
}


function stringModifier(myString){
    let separator = '_'
    const index = myString.indexOf(separator);
    return index !== -1 ? myString.slice(index+1) : myString
}

const handleSelectedAttachmentChange = ()=>{
   
    form.image = null;
    form.mediaType = selectedAttachment.value.name;
    existingImage.value = null;
    imageUrl.value = null;
}

const imageError = ref(null);
const installerError = ref(null);
const submit = ()=> {
    // alert(selectedAttachment.value.name)
    if(web.webPage === 'Downloads')
    {
        
        if(toLowerFirst(form.mediaType) == 'image')
        {
            if(form.image)
            {
        
                if(form.image === web.post.mediaFileName)
                {
                    //existing image was not changed

                    console.log(form.installer)
                    //form.post(route('editAboutPost.store'))
                    
                }
                else
                {
                    if((form.image.type === 'image/png' && form.image.size <= 3000000) || (form.image.type === 'image/jpeg' && form.image.size <= 3000000) || (form.image.type === 'image/jpg' && form.image.size <= 3000000))
                    {
                        console.log('goods');
                        
                    }
                    else
                    {
                        imageError.value = 'Image file must be a type of : JPG or PNG! with maximum file size of 3mb'
                    }
                    
                }
               
            }
            else
            {
                imageError.value = 'Image field is required';
            }  
            form.post(route('editAboutPost.store'))
            
        }
    }
    

    //form.post(route('editAboutPost.store'))
    
};
</script>