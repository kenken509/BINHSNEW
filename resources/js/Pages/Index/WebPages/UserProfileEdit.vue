<template>
    <div class="">
        <WebNavLayout2 :current-user="userToEdit.userToEdit" />
    </div>
    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
    <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
   
    
    <div class="flex flex-col items-center   w-full h-full  p-5">
        <div class="w-[80%] h-[90%]">
            <div>Account Management</div>
            
            <div class=" w-full  border border-gray-500 shadow-md rounded-md bg-gray-200" >
                
                <div class="grid grid-cols-12 gap-4">
                    <!--Image-->
                    <div class="flex flex-col justify-top items-center col-span-12 md:col-span-4  py-2 relative ">

                        <img :src="userToEdit.userToEdit.image ? appUrl+userToEdit.userToEdit.image:appUrl+'Images/default.png' " alt="error" class="w-[200px] h-[200px] mt-6 rounded-full"/>
                        <label for="imageUpdate" class="absolute top-1 right-2 mt-2 p-4 border bg-green-600 text-gray-300 hover:bg-green-800 hover:text-white cursor-pointer" v-tooltip.left="'Update Image'" style="width: 40px; height: 40px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="pi pi-pencil " style="color: whitesmoke; font-size: 20px;"></i>
                        </label>
                        <input id="imageUpdate" type="file" accept="image/*" @input="updateImage" hidden />

                        <span v-if="userToEdit.userToEdit.fName" class=" text-[30px]">{{ toUpperFirst(userToEdit.userToEdit.fName)  }} </span>
                        <span v-else>{{ toUpperFirst(userToEdit.userToEdit.role) }}</span>
                        <div>Account Role: {{ userToEdit.userToEdit.role }}</div>
                        <div v-if="form.errors.image">
                            <InputError :error="form.errors.image"/>
                        </div>
                        <div class="border-bot-only border-gray-600 shadow-md w-[95%]"></div>
                    </div>
                    <!--Image-->

                    <!--Account info-->
                    <div class="col-span-12 md:col-span-8 border border-l-gray-500 p-2">
                        <div class="flex justify-between border-bot-only border-gray-600 shadow-md">
                            <span class="text-[20px] font-bold text-gray-500">Account Information</span>
                            <button  class="mr-2 mb-2 bg-green-600 p-2  border border-gray-500 rounded-md hover:bg-green-500 text-gray-200 "   @click="openModal" >Update</button>
                        </div>
                        <div class="mt-2">
                            Full Name:  <span v-if="userToEdit.userToEdit.fName">{{ toUpperFirst(userToEdit.userToEdit.fName)}}</span>&nbsp;
                                        <span v-if="userToEdit.userToEdit.mName">{{ toUpperFirst(userToEdit.userToEdit.mName)  }}</span>&nbsp; 
                                        <span v-if="userToEdit.userToEdit.lName"> {{toUpperFirst(userToEdit.userToEdit.lName)  }}</span>
                                        
                        </div>
                        <div class="mt-2">
                            Gender: <span v-if="userToEdit.userToEdit.gender" class=" ">{{ toUpperFirst(userToEdit.userToEdit.gender) }}</span> 
                        </div> 
                        <div class="mt-2">
                            Civil status: <span v-if="userToEdit.userToEdit.civilStatus" class=" ">{{ toUpperFirst(userToEdit.userToEdit.civilStatus) }}</span> 
                        </div>   
                        <div class="mt-2">
                            email: <span  class=" ">{{ userToEdit.userToEdit.email }}</span> 
                        </div> 
                        <div class="mt-2">
                            Contact #: <span v-if="userToEdit.userToEdit.phoneNumber" class=" ">{{ toUpperFirst(userToEdit.userToEdit.phoneNumber) }}</span> 
                        </div>  
                        <div class="mt-2">
                            Birthdate: <span v-if="userToEdit.userToEdit.birthDate" class=" ">{{ userToEdit.userToEdit.birthDate }}</span> 
                        </div> 
                        <div class="mt-2">
                            Age: <span class=" ">{{ userToEdit.userToEdit.age ? userToEdit.userToEdit.age:'--' }}</span> 
                        </div>
                        <div class="mt-2">
                            Address: <span v-if="userBarangay" class=" ">
                                        
                                        Brgy. {{ userBarangay ? userBarangay.brgy_name:null }}
                                        {{ userCity ? userCity.city_name:null }},
                                        {{ userProvince ? userProvince.province_name:null }}
                                        --{{ userRegion ? userRegion.region_name:null }}--
                                    </span> 
                        </div>
                        <div v-if="userToEdit.userToEdit.role === 'student'">
                            Student #: {{ userToEdit.userToEdit.student_number }}
                        </div>
                    </div>
                    <!--Account info-->

                    <!--MODAL-->
                    <div class="card flex justify-content-center userInfo">
                        
                        <Dialog v-model:visible="visible"  modal  :style="{ width: '80vw' } " >
                           
                            <template #header>
                              <span class=" font-bold text-[24px]">{{ toUpperFirst(userToEdit.userToEdit.role) }} Account information</span> 
                            </template>
                            <div class="border-bot-only border-gray-600 shadow-md mb-4"></div>
                            <div class="w-full mb-4 col-span-12 border-bot-only px-2 ">Basic info</div>
                            <div class="grid grid-cols-12 gap-4 ">
                                <div class="col-span-12 md:col-span-4">
                                    <div class="mb-5">First Name: {{ form.fName }} </div>
                                    <div>
                                        <span class="p-float-label">
                                            <InputText id="fName" v-model="form.fName" class="w-full"/>
                                            <label for="fName">First name</label>
                                        </span>
                                        <InputError :error="form.errors.fName"/>
                                    </div>
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <div class="mb-5">Middle Name: </div>
                                    <div>
                                        <span class="p-float-label">
                                            <InputText id="mName" v-model="form.mName" class="w-full"/>
                                            <label for="mName">Middle name</label>
                                        </span>
                                        <InputError :error="form.errors.mName"/>
                                    </div>
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <div class="mb-5">Last Name: </div>
                                    <div>
                                        <span class="p-float-label">
                                            <InputText id="lName" v-model="form.lName" class="w-full"/>
                                            <label for="lName">Last name</label>
                                        </span>
                                        <InputError :error="form.errors.lName"/>
                                    </div>
                                </div>

                                <!-- <div class="col-span-12 md:col-span-4">
                                    <div class="mb-5">Email: </div>
                                    <div>
                                        <span class="p-float-label">
                                            <InputText id="email" v-model="form.email" class="w-full" type="email"/>
                                            <label for="email">Email</label>
                                        </span>
                                        <InputError :error="form.errors.email"/>
                                    </div>
                                </div> -->

                                <div class="col-span-12 md:col-span-4">
                                    <div class="mb-5">Contact #: </div>
                                    <div>
                                        <span class="p-float-label">
                                            <InputText id="phoneNumber" v-model="form.phoneNumber" class="w-full" />
                                            <label for="phoneNumber">Phone number</label>
                                        </span>
                                        <InputError :error="form.errors.phoneNumber"/>
                                    </div>
                                </div>
                                <div class="w-full mb-4 col-span-12 md:col-span-4 " >
                                    <div class="mb-5">Birthdate: </div>
                                    <div>
                                        <span class="p-float-label">
                                            <Calendar v-model="form.birthDate" id="birthDate" class="w-full"  />
                                            <label for="birthDate">Birthdate</label>                       
                                        </span>
                                        <InputError :error="form.errors.birthDate"/>
                                    </div>
                                </div>
                                <div class="w-full mb-4 col-span-12 md:col-span-4 space-y-2 mx-4" >
                                    <h1 class="text-gray-600 text-[16px]">Gender :</h1>
                                    <div class="w-full mb-4 col-span-12 md:col-span-4 flex align-items-center space-x-4 items-center">
                                        <RadioButton v-model="selectedGender" inputId="male" name="male" value="male" />
                                        <label for="male" class="ml-2 cursor-pointer">Male</label>
                                        
                                        <RadioButton v-model="selectedGender" inputId="female" name="female" value="female" />
                                        <label for="female" class="ml-2 cursor-pointer">Female</label>
                                        <InputError :error="form.errors.gender"/>
                                    </div>
                                </div>
                                <div class="w-full mb-4 col-span-12 md:col-span-4 space-y-2 mx-4" >
                                    <h1 class="text-gray-600 text-[16px]">Civil Status :</h1>
                                    <div class="w-full mb-4 col-span-12 md:col-span-4 flex align-items-center space-x-4 items-center">
                                        <RadioButton v-model="selectedCivilStatus" inputId="single" name="single" value="single" />
                                        <label for="single" class="ml-2 cursor-pointer">Single</label>

                                        <RadioButton v-model="selectedCivilStatus" inputId="married" name="married" value="married" />
                                        <label for="married" class="ml-2 cursor-pointer">Married</label>
                                        <InputError :error="form.errors.civilStatus"/>
                                    </div>
                                </div>

                                <div class="border-bot-only  shadow-md mb-4 col-span-12"></div>
                                <!--Complete Address-->
                                <div class="w-full mb-4 col-span-12 border-bot-only px-2 ">Address</div>
                                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                                    <Dropdown  v-model="userRegion" :options="regionList" optionLabel="region_name" placeholder="Select a Region" class="w-full md:w-14rem" />
                                    <InputError :error="form.errors.region"/>
                                </div>

                                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                                    <Dropdown  v-model="userProvince" :options="provinceList" optionLabel="province_name" placeholder="Select a Province" class="w-full md:w-14rem" :disabled="disabledProvince"/>
                                    <InputError :error="form.errors.province"/>
                                </div>

                                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3">
                                    <Dropdown  v-model="userCity" :options="citiesList" optionLabel="city_name" placeholder="Select a City" class="w-full md:w-14rem "  :disabled="disabledCity"/>
                                    <InputError :error="form.errors.city"/>
                                </div>
                                <div class="w-full mb-4 col-span-12 md:col-span-4 lg:col-span-3" >
                                    <Dropdown  v-model="userBarangay" :options="brgyList" optionLabel="brgy_name" placeholder="Select a Barangay" class="w-full md:w-14rem " :disabled="disabledBarangay"  />
                                    <InputError :error="form.errors.barangay"/>
                                </div>
                                
                            </div>
                            
                            <template #footer >
                                <button class="mr-2 mb-2 bg-green-600 p-2  border border-gray-500 rounded-md hover:bg-green-500 text-gray-200  "   @click="visible = false" >  Cancel</button>
                                <button class="mr-2 mb-2 bg-green-600 p-2  border border-gray-500 rounded-md hover:bg-green-500 text-gray-200 "   @click="submit" >  Update</button>
                            </template>
                        </Dialog>
                    </div>
                    <!--MODAL-->
                </div>
                
                
            </div>
        </div>
    </div>
