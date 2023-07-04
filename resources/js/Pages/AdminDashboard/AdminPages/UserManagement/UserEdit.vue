<template>
    <DashboardLayout :user="loggedUser" >
        <div class="border-bot-only border-gray-600 shadow-md">
            <span class="text-[20px] font-bold text-gray-500">Edit User</span>  
        </div>
        
        <form @submit.prevent="submit">
            <div class="grid grid-cols-12   gap-4 w-full mt-12 ">
                
                 <!--role-->
                    <div class="w-full mb-4 col-span-12 border-bot-only px-2 ">Role</div>
                
                    <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3 items-center" >
                        <Dropdown  v-model="selectedRole" :options="roleList" optionLabel="role" placeholder="Select a Role" class="w-full md:w-14rem " />
                        <InputError :error="form.errors.role"/>
                    </div>
                    <!--subject-->
                    <div v-if="isTeacher || isStudent" class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                        <Dropdown  v-model="selectedSubject" :options="user.instructorSubjects" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem " />
                        <InputError :error="form.errors.subject_id"/>
                        
                    </div>
                    <!--section-->
                    <div class="w-full col-span-12 md:col-span-4 lg:col-span-3" >
                        <div v-if="isStudent" v-for="subject in user.studentSubjects" >
                            <div v-if="subject.id === selectedSubject.id" >
                                <div >
                                    <Dropdown  v-model="selectedSection" :options="subject.section" optionLabel="name" placeholder="Select a Section" class="w-full md:w-14rem " />
                                    <InputError :error="form.errors.section_id"/>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <div class="col-span-12 mb-3 border-bot-only px-2">Personal Info</div>
                <div class="w-full col-span-12 md:col-span-4 ">
                    <span class="p-float-label">
                        <InputText id="firstName" v-model="form.fName" class="w-full" />
                        <label for="firstName">First name</label>
                    </span>
                    <InputError :error="form.errors.fName"/>
                </div>
                <div class="w-full mb-4 col-span-12 md:col-span-4 ">
                    <span class="p-float-label">
                        <InputText id="middleName" v-model="form.mName" class="w-full" />
                        <label for="middleName">Middle name</label>
                    </span>
                    <InputError :error="form.errors.mName"/>
                </div>
                
                <div class="w-full mb-4 col-span-12 md:col-span-4 ">
                    <span class="p-float-label">
                        <InputText id="lastName" v-model="form.lName" class="w-full"/>
                        <label for="lastName">Last name</label>
                    </span>
                    <InputError :error="form.errors.lName"/>
                </div>
                
                
                

                <div class="w-full mb-4 col-span-12 md:col-span-4 " >
                    <span class="p-float-label">
                        <InputNumber v-model="form.phoneNumber"  :useGrouping="false"  inputId="phoneNumber" class="w-full"/>
                        <label for="phoneNumber">Phone Number ( <span class="text-red-300">639191112222</span> )</label>
                    </span>
                    <InputError :error="form.errors.phoneNumber"/>
                </div>

                <div class="w-full mb-4 col-span-12 md:col-span-4 " >
                    <span class="p-float-label">
                        <Calendar v-model="form.birthDate" inputId="birthDate" class="w-full" />
                        <label for="birthDate">Birthday</label>                       
                    </span>
                    <InputError :error="form.errors.birthDate"/>
                </div>
               <!--spacer-->
               <div v-show="isTeacher" class="w-full mb-4 col-span-12 md:col-span-4 "></div>
                <!--spacer-->
                <!-- parents name -->
                <div  v-if="isStudent" class="w-full mb-4 col-span-12 md:col-span-4 ">
                    <span v-if="isStudent" class="p-float-label">
                        <InputText id="fatherName" v-model="form.fatherName" class="w-full" />
                        <label for="fatherName">Father's name</label>
                    </span>
                    <InputError :error="form.errors.fatherName"/>
                </div>

                <div v-if="isStudent" class="w-full mb-4 col-span-12 md:col-span-4 " >
                    <span class="p-float-label">
                        <InputText id="motherName" v-model="form.motherName" class="w-full" />
                        <label for="motherName">Mother's name</label>
                    </span>
                    <InputError :error="form.errors.motherName"/>
                </div>

                 
                <div class="w-full mb-4 col-span-12 md:col-span-4 space-y-2 mx-4" >
                    <h1 class="text-gray-600 text-[16px]">Gender :</h1>
                    <div class="w-full mb-4 col-span-12 md:col-span-4 flex align-items-center space-x-4 items-center">
                        <RadioButton v-model="selectedGender" inputId="male" name="male" value="male" />
                        <label for="male" class="ml-2">Male</label>
                        
                        <RadioButton v-model="selectedGender" inputId="female" name="female" value="female" />
                        <label for="female" class="ml-2">Female</label>
                        <InputError :error="form.errors.gender"/>
                    </div>
                    
                </div>

                <div class="w-full mb-4 col-span-12 md:col-span-4 space-y-2 mx-4" >
                    <h1 class="text-gray-600 text-[16px]">Civil Status :</h1>
                    <div class="w-full mb-4 col-span-12 md:col-span-4 flex align-items-center space-x-4 items-center">
                        <RadioButton v-model="selectedCivilStatus" inputId="single" name="single" value="single" />
                        <label for="single" class="ml-2">Single</label>

                        <RadioButton v-model="selectedCivilStatus" inputId="married" name="married" value="married" />
                        <label for="married" class="ml-2">Married</label>
                        <InputError :error="form.errors.civilStatus"/>
                    </div>
                </div>
               
                
                
                
                
                <!--Complete Address-->
                <div class="w-full mb-4 col-span-12 border-bot-only px-2 ">Address</div>
                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                    <Dropdown  v-model="selectedRegion" :options="regionList" optionLabel="region_name" placeholder="Select a Region" class="w-full md:w-14rem"  />
                    <InputError :error="form.errors.region"/>
                </div>

                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                    <Dropdown  v-model="selectedProvince" :options="provinceList" optionLabel="province_name" placeholder="Select a Province" class="w-full md:w-14rem" :disabled="disabledProvince" />
                    <InputError :error="form.errors.province"/>
                </div>

                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3">
                    <Dropdown  v-model="selectedCity" :options="citiesList" optionLabel="city_name" placeholder="Select a City" class="w-full md:w-14rem "  :disabled="disabledCity"/>
                    <InputError :error="form.errors.city"/>
                </div>
                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3">
                    <Dropdown  v-model="selectedBrgy" :options="brgyList" optionLabel="brgy_name" placeholder="Select a Barangay" class="w-full md:w-14rem " :disabled="disabledBarangay" />
                    <InputError :error="form.errors.barangay"/>
                </div>
                
               
             
                
                
                
            </div>
            
            
            <div class="w-full mt-6 ">
                <Button label="Update" class="w-full" type="submit"/>
            </div>
            
        </form>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../../Layout/DashboardLayout.vue';
