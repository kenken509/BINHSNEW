<template>

   
    <div class="flex justify-center items-center bg-gray-200 h-screen  py-10">
        <div></div>
        <div>
            <div v-if="$page.props.flash.error"  >{{ errorMessage($page.props.flash.error) }} </div>
        </div>
        <div class="flex flex-col w-full md:w-[450px] border border-gray-300 shadow-md  mx-4 md:mx-0 pt-8 rounded-md" >
            <div class="flex justify-center items-center w-full mt-4">
                <img src="../../../../public/images/webPage/logo1.png" alt="error"  class="w-[150px] h-[150px]" /> 
            </div>
            <div class="flex justify-center">
                <span class=" font-bold text-xl">Reset Password</span>
            </div>
            <!--input group-->
            <div>
                <form class="px-8" @submit.prevent="submit">
                    <div class="w-full col-span-12 md:col-span-4 mt-16 ">
                        <span class="p-float-label">
                            <InputText type="email" id="email"  class="w-full" v-model="form.email" required/>
                            <label for="email">Email</label>
                        </span>
                        <InputError :error="form.errors.email"/>
                    </div>
                    
                    <!-- <div class="w-full my-8 ">
                        <span class="p-float-label ">
                            <div class="w-full bg-red-300">
                            </div>
                            <InputText id="password" type="password" class="w-full" v-model="form.password" />
                            <label for="password">New password</label>
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
                    </div> -->
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
import {computed} from 'vue'
import { useForm,usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const user = computed(() => usePage().props.user);

const form = useForm({
    email: null,
    // password:null,
    // password_confirmation:null,
    // role: 'guest',
})

const flashClear = useForm({
  clear: null,
})

function errorMessage(message) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    html: `<span class="text-red-500">${message}!</span>`,
    allowOutsideClick:false,
  }).then((result) => {
    if (result.isConfirmed) {
       
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}
const submit = () => form.post(route('email.reset.password'));
</script>