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
                        
                        <div class="w-full mt-4">
                            <Button label="Submit" class="w-full " type="submit" />
                        </div>
                    </div>
                </div>

                <!--About Page-->
                <div v-if="pagesToAdd === 'Downloads'" class="col-span-12">
                    <div>
                        show Downloads page
                    </div>
                </div>

                <!--About Page-->
                <div v-if="pagesToAdd === 'News'" class="col-span-12">
                    <div>
                        show News page
                    </div>
                </div>
            
            </div>
        </form>
    </DashboardLayout>
    
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
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
const form = useForm({
    name:null,
    phoneNumber:null,
    email:null,
    title: null,
    content: null,
    page:pagesToAdd,
})

const submit = ()=> form.post(route('webPost.store'));
</script>