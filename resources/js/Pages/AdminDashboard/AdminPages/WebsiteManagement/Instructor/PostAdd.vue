<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">Add New Post</span>  
        </div>
        title
        content
        attachment
        <form>
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
                    <Textarea v-model="value" rows="5" cols="50" class="w-full"  />
                    <label for="title">Enter your post content here</label>
                    </span>
                    <!-- <InputError :error="form.errors.fName"/> -->
                </div>

                <!--IMAGE UPLOAD-->
                <div class="flex flex-col col-span-12">
                    <div class="pb-5 text-[18px]">Image:</div>
                    <FileUpload name="demo[]" url="./upload.php"  :multiple="true" accept="image/*" :hideUploadButton="true" :maxFileSize="1000000">
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                    <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress> -->
                    <!-- <div v-if="imageErrors.includes('this image')"><InputError :error="'Image file type must be in jpg,png format. Maximum size: 3mb'" /></div> -->
                </div>

                <!--VIDEO UPLOAD-->
                <div class="flex flex-col col-span-12 ">
                    <div class="pb-5 text-[18px]">Video:</div>
                    <FileUpload name="demo[]" url="./upload.php"  :multiple="true" accept="video/*" :maxFileSize="1000000000" >
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                    <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress> -->
                    <!-- <div v-if="imageErrors.includes('this image')"><InputError :error="'Image file type must be in jpg,png format. Maximum size: 3mb'" /></div> -->
                </div>
            </div>
        </form>
    </DashboardLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layout/DashboardLayout.vue';


const user = usePage().props.user;


const form = useForm({
    author_id:user.id,
    subject_id:user.subject_id,
    title:null,
    content:null,
    status:'private',
    attachment:null,
    created_by:user.id,
})


</script>