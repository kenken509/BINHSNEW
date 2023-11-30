<template>
    <div class=" flex justify-center">
        
        <WebNavLayout2 :currentUser="null"  >
       
        </WebNavLayout2>
  
    </div>

    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>


    
    <div v-if="$page.props.flash.error">
        <InputError :error="$page.props.flash.error"/>
        <!-- attempting user: {{ $page.props.flash.temp }} -->
    </div>
    <div v-else>
        
        <div class="flex justify-center items-center bg-gray-200 h-screen  py-10" ref="myView">
            <div></div>
            <div>
                
            </div>
            <div class="flex flex-col w-full md:w-[450px] border border-gray-300 shadow-md  mx-4 md:mx-0 pt-8 rounded-md"  >
                <div class="flex justify-center items-center w-full mt-4">
                    <img src="../../../../public/images/webPage/logo1.png" alt="error"  class="w-[150px] h-[150px]" /> 
                </div>
                <div class="flex justify-center">
                    <span class=" font-bold text-xl">Reset Password</span>
                </div>
                <!--input group-->
                <div >
                    <form class="px-8" @submit.prevent="submit">
                        <div class="w-full my-8 ">
                            <span class="p-float-label ">
                                <div class="w-full bg-red-300">
                                </div>
                                <InputText id="password" type="password" class="w-full"  v-model="form.password" required/>
                                <label for="password">New password</label>
                            </span>
                            <InputError :error="form.errors.password"/>
                        </div>

                        <div class="w-full my-8">
                            <span class="p-float-label ">
                                <div class="w-full bg-red-300">
                                </div>
                                <InputText id="password_confirmation" type="password" class="w-full" v-model="form.password_confirmation" required/>
                                <label for="password_confirmation">Confirm password</label>
                                
                            </span>
                        </div>
                        <div class="w-full my-8" >
                            <Button label="Submit" class="w-full" type="submit"/>
                        </div>
                    </form>
                </div>
            </div>
            
            <div></div>
        </div>
    </div>
    <WebFooter />
</template>

<script setup>
import { useForm,usePage } from '@inertiajs/vue3';
import InputError from '../GlobalComponent/InputError.vue';
import { onMounted, ref, computed } from 'vue';
import WebNavLayout2 from '../Index/WebComponent/WebNavLayout2.vue'
import WebHeaderLayout from '../Index/WebComponent/WebHeaderLayout.vue'
import WebFooter from '../Index/WebComponent/WebFooter.vue'


const page = usePage()

const attemptingUser = computed(() => page.props.flash.temp)

const myViewRef = ref(null);




// this is the id of the user attempting to change password: $page.props.flash.temp
const form = useForm({
    userId:attemptingUser.value,
    password:null,
    password_confirmation:null,
})

const submit = ()=>{
    form.post(route('change.password.store'),{preserveScroll:true});
}

</script>