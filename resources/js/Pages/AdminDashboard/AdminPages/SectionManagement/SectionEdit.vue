<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Edit Section Page</span>  
        </div>
        <!-- <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div> -->

        {{ section.section.subject.id }}

        <form @submit.prevent="submit">
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
                   {{ selectedSubject }}
            <div class="mb-5">Subject: </div>
            <div>
                <Dropdown  v-model="selectedSubject" :options="section.subjects" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem "  />
                <InputError :error="form.errors.subject_id"/>
            </div>
            <div class="w-full mt-6 ">
                <Button label="Add" class="w-full" type="submit"/>
            </div>
        </form>              
    </DashboardLayout>

</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import { onMounted,ref, watch } from 'vue';
import InputError from '../../../GlobalComponent/InputError.vue';

const user = usePage().props.user;

const section = defineProps({
    section:Object,
    subjects:Array
})
const sectionSubject = section.subjects.filter((subject)=> subject.id === section.section.subject.id)
const selectedSubject = ref(sectionSubject[0]);

const form = useForm({
    section_id:section.section.id,
    name:section.section.name,
    subject_id:section.section.subject.id,
})

watch(selectedSubject,(val)=>{
    //console.log(val.id)
    form.subject_id = val.id;
})

const submit = ()=> form.post(route('section.update',{
    preserveScroll:true,
}))


</script>