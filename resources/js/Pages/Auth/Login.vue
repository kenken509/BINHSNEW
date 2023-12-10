<script setup>
import { useForm,usePage } from '@inertiajs/vue3';
import { ref,computed } from 'vue';
import {Link} from '@inertiajs/vue3'
import Swal from 'sweetalert2';

const logo = '/storage/Images/logo1.png'
const error = computed(()=> usePage().props.flash);
const inputType = ref('password');
const iconType = ref(true)

const handleClick = () => {
    inputType.value = inputType.value === 'password' ? 'text' : 'password'
    iconType.value = !iconType.value
}

const form = useForm({
    email:null,
    password:null
})

const login = ()=>{
    console.log(';alsdkf');
    form.post(route('login.store'))
}

// alert codes

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
            location.reload();
        }
    })
}

function errorMessage(message)
{
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: message+'!',
        
    }).then((result)=>{
        if(result.isConfirmed)
        {
            location.reload();
        }
    })
}
</script>

<template >
    <div class="w-screen h-screen flex items-center justify-center ">
        <div class=" border border-gray-300 shadow-md rounded  w-[450px] h-auto py-8">
            <div class="flex items-center justify-center mt-2 ">
                <img :src="logo" class=" w-[150px] h-[150px]">
            </div>
            <div v-if="$page.props.flash.error" >{{ errorMessage($page.props.flash.error) }} </div>
            <!--login form-->
            <div class="">
                <form  @submit.prevent="login">
                    <div class="justify-center w-full mx-auto p-5 ">
                        <div class="flex  justify-center mb-4">                           
                             <span class=" font-bold text-xl">Account Sign-in</span>
                        </div>
                        <div v-if="error.error" class="flex  justify-center ">
                            <span class=" font-bold text-red-500">{{ error.error }}</span>
                        </div>
                        <div v-if="error.success" class="flex  justify-center ">
                            <span >{{ successMessage(error.success) }}</span>
                        </div>
                        <div class=" mt-2  ">
                            <label class="label" for="email">E-mail</label>
                            
                            
                            <div class="w-full relative flex items-center mb-2">
                                <i class="fa-solid fa-user absolute p-3 text-blue-400 pointer-events-none"></i>
                                <input type="text" id="email" name="email" placeholder="email" class="input pl-8"  v-model="form.email" autocomplete="false">
                            </div>
                            
                            
                            <div v-if="form.errors.email" class="input-error px-2">{{ form.errors.email }}</div>
                            
                        </div>
                        
                        <div class="mt-4">
                            <label class="label" for="password">Password</label>
                            
                            <div class="relative flex items-center w-full ">
                                <div class="absolute flex justify-between w-full  items-center ">
                                    <i v-if="iconType" class="fa-solid fa-eye fa-fade fa-sm text-blue-400 pl-3 cursor-pointer" @click="handleClick"></i>
                                    <i v-else class="fa-solid fa-eye-slash fa-sm text-blue-400 pl-3 cursor-pointer" @click="handleClick"></i>
                                    
                                </div>
                                <input :type="inputType" id="password" name="password" placeholder="password" class="input focus:outline:white focus:outline-offset-0 shadow-none pl-8 w-full" v-model="form.password">
                            </div>
                            
                        </div >
                        <button class="btn-primary w-full mt-4 text-center" type="submit"  :disabled="form.processing">Sign-in</button>
                        <div class="flex justify-between mt-2">
                            <span>Don't have and account? <Link :href="route('register.guest')" class="text-blue-500"> register</Link></span>
                            <Link :href="route('forgot.password.show')" class="text-blue-500"> Forgot password?</Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</template>
