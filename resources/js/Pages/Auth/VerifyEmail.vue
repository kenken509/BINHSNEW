<template>
    <div v-if="$page.props.flash.success" >
        {{ successMessage($page.props.flash.success) }} 
    </div>

    <div class="flex justify-center items-center h-screen text-xl">
        <div>You need to verify your email first to see this page! </div>
        <div>
            <Link :href="route('verification.send')" 
            method="post" 
            as="button" 
            class="text-indigo-600 dark:text-indigo-600 hover:text-indigo-400" 
            >
                &nbsp; Resend verification email?
                
            </Link>
        </div>
    </div>    
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';


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
            // Redirect to the index route
            window.location.href = '/'; // Replace '/index' with the actual URL of your index route
        }
    })
}

</script>