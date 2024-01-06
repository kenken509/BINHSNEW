<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Back-up Files</span>  
        </div>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead>
                    <tr class="text-xs text-gray-200 uppercase bg-green-700  ">
                        <td  scope="col" class="px-6 py-3">
                            File
                        </td>
                        <td  scope="col" class="px-6 py-3">
                            Action
                        </td>
                    </tr>
                </thead>
                <tbody v-for="(file,index) in data.backupFiles" :key="index">
                    <tr>
                        <td scope="col" class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="pi pi-file mr-2" style="font-size: 24px"></i>
                                <span class="text-gray-600">{{ extractName(file) }}</span>
                            </div>
                        </td>
                        <td scope="col" class="px-6 py-3">
                            <div class="flex space-x-8 ">
                                <Link :href="route('database.backup.delete', { filename:extractName(file)})" class="cursor-pointer" v-tooltip.left="'Delete File'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link>
                                <button type="submit" :disabled="form.processing" @click="submit(extractName(file))">
                                    <span class="pi pi-refresh text-green-600 scale-110 hover:dark:scale-150"></span>
                                </button>
                                
                                
                            </div> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { usePage,Link, useForm } from '@inertiajs/vue3';
import DashboardLayout from '../../Layout/DashboardLayout.vue';

 
const user = usePage().props.user;

const data = defineProps({
    backupFiles:Array,
})

function extractName(name)
{
    const extractedName = name.split('/');

    const filename = extractedName[1];

    // // Extract date and time from the filename
    // const [, datePart, timePart] = filename.split('_');

    // const formattedDate = new Date(`${datePart} ${timePart.replace('.sql', '')}`);
    // const options = { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };

    return filename
}

const form = useForm({
    filename:null,
})

const submit = (name)=> {
        form.filename = name
        form.post(route('database.restore'))
    };
</script>