<template>

    <div class=" flex justify-center">
        
        <WebNavLayout2 :currentUser="user"  >
    
        </WebNavLayout2>

    </div>

    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>

    <div class="flex justify-center items-center bg-gray-200 h-full items-center py-10 ">
        
        
        <div class="border border-gray-300 shadow-xl   w-full md:w-1/2 h-auto   mx-4 md:mx-0 pt-8 rounded-md " >
            <div class="flex justify-center items-center w-full mt-4">
                <img src="../../../../public/images/webPage/logo1.png" alt="error"  class="w-[150px] h-[150px]" /> 
            </div>
            <div class="flex justify-center">
                <span class=" font-bold text-xl">Account Registration</span>
            </div>
            <div class="flex justify-center">
                <span class="text-[12px]">School Year: {{  currentSchoolYear }}</span>
            </div>
            <!--input group-->
            <div >
                <form class="px-8" @submit.prevent="submit">
                    <div v-if="selectedRole === 'student'">
                        <div class=" w-full  md:col-span-4 mt-8 ">
                            <span class="p-float-label">
                                <InputText id="fName"  class="w-full" v-model="form.fName" />
                                <label for="fName">First Name</label>
                            </span>
                            <InputError :error="form.errors.fName"/>
                        </div>
                        <div class=" w-full  md:col-span-4 mt-8 ">
                            <span class="p-float-label">
                                <InputText id="lName"  class="w-full" v-model="form.lName" />
                                <label for="lName">Last Name</label>
                            </span>
                            <InputError :error="form.errors.lName"/>
                        </div>
                        <div class=" w-full  md:col-span-4 mt-8 ">
                            <span class="p-float-label">
                                <InputText id="student_number"  class="w-full" v-model="form.student_number" />
                                <label for="student_number">Student number</label>
                            </span>
                            <InputError :error="form.errors.student_number"/>
                        </div>
                    </div>
                    <div class=" w-full  md:col-span-4 mt-8 ">
                        <span class="p-float-label">
                            <InputText type="email" id="email"  class="w-full" v-model="form.email" />
                            <label for="email">Email</label>
                        </span>
                        
                        <InputError :error="form.errors.email"/>
                    </div>
                    
                    <div class="w-full my-8 ">
                        <span class="p-float-label ">
                            <div class="w-full bg-red-300">
                            </div>
                            <InputText id="password" type="password" class="w-full" v-model="form.password" />
                            <label for="password">Password</label>
                        </span>
                        <InputError :error="form.errors.password"/>
                    </div>
                    
                    <div class="w-full my-8">
                        <span class="p-float-label ">
                            <div class="w-full bg-red-300">
                            </div>
                            <InputText id="password_confirmation" type="password" class="w-full" v-model="form.password_confirmation" />
                            <label for="password_confirmation">Confirm password</label>
                        </span>
                    </div>
                    
                    <div v-if="selectedRole === 'student'" class="my-8">
                        <Dropdown  v-model="selectedSubject" :options="subject.subjects" optionLabel="name" placeholder="Select subject" class="w-full md:w-14rem"/>
                        <InputError :error="form.errors.subject"/>
                        <div v-if="selectedSubject" class="my-8">
                            <div>
                                <Dropdown  v-model="selectedSection" :options="availableSection" optionLabel="name" placeholder="Select section" class="w-full md:w-14rem" />
                            </div>
                            <InputError :error="form.errors.section"/>
                        </div>
                    </div>
                    <!-- role selection-->
                        <div class="flex gap-5 flex-wrap px-2">
                            <div class="flex items-center hover:cursor-pointer ">
                                <RadioButton v-model="selectedRole" inputId="guest" name="pizza" value="guest" />
                                <label for="guest" class="ml-2 hover:cursor-pointer">Guest</label>
                            </div>
                            <div v-if="currentMonth !== 8" class="flex items-center hover:cursor-pointer ">
                                <RadioButton v-model="selectedRole" inputId="student" name="pizza" value="student"/>
                                <label for="student" class="ml-2 hover:cursor-pointer">Student</label>
                            </div>
                            <InputError :error="form.errors.role"/>
                        </div>
                    <!-- role selection-->
                    <div class="w-full my-8">
                        <Button label="Submit" class="w-full" type="submit"/>
                    </div>
                    
                </form>
            </div>
        </div>
        
        <div></div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from 'vue'
import { useForm,usePage } from '@inertiajs/vue3';
import InputError from '../GlobalComponent/InputError.vue';
import WebNavLayout2 from '../Index/WebComponent/WebNavLayout2.vue';
import WebHeaderLayout from '../Index/WebComponent/WebHeaderLayout.vue'

const subject = defineProps({
    subjects:Array,
})
const user = computed(() => usePage().props.user);

const selectedSubject = ref(null);
const selectedRole = ref(null);
const selectedSection = ref(null);

const availableSection = ref([]);
watch(selectedSubject, (val) =>{
    availableSection.value = [];
    form.subject = val.id;
    subject.subjects.forEach((subject)=>{
        if(subject.id === val.id)
        {
            subject.section.forEach((sec)=> availableSection.value.push(sec))
        }
    })
    
})

watch(selectedSection, (val)=>{
    form.section = val.id;
})

watch(selectedRole, (val)=>{
    form.role = val
    if(val == 'student')
    {
        form.isActive = '0'
    }
    
    if(val == 'guest')
    {
        form.isActive = '1'
    }
})


const form = useForm({
    fName:null,
    lName:null,
    student_number:null,
    email: null,
    password:null,
    password_confirmation:null,
    role: null,
    isActive:null,
    subject:null,
    section:null,
    currentSchoolYear:null,
})

onMounted(()=>{
    const currentDate = new Date();
    const month = ref(currentDate.getMonth());
    const year = currentDate.getFullYear();
    
    
    currentMonth.value = month.value+1;
    if(currentMonth.value < 8 )
    {
        currentSchoolYear.value = (year-1)+'-'+year

    }
    else if(currentMonth.value >= 9 )
    {
        currentSchoolYear.value = year+'-'+(year+1);
    }
    else{
        currentSchoolYear.value = null;
    }

    
    
})

const currentMonth = ref(null);
const currentSchoolYear = ref(null);

const submit = () => {
    form.currentSchoolYear = currentSchoolYear.value;
    form.post(route('register.guestStore'),{preserveScroll:true});
}

</script>