<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Post Page</span>  
        </div>
        <form @submit.prevent="submit">
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
                            <label for="installerInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                                Select a file... 
                            </label>
                            <div v-if="installerFileName" class="mx-2 mt-2 p-1 bg-gray-200  inline-block relative  border border-gray-300  rounded-md" >
                               <h1 class="">{{ installerFileName }}</h1> 
                               <div class="absolute right-[-7px] top-[-7px] hover:right-[-9px] hover:top-[-7px] cursor-pointer">
                                    <i class="pi pi-times-circle text-red-700 cursor-pointer hover:text-[20px]" @click="deleteFile" ></i>
                                </div>
                            </div>
                            <input  type="file"  id="installerInput" multiple @input="addFile" accept=".exe" hidden  ref="fileInputRef"/>
                          
                        </div>
                        <!-- <div v-if="imageUrl" class="flex justify-center items-center border border-gray-300 rounded-md p-2 shadow-md" >
                            <img :src="imageUrl" alt="Error" class="w-[50%] h-[50%] rounded-md relative"/>
                        </div> -->
                        
                        <!--image-->

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
                            <h1 class="mb-6">Attachment: </h1>
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

const installerFileName = ref('');
const addFile = (event)=>{
    console.log(event.target.files[0].name);

    installerFileName.value = event.target.files[0].name;
    form.installer = event.target.files[0];
    console.log(installerFileName)
}

const deleteFile = () => {
    form.installer = '';
    installerFileName.value = '';
}

const deleteImage = () => {
    form.image = '';
    imageUrl.value = '';
}

// temporary image address...
// const imageUrl = ref([]);
// const videoUrl = ref();
//at image input
// const addImage = (event)=>
// {
//     for(const image of event.target.files)
//     {
//         form.images.push(image);
//         imageUrl.value.push(URL.createObjectURL(image));
//     }
//     // Reset the file input
//     const fileInputRef = $refs.fileInputRef;
//     if (fileInputRef) {
//         fileInputRef.value = null;
//     }
//     console.log(imageUrl);
// }
const form = useForm({
    name:null,
    phoneNumber:null,
    email:null,
    title: null,
    content: null,
    page:pagesToAdd,
    image:null,
    installer:null,
})

const validationError = ref('');
const submit = ()=>{

    if(selectedPage.value.name === 'Contacts')
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
    else
    {
        form.post(route('webPost.store'), { onSuccess: ()=> form.reset(['images', 'installer'])})
    }
    
};
</script>