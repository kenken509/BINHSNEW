<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Edit Section Page</span>  
        </div>
        <!-- <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div> -->

        <!-- <div v-for="subject in section.subjects">{{ subject.instructor }}</div> -->
        
      
        <form @submit.prevent="confirmUpdate">
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
                <Dropdown  v-model="selectedSubject" :options="section.subjects" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem "  />
                <InputError :error="form.errors.subject_id"/>
            </div>
            <hr>
            <div class="my-5">Instructor: </div>
            
            <div v-for="subject in section.subjects">
               
                <div v-if="subject === selectedSubject">
                    <div>
                        <Dropdown  v-model="selectedInstructor" :options="existingInstructors" optionLabel="lName" placeholder="Select a Instructor" class="w-full md:w-14rem "  />
                    </div>
                    <InputError :error="form.errors.instructor_id"/>
                </div>
            </div>
            <div class="w-full mt-6 ">
                <Button label="Update" class="w-full" type="submit"/>
            </div>
        </form>              
    </DashboardLayout>

</template>

<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3';
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import { onMounted,ref, watch } from 'vue';
import InputError from '../../../GlobalComponent/InputError.vue';
import Swal from 'sweetalert2';

const user = usePage().props.user;

const section = defineProps({
    section:Object,
    subjects:Array
})
const sectionSubject = section.subjects.filter((subject)=> subject.id === section.section.subject.id)
const selectedSubject = ref(sectionSubject[0]);
const selectedInstructor = ref(null)
const existingInstructors = ref(null);



const form = useForm({
    section_id:section.section.id,
    name:section.section.name,
    subject_id:section.section.subject.id,
    instructor_id:section.section.instructors[0].id,
})

const hasReloaded = localStorage.getItem('hasReloaded');
onMounted(()=>{
    //reload
    if (!hasReloaded) {
        localStorage.setItem('hasReloaded', true);
        location.reload();
    } else {
        localStorage.removeItem('hasReloaded');
    }

    

    section.subjects.forEach(element => {
        
        if(element.id === selectedSubject.value.id){
            existingInstructors.value = element.instructor.filter((val)=>{
               return val.role === 'instructor'
            })
        }
    });

    
       existingInstructors.value.forEach(value =>{
            if(value.id === section.section.instructors[0].id)
            {
                selectedInstructor.value = value;
            }
        });
    
    
    //console.log(existingInstructors)
})
console.log("current instructor id: "+form.instructor_id)
watch(selectedSubject,(val)=>{
    form.instructor_id = null;
    form.subject_id = val.id;


    section.subjects.forEach(element => {
        if(element.id === val.id){
            existingInstructors.value = element.instructor.filter((val)=>{
               return val.role === 'instructor'
            })
        }
    });
    console.log(existingInstructors.value)
})


watch(selectedInstructor, (val)=>{
    console.log(val.id);
    
    form.instructor_id = val.id;
})
const submit = ()=> form.post(route('section.update',{
    preserveScroll:true,
}))

// alert codes

function confirmUpdate(sectionId)
{
    Swal.fire({
        title:'Update Confirmation',
        text:'Are you sure?',
        icon:'question',
        showCancelButton:true,
        confirmButtonText:'Yes, update it!',
        cancelButtonText:'Cancel',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result)=>{
        if(result.isConfirmed)
        {
            submit();
        }
    })
}

</script>