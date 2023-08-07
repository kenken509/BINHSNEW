<template>
    <DashboardLayout :user="user">
        <div class=" flex justify-between items-center border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Web Posts Page</span>  
            <Dropdown  v-model="selectedPage" :options="pages" optionLabel="name" placeholder="Select page" class="md:w-14rem mb-2" />
        </div>
       <div v-if="$page.props.flash.success" class="bg-green-300 rounded-md p-2 mb-4 text-gray-600">{{ $page.props.flash.success }}</div>
       <!--about page-->
        <div v-if="selected === 'About'" class=" overflow-x-auto shadow-md sm:rounded-lg">
            
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700 ">
                    <tr>
                            <th scope="col" class="px-6 py-3">
                                ID#
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Post Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Author
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Content
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                            
                        </tr>
                        
                </thead>
                <tbody>
                    
                    <tr v-for="post in post.about" class="hover:bg-red-200 cursor-pointer border border-gray-300">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <span class>{{ post.author.lName+', '+post.author.fName }} </span> 
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify">
                            {{ post.content }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class=" space-x-6" >
                                <div v-if="$page.props.flash.success"><Toast position="top-left" /> </div>
                                <Link :href="route('aboutPost.delete', {id: post.id})" class="cursor-pointer" v-tooltip.left="'Delete User'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link :href="route('editPost.show', {id:post.id, page:'About'})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit Post'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'View full info'" @click="openModal(user.id)" ></span>
                            </div>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--about page-->

        <!--contacts page-->
        <div v-if="selected === 'Contacts'" class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Contact Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Contact #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created by
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                        
                </thead>
                <tbody>
                    
                    <tr v-for="post in post.contacts" class="hover:bg-red-200 cursor-pointer border border-gray-300">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.name }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.phoneNumber }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <span class>{{ post.author.lName+', '+post.author.fName }} </span> 
                        </td>
                        
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class=" space-x-6" >
                                <div v-if="$page.props.flash.success"><Toast position="top-left" /> </div>
                                <Link :href="route('contactPost.delete', {id: post.id})" class="cursor-pointer" v-tooltip.left="'Delete User'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link :href="route('editPost.show',{id:post.id, page:'Contacts'})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit Post'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'View full info'" @click="openModal(user.id)" ></span>
                            </div>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--contacts page-->

        <!--News page-->
        <div v-if="selected === 'News'" class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3">
                             Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                             Media
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Content
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created by
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                        
                </thead>
                <tbody>
                    
                    <tr v-for="post in post.news" class="hover:bg-red-200 cursor-pointer border border-gray-300">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                            {{ post.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <div class="flex justify-center items-center w-[100px] h-[100px] ">
                                <img v-if="post.filename" :src="appUrl+post.filename" alt="error" class="rounded-md"/>
                                <p v-else>----</p>
                            </div>
                            
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify ">
                            {{ post.content }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <span class>{{ post.author.lName+', '+post.author.fName }} </span> 
                        </td>
                        
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class=" space-x-6" >
                                <div v-if="$page.props.flash.success"><Toast position="top-left" /> </div>
                                <Link :href="route('newsPost.delete', {id: post.id})" class="cursor-pointer" v-tooltip.left="'Delete User'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link href="" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit Post'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'View full info'" @click="openModal(user.id)" ></span>
                            </div>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--News page-->

        <!--Download page-->
        <div v-if="selected === 'Downloads'" class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-200 uppercase bg-green-700 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID#
                        </th>
                        <th scope="col" class="px-6 py-3">
                             Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                             Content
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Media
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Installer
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created by
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                        
                </thead>
                <tbody>
                    
                    <tr v-for="post in post.downloads" class="hover:bg-red-200 cursor-pointer border border-gray-300">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ post.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                            {{ post.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify ">
                            {{ post.content }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            
                            <div v-if="post.mediaType === 'image'" class="flex justify-center items-center w-[100px] h-[100px] ">
                                <img  :src="appUrl+post.mediaFileName" alt="error" class="rounded-md"/>
                            </div>
                            <div v-if="post.mediaType === 'video'" class="flex justify-center items-center w-[100px] h-[100px] ">
                                <video  :src="appUrl+post.mediaFileName" alt="error" class="rounded-md" controls/>
                            </div>
                            <div v-if="post.mediaType === null">
                                ---
                            </div>
                            
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <span class>{{stringModifier(post.installerFileName)  }} </span> 
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            <span class>{{ post.author.lName+', '+post.author.fName }} </span> 
                        </td>
                        
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class=" space-x-6" >
                                <div v-if="$page.props.flash.success"><Toast position="top-left" /> </div>
                                <Link :href="route('downloadsPost.delete', {id: post.id})" class="cursor-pointer" v-tooltip.left="'Delete User'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <Link href="" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit Post'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'View full info'" @click="openModal(user.id)" ></span>
                            </div>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--Download page-->
    </DashboardLayout>

</template>




<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { usePage, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue'

const user = usePage().props.user
const appUrl = 'http://127.0.0.1:8000/storage/'
const post = defineProps({
    posts:Array,
    about:Array,
    contacts:Array,
    news:Array,
    downloads:Array,
})

const selectedPage = ref(null);
const pages = ref([
    {'name':'About'},
    {'name':'Contacts'},
    {'name':'News'},
    {'name':'Downloads'},
])


const selected = computed(()=>{
    
    if(selectedPage.value)
    {
        if(selectedPage.value.name === 'About')
        {
            return 'About'
        }
        else if(selectedPage.value.name === 'Contacts')
        {
            return 'Contacts'
        }
        else if(selectedPage.value.name === 'News')
        {
            return 'News'
        }
        else if(selectedPage.value.name === 'Downloads')
        {
            return 'Downloads'
        }
    }
    
})

function stringModifier(myString){
    let separator = '_'
    const index = myString.indexOf(separator);
    return index !== -1 ? myString.slice(index+1) : myString
}
</script>