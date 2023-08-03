<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Post Page</span>  
        </div>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-12">
                
                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                    <h1>Page</h1>
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
                        show Downloads page
                    </div>
                </div>

                <!--News Page-->
                <div v-if="pagesToAdd === 'News'" class="col-span-12">
                    <div>
                        <div class="flex flex-col">
                           <h1 class="mb-6">Title: </h1>
                            <span class="p-float-label">
                                <InputText id="name" v-model="form.name" class="w-full" required/>
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
                            <input  type="file"  id="fileInput" multiple @input="addImage" accept="image/*" hidden  ref="fileInputRef"/>
                            <!-- <FileUpload mode="basic" multiple name="imageUpload" @input="addImage" accept="image/jpeg" :maxFileSize="1000000" /> -->
                            <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress> -->
                            
                           
                            
                        </div>

                        <!-- <div v-if="form.images.length" class="flex gap-3 flex-wrap border border-2 border-gray-400 shadow-md p-4 rounded-md">
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
                        </div> -->
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
const addImage = (event)=>{
    
    form.image = event.target.files[0]
    
    imageUrl.value = URL.createObjectURL(event.target.files[0]);

    console.log(imageUrl);
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
        form.post(route('webPost.store'))
    }
    
};
</script>