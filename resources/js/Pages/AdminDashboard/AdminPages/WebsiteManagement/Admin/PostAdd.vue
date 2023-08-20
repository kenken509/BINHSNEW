<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Post Page</span>  
        </div>
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="grid grid-cols-12">
                
                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                    <h1 class="mb-4">Page</h1>
                    <Dropdown  v-model="selectedPage" :options="pages" optionLabel="name" placeholder="Select page" class="w-full md:w-14rem" />
                    <!-- <InputError :error="form.errors.region"/> -->
                </div>
                <!--About Page-->
                <div v-if="pagesToAdd === 'About'" class="col-span-12">
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

                <!--Contacs Page-->
                <div v-if="pagesToAdd === 'Contacts'" class="col-span-12">
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

                <!--Downloads Page-->
                <div v-if="pagesToAdd === 'Downloads'" class="col-span-12">
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
                            
                            <Dropdown  v-model="selectedAttachment" :options="attachmentOption" optionLabel="name" placeholder="Select media" class="w-full md:w-14rem " @change="handleSelectedAttachment"/>
                            
                            <!--Media Attachment-->
                            <div v-if="selectedAttachment && selectedAttachment.name === 'Image'" class="mt-4">
                                <label for="imageAttachment" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                                    Select image file... 
                                </label>
                                <div v-if="downloadPageImageValidator" class="mt-2">
                                    <InputError :error="downloadPageImageValidator" />
                                </div>
                                <div v-if="imageUrl" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                                    <h1 class="">{{ downloadAddImageFileName }}</h1> 
                                    <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                        <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteImage" ></i>
                                    </div>
                                </div>
                                <input type="file" accept="image/*" hidden id="imageAttachment" @input="downloadAddImage"/>
                                <div v-if="imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md mt-2" >
                                    <img :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                                </div>
                            </div>

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
                                <input  type="file"  id="installerInput"  @input="addFile" accept=".zip, .rar, .7z" hidden  ref="fileInputRef" />
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

                <!--News Page-->
                <div v-if="pagesToAdd === 'News'" class="col-span-12">
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
                            <h1 class="mb-6">Image: </h1>
                            <div class="px-2 py-3 border-2 border-gray-300 rounded-md"> 
                                <label for="fileInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                                    Select a file... 
                                </label>
                                <div v-if="imageUrl" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                                    <h1 class="">{{ attachmentFileName }}</h1> 
                                    <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                        <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteImage" ></i>
                                    </div>
                                </div>
                                <input  type="file"  id="fileInput" multiple @input="addImage" accept="image/*" hidden  ref="fileInputRef"/>
                            </div>
                           
                            
                           
                          
                        </div>
                        <div v-if="imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md" >
                            <img :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                        </div>
                        
                        <!--image-->
                        
                        <div class="w-full mt-4">
                            <Button label="Submit" class="w-full " type="submit" />
                        </div>
                    </div>
                </div>
            
            </div>
        </form>
    </DashboardLayout>
    
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import InputError from '../../../../GlobalComponent/InputError.vue';
import { usePage,useForm } from '@inertiajs/vue3';
import {ref, computed} from 'vue';

const user = usePage().props.user
const selectedPage = ref(null);
const selectedAttachment = ref(null);
const attachmentOption = ref([
    {'name':'Image'},
    {'name':'Video'},
])


const handleSelectedAttachment = ()=>{
    form.image = null
    imageUrl.value = null
    form.video = null
    videoUrl.value = null
}

const pages = ref([
    {
        name: 'About'
    },
    {
        name: 'Contacts'
    },
    {
        name: 'Downloads'
    },
    {
        name: 'News'
    },
])

const pagesToAdd = computed(()=>{

    if(selectedPage.value !== null)
    {
        return selectedPage.value.name;
    }
    
})

const imageUrl = ref(null);
const attachmentFileName = ref('');
const addImage = (event)=>{
    
    form.image = event.target.files[0]
    attachmentFileName.value = event.target.files[0].name
    imageUrl.value = URL.createObjectURL(event.target.files[0]);

    //console.log(imageUrl);
}

const downloadAddImageFileName = ref('');
const downloadAddImage = (event)=>{
    downloadAddImageFileName.value = event.target.files[0].name;
    form.image = event.target.files[0];
    form.media = 'image';
    imageUrl.value = URL.createObjectURL(event.target.files[0]);
}