</template>

<script setup>
import WebNavLayout2 from '../WebComponent/WebNavLayout2.vue'
import InputError from '../../GlobalComponent/InputError.vue'
import {Link, useForm, usePage} from '@inertiajs/vue3'
import WebHeaderLayout from '../WebComponent/WebHeaderLayout.vue'
import {toUpperFirst} from '../../Functions/Methods.vue'
import {regions,provinces,cities,barangays,} from "select-philippines-address";
import {onMounted, ref, watch, computed} from 'vue';
import Swal from 'sweetalert2';



const appUrl = '/storage/'
const userToEdit = defineProps({
    userToEdit:Object,
})


const existingRegion = ref(userToEdit.userToEdit.region);
const existingProvince = ref(userToEdit.userToEdit.province);
const existingCity = ref(userToEdit.userToEdit.city)
const existingBarangay = ref(userToEdit.userToEdit.barangay);
const userRegion = ref(null);
const userProvince = ref(null);
const userCity = ref(null);
const userBarangay = ref(null);
//address
const regionList = ref(null);
const provinceList = ref(null);
const citiesList = ref(null);
const brgyList = ref(null);

const disabledProvince = ref(false);
const disabledCity = ref(false);
const disabledBarangay = ref(false);



const selectedGender = ref(userToEdit.userToEdit.gender);
const selectedCivilStatus = ref(userToEdit.userToEdit.civilStatus);


