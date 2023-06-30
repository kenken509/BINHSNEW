<template>
    <div v-if="$page.props.flash.success" class="w-screen bg-green-300 px-2">
            {{ $page.props.flash.success }}
        </div>

    <div class="flex justify-center items-center h-screen text-xl">
        <div>You need to be verified first to see this page! </div>
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


</script>