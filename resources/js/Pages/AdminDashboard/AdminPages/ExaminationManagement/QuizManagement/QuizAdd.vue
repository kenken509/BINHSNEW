<template>
    <DashboardLayout :user="user">
        <div class="border-bot-only border-gray-600 shadow-md mb-4">
            <span class="text-[20px] font-bold text-gray-500">Add Quiz Page</span>  
        </div>
        <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>

        <div>
            <form>
                <div class="grid grid-cols-2 gap-2 w-full h-full">
                    <div class="col-span-2 md:col-span-1 w-full">
                        <h1>Quiz Information</h1>
                        <hr>
                        <div class="grid grid-cols-12">
                        <div v-if="user.role === 'admin'" class="w-full mb-4 col-span-12 md:col-span-4 " >
                            <div class="mb-5">Subject: </div>
                                <Dropdown  v-model="selectedSubject" :options="props.subjects" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem " />
                                <InputError :error="form.errors.subject_id"/>
                            </div>
                        </div>
                        <div class="w-full mb-4 ">
                            <div class="mb-5">Title: </div>
                                <span class="p-float-label">
                                    <InputText id="title"  class="w-full"/>
                                    <label for="title">Title</label>
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                        </div>
                    <div class="col-span-2 md:col-span-1 w-full">
                        <h1>Quiz Questions</h1>
                        <hr>
                    </div>
                </div>
                
            </form>
        </div>
    </DashboardLayout>
    
</template>

<script setup>
import DashboardLayout from '../../../Layout/DashboardLayout.vue';
import InputError from '../../../../GlobalComponent/InputError.vue';
import { usePage, Link } from '@inertiajs/vue3';
const user = usePage().props.user;

</script>