onMounted(()=>{

    

    regions().then((region) => region.forEach((val)=> {
       
        if(val.id === parseInt(existingRegion.value))
        {
            userRegion.value = val
        }
    }))

    provinces(existingRegion.value).then((province) =>{
        province.forEach((val)=>{
            if(val.province_code === existingProvince.value)
            {
                userProvince.value = val
            }
        })
    });

    cities(existingProvince.value).then((city) => {
        city.forEach((val)=>{
            if(val.city_code === existingCity.value)
            {
                userCity.value = val;
            }
        })
        
    });

    barangays(existingCity.value).then((barangays) =>{
        barangays.forEach((val)=>{
            if(val.brgy_code === existingBarangay.value)
            {
                userBarangay.value = val
            }
        })
    });

    regions().then((region)=> regionList.value = region)
    provinces(existingRegion.value).then((province) => provinceList.value = province);
    cities(existingProvince.value).then((city) => citiesList.value = city);
    barangays(existingCity.value).then((barangays) => brgyList.value = barangays);

   
})

const form = useForm({
    image:null,
    existingImage:userToEdit.userToEdit.image,

    fName:userToEdit.userToEdit.fName,
    mName:userToEdit.userToEdit.mName,
    lName:userToEdit.userToEdit.lName,
    gender:selectedGender,
    civilStatus:selectedCivilStatus,
    phoneNumber:userToEdit.userToEdit.phoneNumber,
    //email:userToEdit.userToEdit.email,
    birthDate:userToEdit.userToEdit.birthDate,
    student_number:null,
    region:userToEdit.userToEdit.region,
    province:userToEdit.userToEdit.province,
    city:userToEdit.userToEdit.city,
    barangay:userToEdit.userToEdit.barangay,
});


