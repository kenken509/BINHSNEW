<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">Add New Post</span>  
        </div>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-12   gap-4 w-full mt-12 mb-4 ">
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
                
            </div>

            <div class="w-full col-span-12 mb-4 ">
                <div class="pb-5 text-[18px]">Content:</div>
                <span class="p-float-label ">
                <Textarea v-model="form.content" rows="5" cols="50" class="w-full"  />
                <label for="title">Enter your post content here</label>
                </span>
                <div v-if="form.errors.content">
                    <InputError :error="form.errors.content"/>
                </div>
            </div>

            <div class="col-span-12 md:col-span-3 mb-4">
                <label > Attachment : </label>
                <Dropdown  v-model="selectedAttachment" :options="attachments" optionLabel="name" placeholder="None" class="w-full md:w-14rem " @change="dropdownChange"/>
            </div>

            <!--IMAGE UPLOAD-->
            <div v-if="selectedAttachment && (selectedAttachment.name === 'Image')" class="col-span-12">
                    
                <div class="border border-gray-300 border border-2 rounded-md border-gray-200 col-span-12 px-2 py-2">
                    <div class=" flex  items-center gap-2 w-full  my-1   py-2">
                        <label for="fileInput" class="file-input-label bg-gray-300 px-4 py-2 rounded-md cursor-pointer">
                            Select a file...
                        </label>
                        
                        <input  type="file"  id="fileInput"  @input="addImage" accept="image/*" hidden  ref="fileInputRef"/>
                        <!-- <FileUpload mode="basic" multiple name="imageUpload" @input="addImage" accept="image/jpeg" :maxFileSize="1000000" /> -->
                        <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress> -->
                       
                        <div v-if="imageFileName" class=" file-input-label bg-gray-300 px-4 py-2 rounded-md ">
                            <span class="">{{ imageFileName }}</span>
                        </div>    
                    </div>
                    <div v-if="form.errors.image">
                            <InputError :error="form.errors.image"/>
                        </div>
                    <div v-if="form.image" class="flex gap-3 flex-wrap border border-2 border-gray-400 shadow-md p-4 rounded-md">
                        <div class=" bg-gray-400 rounded-md" >
                            <div class="flex justify-center ">
                                <div class="relative border border-gray-400 rounded-md shadow-md w-full lg:w-[80%] ">
                                    <img :src="imageUrl" alt="Image" class=" rounded-md relative"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div v-if="fileError(errorsArray, 'images').length">
                        <InputError :error="'The image file must ba a file of type: jpg, jpeg, png, with a max size of 3mb'"/>
                    </div> -->
                    <div v-if="$page.props.flash.error" ><InputError :error="$page.props.flash.error"/></div>
                </div>
            </div>


            <div class="w-full col-span-12 mt-4">
                <Button label="Submit" class="w-full " type="submit"/>
            </div>
        </form>
        
    </DashboardLayout>

</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import {ref, computed, onMounted, watch} from 'vue'
import InputError from '../../../../GlobalComponent/InputError.vue'



const user = usePage().props.user

const selectedAttachment = ref(null);



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

const dropdownChange = ()=>{
    form.attachment = selectedAttachment

    //reset all media
    imageUrl.value = null;
    form.image = null;
}


onMounted(()=>{
    
   
})

// watch(selectedAttachment,(val)=>{
//     form.attachment = val.name
//     console.log(form.attachment)

//      reset all images and videos
//     imageUrl.value = null;
//     form.image = null;
// })

const imageUrl = ref(null);
const imageFileName = ref(null);
const addImage = (event)=>{
    const image = event.target.files[0];
    //console.log(image);

    form.image = event.target.files[0];
    imageUrl.value = URL.createObjectURL(image) ;
    imageFileName.value = event.target.files[0].name
}

const deleteImage = ()=>{
    selectedAttachment.value = {'name':'None'}
    form.image = null;
    imageUrl.value = null;
}


const form = useForm({
    author_id:user.id,
    attachment:null, //selectedAttachment
    subject_id:user.subject_id,
    title:null,
    content:null,
    status:'active',
    image:null,
    video:null,
    created_by:user.id,
})

const submit = () => {
    
   
    // if(videoSize.value > 35000000)
    // {
    //     console.log('oversized video');
    // }
    // else
    
    form.post(route('instructorWebPost.store'),{ onSuccess: ()=> form.reset('images')})
    
} ;

</script>