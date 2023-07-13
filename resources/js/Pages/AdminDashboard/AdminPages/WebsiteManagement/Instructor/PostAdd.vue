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
                <div class="flex flex-col col-span-12">
                    <div class="pb-5 text-[18px]">Image:</div>
                    <input type="file" multiple @input="addImage" accept="image/jpeg"/>
                    <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress> -->
                    <!-- <div v-if="imageErrors.includes('this image')"><InputError :error="'Image file type must be in jpg,png format. Maximum size: 3mb'" /></div> -->
                </div>
                <div v-for="(image,index) in form.images" :key="image.name" class="col-span-1">
                    <div class="">
                        <img :src="imageUrl[index]" alt="Image" class="w-[100px] h-[100px]"/>
                        
                    </div>
                </div>
                <!--VIDEO UPLOAD-->
                <div class="flex flex-col col-span-12">
                    
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
    created_by:user.id,
})

// temporary image address...
const imageUrl = ref([]);

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



//reset the images in the form
const reset = ()=> form.reset('images');



const getImageDataUrl = (image) => {
    const reader = new FileReader();
    reader.readAsDataURL(image);
    return new Promise((resolve, reject) => {
        reader.onload = () => {
            resolve(reader.result);
        };
        reader.onerror = (error) => {
            reject(error);
        };
    });
};

const stopPropagation = (event) => {
  event.stopPropagation();
  console.log('stopppppp')
};

// at form submit
const submit = () => {
    form.post(route('webPost.store'),{ onSuccess: ()=> form.reset('images')})
    console.log('ako to');
} ;

</script>