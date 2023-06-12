<template>
    <DashboardLayout :user="user" >
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Questions Page</span>  
        </div>
        <div>
            <form @submit.prevent="submit">
                <div>
                    
                   
                    <div class="grid grid-cols-12">
                        <div v-if="user.role === 'admin'" class="w-full mb-4 col-span-12 md:col-span-4 " >
                            <div class="mb-5">Subject: </div>
                            <Dropdown  v-model="selectedSubject" :options="props.subjects" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem " />
                            <InputError :error="form.errors.subject_id"/>
                        </div>
                    </div>
                   
                    <div class="w-full mb-4 col-span-12 md:col-span-4 ">
                        <div class="mb-5">Question: </div>
                        <span class="p-float-label">
                            <Textarea v-model="form.question" rows="5"  class="w-full" id="questionText"/>
                            <label for="questionText">Type your question here</label>
                        </span>
                        <InputError :error="form.errors.question"/>
                    </div>
                    <div class="w-full mb-4 col-span-12 md:col-span-4 ">
                        <div class="mb-5">Correct Answer: </div>
                        <span class="p-float-label">
                            <InputText id="lastName" v-model="form.correct_answer" class="w-full"/>
                            <label for="lastName">Enter correct answer</label>
                        </span>
                        <InputError :error="form.errors.correct_answer"/>
                    </div>
                    <!-- OPTIONS-->
                    <div class="grid grid-cols-12 gap-4">
                        
                        <div class="w-full mb-4 md:col-span-6 ">
                            <div class="mb-5">Option A: </div>
                            <span class="p-float-label">
                                <InputText id="lastName" v-model="form.option_a" class="w-full"/>
                                <label for="lastName">Enter option</label>
                            </span>
                            <InputError :error="form.errors.option_a"/>
                        </div>
                        <div class="w-full mb-4 md:col-span-6 ">
                            <div class="mb-5">Option B: </div>
                            <span class="p-float-label">
                                <InputText id="lastName" v-model="form.option_b" class="w-full"/>
                                <label for="lastName">Enter option</label>
                            </span>
                            <InputError :error="form.errors.option_b"/>
                        </div>
                        <div class="w-full mb-4 md:col-span-6 ">
                            <div class="mb-5">Option C: </div>
                            <span class="p-float-label">
                                <InputText id="lastName" v-model="form.option_c" class="w-full"/>
                                <label for="lastName">Enter option</label>
                            </span>
                            <InputError :error="form.errors.option_c"/>
                        </div>
                        <div class="w-full mb-4 md:col-span-6 ">
                            <div class="mb-5">Option D: </div>
                            <span class="p-float-label">
                                <InputText id="lastName" v-model="form.option_d" class="w-full"/>
                                <label for="lastName">Enter option</label>
                            </span>
                            <InputError :error="form.errors.option_d"/>
                        </div>
                        

                    </div>
                    <!--OPTIONS-->
                </div>
                <div class="w-full mt-6 ">
                    <Button label="Submit" class="w-full" type="submit"/>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import { usePage, Link, useForm  } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import InputError from '../../../../GlobalComponent/InputError.vue';


const user = usePage().props.user;
const selectedSubject = ref("");

const form = useForm({
    question: null,
    correct_answer:null,
    subject_id:user.subject_id,
    option_a:null,
    option_b:null,
    option_c:null,
    option_d:null,
})

const submit = ()=> form.post(route('question.store'),{
    preserveScroll: true,
    // onSuccess: () => form.reset('images'), // if sucessfull reset image input
})

const props = defineProps({
    subjects:Array
})

watch(selectedSubject, (val) =>{
    //console.log(val.id)
    form.subject_id = val.id
})

</script>