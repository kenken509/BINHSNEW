<template>
   <DashboardLayout :user="user">
    <div class="border-bot-only border-gray-600 shadow-md mb-4">
        <span class="text-[20px] font-bold text-gray-500">Edit Post Page</span> 
    </div>
    <!--About Page-->
    {{ web.webPage }}
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
    </form>

   </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import InputError from '../../../../GlobalComponent/InputError.vue';
import { usePage,useForm } from '@inertiajs/vue3';
import {ref, computed} from 'vue';

const user = usePage().props.user

const web = defineProps({
    post:Object,
    webPage:Object,
})

const form = useForm({
    id:web.post.id,
    page:web.webPage,
    title:web.post.title,
    content:web.post.content,

    name:web.post.name,
    phoneNumber:web.post.phoneNumber,
    email:web.post.email,
})

const submit = ()=> form.post(route('editAboutPost.store'));
</script>