import {ref, onMounted, watch, computed, onBeforeUnmount, reactive, defineProps} from 'vue'
import {regions,provinces,cities,barangays,provinceByName,regionByCode, provincesByCode} from "select-philippines-address";
import { useForm, usePage } from '@inertiajs/vue3'
import InputError from '../../../GlobalComponent/InputError.vue';

const user = defineProps({
    userToEdit: Object,
    userSubject: Object,
    instructorSubjects:Array,
    studentSubjects:Array,
    
})




regions().then((region)=> regionList.value = region)



const loggedUser = computed(() => usePage().props.user);




const handleSubjectChange = ()=>{
    console.log('selected subject: '+selectedSubject);
}
 

const hasReloaded = localStorage.getItem('hasReloaded');

// show selected
onMounted(()=>{
    
    if (!hasReloaded) {
        localStorage.setItem('hasReloaded', true);
        location.reload();
    } else {
        localStorage.removeItem('hasReloaded');
    }
    
    regionByCode(user.userToEdit.region).then((region) => {
        selectedRegion.value = region
        
        provincesByCode(selectedRegion.value.region_code).then((province) => {
            const tempProvince = province.filter((prov)=> prov.province_code === user.userToEdit.province)
            selectedProvince.value = tempProvince[0];
           
            cities(selectedProvince.value.province_code).then((city) => {
                const tempCity = city.filter((town)=> town.city_code === user.userToEdit.city)
                selectedCity.value = tempCity[0];
                
                barangays(selectedCity.value.city_code).then((barangays) => {
                    const tempBarangay = barangays.filter((barangay) => barangay.brgy_code === user.userToEdit.barangay)
                    selectedBrgy.value = tempBarangay[0]
                   
                });
            });
        });
    });
    
    if(user.userToEdit.role === 'instructor'){
        isTeacher.value = true
        isStudent.value = false
        form.role = user.userToEdit.role
    }
    else if(user.userToEdit.role === 'student'){
        isStudent.value = true;
        isTeacher.value = false;
        form.role       = user.userToEdit.role
    }
    else{
        isTeacher.value = false
        isStudent.value = false
        form.role       = user.userToEdit.role
    }
    selectedSubject.value       =  user.userToEdit.subject

    selectedGender.value        = user.userToEdit.gender
    selectedCivilStatus.value   = user.userToEdit.civilStatus

    form.email  = user.userToEdit.email
    form.id     = user.userToEdit.id
    form.image = user.userToEdit.image
    form.fatherName = user.userToEdit.fatherName
    form.motherName = user.userToEdit.motherName
    
})





