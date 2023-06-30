<template>

   
    <div class="flex justify-center items-center bg-gray-200 h-screen items-center py-10 ">
        <div></div>
        <div class="border border-gray-300 shadow-md  h-auto mx-4 w-full md:w-1/4  pt-8 rounded-md " >
            <div class="flex justify-center items-center w-full mt-4">
                <img src="../../../../public/images/webPage/logo1.png" alt="error"  class="w-[150px] h-[150px]" /> 
            </div>
            <div class="flex justify-center">
                <span class=" font-bold text-xl mb-4">Change Password</span>
            </div>
            <!--input group-->
            <div>
                <form class="px-8" @submit.prevent="submit">
                    
                    
                    <div class="w-full my-8 ">
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
                    </div>
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
import InputError from '../GlobalComponent/InputError.vue';
const user = computed(() => usePage().props.user);

const form = useForm({
    password:null,
    password_confirmation:null,
    // role: 'guest',
})

const submit = () => form.post(route('reset.password'),{preserveScroll:true});
</script>