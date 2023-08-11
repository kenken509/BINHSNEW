<template>
    <div class="">
        <WebNavLayout :current-user="userToEdit.userToEdit" />
    </div>
    <div class="flex justify-center mt-[68px]">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>

    <div class="flex flex-col items-center   w-full h-full  p-5">
        <div class="w-[80%] h-[90%]">
            <div>Account Management</div>
            <div class=" w-full  border border-gray-500 shadow-md rounded-md bg-gray-200" >
                
                <div class="grid grid-cols-12 gap-4">
                    <!--Image-->
                    <div class="flex flex-col justify-top items-center col-span-12 md:col-span-4  py-2 ">
                        <img :src="userToEdit.userToEdit.image ? appUrl+userToEdit.userToEdit.image:appUrl+'Images/default.png' " alt="error" class="w-[200px] h-[200px] mt-6"/>
                        <span v-if="userToEdit.userToEdit.fName" class=" text-[30px]">{{ toUpperFirst(userToEdit.userToEdit.fName)  }} </span>
                        <span v-else>{{ toUpperFirst(userToEdit.userToEdit.role) }}</span>
                        <div>Account Role: {{ userToEdit.userToEdit.role }}</div>
                        <div class="border-bot-only border-gray-600 shadow-md w-[95%]"></div>
                    </div>
                    <!--Image-->

                    <!--Account info-->
                    <div class="col-span-12 md:col-span-8 border border-l-gray-500 p-2">
                        <div class="flex justify-between border-bot-only border-gray-600 shadow-md">
                            <span class="text-[20px] font-bold text-gray-500">Account Information</span>
                            <Link href="#" class="mr-2 mb-2 bg-green-600 p-2  border border-gray-500 rounded-md hover:bg-green-500 text-gray-200 "  as="button" >Update</Link>
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
                </div>
                
                
            </div>
        </div>
    </div>
    

</template>

<script setup>
import WebNavLayout from '../WebComponent/WebNavLayout.vue'
import {Link} from '@inertiajs/vue3'
import WebHeaderLayout from '../WebComponent/WebHeaderLayout.vue'
import {toUpperFirst} from '../../Functions/Methods.vue'
import {regions,provinces,cities,barangays,} from "select-philippines-address";
import {onMounted, ref} from 'vue';

const appUrl = 'http://127.0.0.1:8000/storage/'
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
})
// watch(selectedRegion, (val) =>{ 
//     //console.log(val.region_code)
//     form.region = val.region_code
//     provinces(val.region_code).then((province) => provinceList.value = province);
    
//     disabledProvince.value = false
// })
</script>