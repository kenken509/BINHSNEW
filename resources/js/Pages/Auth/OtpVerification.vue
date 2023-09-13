<template>

    <div class="flex flex-col justify-center items-center w-full h-screen p-4">
        <div class="text-green-500 mb-4">{{ $page.props.flash.message }}</div>
        <div class="flex  items-center flex-col w-full h-[45%] md:h-[35%] md:w-[50%] lg:h-[42%] lg:w-[30%] border border-gray-400 rounded-md shadow-md p-2 lg:p-4">
                
                <div class="mt-4 mb-4">
                    <span class=" lg:text-[30px] font-serif">OTP VERIFICATION</span>
                </div>
                
                <div v-if="remainingSeconds > 0" >
                    <span>OTP code expires in <span class="text-red-600">{{ remainingSeconds }}</span> secs</span>
                </div>
                <div v-else><InputError :error="'OTP code expired'"/></div>
                <div v-if="form.errors.otp"><InputError :error="form.errors.otp"/></div>
                <div class="w-full mt-4">
                    <input type="text" placeholder="Enter OTP code" class="rounded-md w-full" v-model="form.otp">
                </div>
                <div class=" w-full mt-4">
                    <button type="button" class=" p-2 rounded-md w-full bg-indigo-600 hover:bg-indigo-500 text-gray-100" method="post" @click="verify" >Verify OTP</button>
                </div>
                
                <div class="mt-2 w-full">
                    <span>Resend verification code? <Link :href="route('otp.resend', {id:verifiedUser.attemptingUser.id ? verifiedUser.attemptingUser.id: null})" class="text-indigo-400 cursor-pointer" >click here!</Link></span>
                </div>
        </div>
    </div>
</template>

<script setup>
import { usePage, useForm, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import InputError from '../GlobalComponent/InputError.vue';
import { DateTime } from 'luxon'; // Import luxon DateTime

const userId = usePage().props.flash.attemptId;
const verifiedUser = defineProps({
  attemptingUser: Object,
})

const form = useForm({
  otp: null,
  userId:verifiedUser.attemptingUser.id,
});

//expiration time
const expiresAtDatetime = new Date(verifiedUser.attemptingUser.expires_at);
const hour = ref(expiresAtDatetime.getHours());
const minute = ref(expiresAtDatetime.getMinutes());
const secs = ref(expiresAtDatetime.getSeconds());



//current time
const now = ref(new Date()) ;
const nowHour = ref(now.value.getHours());
const nowMinutes = ref(now.value.getMinutes()) ;
const nowSeconds = ref(now.value.getSeconds());



const hoursToSeconds = ref((hour.value-nowHour.value)*3600);
const minutesToSeconds = ref((minute.value-nowMinutes.value)*60);
const seconds = ref(secs.value-nowSeconds.value);

const remainingSeconds = ref(hoursToSeconds.value+minutesToSeconds.value+seconds.value )




function updateExpireTime()
{
   if(remainingSeconds.value > 0)
   {
        setInterval(()=>{
                remainingSeconds.value = remainingSeconds.value-1
        },1000)
   } 
   
}


onMounted(()=>{
  updateExpireTime()
})

const verify = ()=> form.post(route('otp.auth'));
</script>