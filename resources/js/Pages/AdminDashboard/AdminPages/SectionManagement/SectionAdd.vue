<template>
    <DashboardLayout :user="user" >
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Section Page</span>  
        </div>
        <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>

        
        <form @submit.prevent="confirmAddSection">
            <div class="w-full mb-4 ">
                <div class="mb-5">Name: </div>
                <div>
                    <span class="p-float-label">
                        <InputText id="name" v-model="form.name" class="w-full"/>
                        <label for="name">Section name</label>
                    </span>
                    <InputError :error="form.errors.name"/>
                </div>
            </div>
                   
            <div class="mb-5">Strand: </div>
            <div>
                <Dropdown  v-model="selectedSubject" :options="props.subjects" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem "  />
                <InputError :error="form.errors.subject_id"/>
            </div>
            
            <div class="mb-5">Instructor: </div>
            <div v-for="subject in props.subjects">
                <div v-if="subject === selectedSubject">
                    <div>
                        <Dropdown  v-model="selectedInstructor" :options="existingInstructors" optionLabel="lName" placeholder="Select a Instructor" class="w-full md:w-14rem "  />
                    </div>
                    <InputError :error="form.errors.instructor_id"/>
                </div>
            </div>
            <div class="w-full mt-6 ">
                <Button label="Add" class="w-full" type="submit"/>
            </div>
        </form>               
                        
                    
            
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import InputError from '../../../GlobalComponent/InputError.vue';
import {ref, watch} from 'vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

import { useForm, usePage } from '@inertiajs/vue3';


const user = usePage().props.user;

const props = defineProps({
    subjects:Array,
})


const selectedSubject = ref(null);
const selectedInstructor = ref(null);
const existingInstructors = ref([]);
const form = useForm({
    name:null,
    subject_id:null,
    instructor_id:null,
})

watch(selectedSubject,(val)=>{
    //console.log(val.id);
    form.subject_id = val.id;
    
    props.subjects.forEach(element => {
        if(element.id === val.id){
            existingInstructors.value = element.instructor.filter((val)=>{
               return val.role === 'instructor'
            })
        }
    });
    console.log(existingInstructors.value)
})
watch(selectedInstructor,(val)=>{
    form.instructor_id = val.id;
    console.log(selectedInstructor.value);
})

const submit = () => form.post(route('section.store',{
    preserveScroll: true,
}))

// alert codes

function confirmAddSection()
{
    Swal.fire({
        title:'Confirmation',
        text:'Are you sure?',
        icon:'question',
        confirmButtonText:'Yes, add it!',
        cancelButtonText:'Cancel',
        showCancelButton:true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result)=>{
        if(result.isConfirmed)
        {
            submit()    
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
</script>