<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Back-up Files</span>  
        </div>

        <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
        <div v-if="$page.props.flash.error" >{{ errorMessage($page.props.flash.error) }} </div>
        
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
                <tbody v-for="(file,index) in reverseFile" :key="index">
                    <tr>
                        <td scope="col" class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="pi pi-file mr-2" style="font-size: 24px"></i>
                                <span class="text-gray-600">{{ extractName(file) }}</span>
                            </div>
                        </td>
                        <td scope="col" class="px-6 py-3">
                            <div class="flex space-x-8 ">
                                <!-- <Link :href="route('database.backup.delete', { filename:extractName(file)})" class="cursor-pointer" v-tooltip.left="'Delete File'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                               
                                <span class="pi pi-trash text-red-600 scale-110 hover:dark:scale-150 hover:cursor-pointer" @click="confirmDeletion(extractName(file))"></span>
                                
                                <button type="submit" :disabled="form.processing" @click="confirmRestoration(extractName(file))">
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
import { usePage, useForm, router } from '@inertiajs/vue3';
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import Swal from 'sweetalert2';
import { computed } from 'vue';
 
const user = usePage().props.user;

const data = defineProps({
    backupFiles:Array,
})

const reverseFile = computed(()=>{
    return data.backupFiles.slice().reverse();
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


// SWEET ALERT CODE

function confirmRestoration(filename)
{
    Swal.fire({
        title:'Confirm Restoration',
        text:'Are you sure?',
        icon:'question',
        confirmButtonText:'Yes',
        cancelButtonText:'Cancel',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result)=>{
        if(result.isConfirmed)
        {
            submit(filename)    
        }

        if(result.isDismissed)
        {
            Swal.fire({
                title:'Canceled',
                text:'Your action was canceled!',
                icon:'error',
                allowOutsideClick:false,
                allowEscapeKey:false,
            }).then((result)=>{
                if(result.isConfirmed)
                {
                    location.reload();
                }
            })
        }
    })
}

function confirmDeletion(fileName)
{
    Swal.fire({
        title:'Confirm Deletion',
        text:'Are you sure?',
        icon:'question',
        confirmButtonText:'Yes',
        cancelButtonText:'Cancel',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result)=>{
        if(result.isConfirmed)
        {
            const deleteUrl = route('database.backup.delete', { filename:fileName})

            router.delete(deleteUrl);
        }

        if(result.isDismissed)
        {
            Swal.fire({
                title:'Canceled',
                text:'Your action was canceled!',
                icon:'error',
                allowOutsideClick:false,
                allowEscapeKey:false,
            }).then((result)=>{
                if(result.isConfirmed)
                {
                    location.reload();
                }
            })
        }
    })
}

function successMessage(message) {
  Swal.fire({
    title: 'Success',
    text: message + '!',
    icon: 'success',
    allowOutsideClick: false,
    allowEscapeKey: false
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}

function errorMessage(message) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: message + '!',
    allowOutsideClick:false,
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}
</script>