const disabledProvince = ref(true)
const disabledCity = ref(true)
const disabledBarangay= ref(true)
//data lists
const regionList = ref()
const provinceList = ref([])
const citiesList = ref([])
const brgyList = ref([]) 
const roleList = ref([
    {
        'role':'admin'
    },
    {
        'role':'instructor'
    },
    {
        'role': 'student'
    },
    {
        'role': 'guest'
    }
])










//selected values

const selectedRegion = ref({})

const selectedProvince = ref({})
const selectedCity = ref({})
const selectedBrgy = ref({})
const selectedRole = ref({'role': user.userToEdit.role})
const selectedSubject = ref({})
const selectedSection = ref(user.userToEdit.section)
const selectedGender = ref('')
const selectedCivilStatus = ref('')
const isTeacher = ref(false)
const isStudent = ref(false)



//provinceByName(user.user.province).then((province) => console.log(province));
watch([selectedGender, selectedCivilStatus], ([newSelectedGender, newSelectedCivilStatus])=>{
    //console.log(newSelectedCivilStatus+ " *** " + newSelectedGender)
    form.civilStatus = newSelectedCivilStatus
    form.gender = newSelectedGender
})

watch(selectedSubject,(val) =>{
    if(val){
        if(val.name){
            form.subject_id = val.id
            //console.log(val.name)
        }
    }
    
})

watch(selectedRole, (val) =>{ 
     console.log(val.role)
     console.log('role changed');
    if(val.role === 'instructor'){
        isStudent.value = false
        isTeacher.value = true
        form.role       = val.role
        
    }
    else if(val.role === 'student'){
        isTeacher.value = false
        isStudent.value = true;
        form.role       = val.role
    }
    else{
        isTeacher.value = false
        isStudent.value = false
        form.role       = val.role
    }
    
})

// watchers 
watch(selectedRegion, (val) =>{ 
    //console.log(val.region_code)
    form.region = val.region_code
    provinces(val.region_code).then((province) => provinceList.value = province);
    
    disabledProvince.value = false
})

watch(selectedProvince, (val) =>{
    //console.log(val.province_code)
    form.province = val.province_code
    cities(val.province_code).then((city) => citiesList.value = city);
    disabledCity.value = false
})

watch(selectedCity, (val) =>{
    //console.log(val.city_code)
    form.city = val.city_code
    barangays(val.city_code).then((barangays) => brgyList.value = barangays);
    disabledBarangay.value = false
})

watch(selectedBrgy, (val) =>{
    //console.log(val.brgy_code)
    form.barangay = val.brgy_code
})

watch(selectedSection,(val)=>{
    //console.log(val.id)
    form.section_id = val.id;
})

const form = useForm({
    id:null,
    fName: user.userToEdit.fName,
    mName: user.userToEdit.mName,
    lName: user.userToEdit.lName,
    gender: null,
    civilStatus: null,
    phoneNumber: parseInt(user.userToEdit.phoneNumber),
    birthDate: user.userToEdit.birthDate,
    image:null,
    region: null,
    province: null,
    city: null,
    barangay: null,
    role: null,
    subject_id: null,
    section_id: user.userToEdit.section_id,
    email:null,
    fatherName:null,
    motherName:null,
})





const submit = ()=> form.post(route('admin.userUpdate'),{
    preserveScroll: true,
    
})
</script>