const updateImage = (event) => {
    
    console.log(event.target.files);
    form.image = event.target.files[0];
    console.log(form.image);
    
    form.post(route('user.profile.image.update'), {
         preserveScroll: true,
         onSuccess: () => {updateForm.reset('image')},
    })
 }

 function reloadPage(){
    
    location.reload()
}

function reloadPageDelayed()
{
    setTimeout(() => {
        location.reload()
    }, 1000);
}
// watch(selectedRegion, (val) =>{ 
//     //console.log(val.region_code)
//     form.region = val.region_code
//     provinces(val.region_code).then((province) => provinceList.value = province);
    
//     disabledProvince.value = false
// })

const submit = ()=> {

    visible.value = false;
    form.post(route('user.profile.info.update'),{
         preserveScroll: true,
    });
}


const visible = ref(false);

const openModal = () =>{
   
    visible.value = !visible.value;
    
    
}
function hide(){
    visible.value = false;
}

// watchers

watch(userRegion, (region)=>{
    console.log(region.region_code)
    form.region = region.region_code;
    form.province = null;
    form.city = null;
    form.barangay = null;
    userProvince.value = null;
    userCity.value = null;
    userBarangay.value = null;
    provinces(form.region).then((province) => provinceList.value = province);
    citiesList.value = null;
    brgyList.value = null;
    
})

watch (userProvince, (province)=>{
    if(userProvince.value)
    {
        form.province = province.province_code;
        form.city = null;
        userCity.value = null;
        form.barangay = null;
        brgyList.value = null;
        cities(province.province_code).then((city) => citiesList.value = city);
        
    }
    
})

watch (userCity, (city)=>{
    if(userCity.value)
    {
        form.city = city.city_code;
        barangays(city.city_code).then((brgy) => brgyList.value = brgy);
    }
   
})

watch(userBarangay, (brgy)=>{
    if(userBarangay.value)
    {
        form.barangay = brgy.brgy_code;
    }
})

const flashClear = useForm({
    clear:null,
})

function successMessage(message)
{
    Swal.fire({
        title:'Success',
        text:message+'!',
        icon:'success',
        allowOutsideClick:false,
        allowEscapeKey:false
    }).then((result)=>{
        if(result.isConfirmed)
        {
            flashClear.get(route('clear.flash.messages'), {preserveScroll:true});
        }
    })
}
</script>