const downloadAddVideoFileName = ref('');
const videoUrl = ref('')
const downloadAddVideo = (event)=>{
    downloadAddVideoFileName.value = event.target.files[0].name
    form.video = event.target.files[0]
    form.media = 'video';
    videoUrl.value = URL.createObjectURL(event.target.files[0]);
}

const deleteVideo = ()=>{
    downloadAddVideoFileName.value = ''
    form.video = ''
    videoUrl.value = ''
    form.media = ''
}

const installerFileName = ref('');
const addFile = (event)=>{
    //console.log(event.target.files[0]);
    
    installerFileName.value = event.target.files[0].name;
    form.installer = event.target.files[0];
    console.log(form.installer)
}

const deleteFile = () => {
    form.installer = '';
    installerFileName.value = '';
}

const deleteImage = () => {
    form.image = '';
    imageUrl.value = '';
    downloadAddImageFileName.value = '';
    form.media = '';
}


const form = useForm({
    name:null,
    phoneNumber:null,
    email:null,
    title: null,
    content: null,
    page:pagesToAdd,
    media:null,
    image:null,
    video:null,
    installer:null,
})

const validationError = ref('');
const downloadPageImageValidator = ref('');
const downloadPageVideoValidator = ref('');
const installerValidator = ref('');

const submit = ()=>{

    if(selectedPage.value.name === 'About')
    {
        
        form.post(route('webPost.store'));
    }
    else if(selectedPage.value.name === 'Contacts')
    {
        if(form.phoneNumber !== null || form.email !== null)
        {
            form.post(route('webPost.store'));
        }
        else
        {
            validationError.value = 'Contact number or Email is required';
        }
    }
    else if(selectedPage.value.name === 'Downloads')
    {
        const allowedExtensions = /\.(zip|rar|7z)$/i;

        if(selectedAttachment.value)
        {
            if(selectedAttachment.value.name === 'Image')
            {
            
                // has image
                if(!form.image)
                {
                    downloadPageImageValidator.value = ' Image field is required! Image must have a file type of JPG or PNG with maximum size of 3mb.'
                }
                else
                {
                    if(form.image.type === 'image/jpeg' || form.image.type === 'image/png')
                    {
                        if(form.image.size > 3000000)
                        {
                            // throw an error
                            downloadPageImageValidator.value = ' Image field is required! Image must have a file type of JPG or PNG with maximum size of 3mb.'
                        }
                        else
                        {
                            if(!form.installer)
                            {
                                installerValidator.value = 'Installer field is required! Installer must have a file type of .zip .rar .7z.'
                            }
                            else
                            {
                                if(allowedExtensions.test(form.installer.name))
                                {
                                    form.post(route('webPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                                }
                                else
                                {
                                    installerValidator.value = 'Installer field is required! Installer must have a file type of .zip .rar .7z.' 
                                }
                            }
                        }

                    }
                }  
            }

            if(selectedAttachment.value.name === 'Video')
            {
                if(!form.video)
                {
                    downloadPageVideoValidator.value = 'Video field is required! Video must have a file type of MP4 with maximum size of 30mb.'
                }
                else
                {
                    if(form.video.type === 'video/mp4' && form.video.size <= 30000000)
                    {
                        
                        if(!form.installer)
                        {
                            installerValidator.value = 'Installer field is required! Installer must have a file type of .zip .rar .7z.'
                        }
                        else
                        {
                            if(allowedExtensions.test(form.installer.name))
                            {
                                form.post(route('webPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                            }
                            else
                            {
                                installerValidator.value = 'Installer field is required! Installer must have a file type of .zip .rar .7z.' 
                            }
                        }
                    }
                    else
                    {
                        downloadPageVideoValidator.value = 'Video field is required! Video must have a file type of MP4 with maximum size of 30mb.'
                    }
                }
            }
        }
        else
        {
            //check if installer is not empty
            
            if(!form.installer)
            {
                installerValidator.value = 'Installer field is required! Installer must have a file type of .zip .rar .7z.'
            }
            else
            {
                console.log(form.installer);
                if(allowedExtensions.test(form.installer.name))
                {
                    form.post(route('webPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
                }
                else
                {
                    installerValidator.value = 'Installer field is required! Installer must have a file type of .zip .rar .7z.' 
                }
                
            }
            
        }
    }
    else if(selectedPage.value.name === 'News')
    {
        form.post(route('webPost.store'));
    }
};
</script>