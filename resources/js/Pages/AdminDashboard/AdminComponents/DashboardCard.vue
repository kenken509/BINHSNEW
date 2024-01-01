<template>
    <div
    class="block rounded-lg bg-white p-6 shadow-md m-2">
        <h4
            class="mb-2 text-xl font-medium leading-tight text-gray-500  ">
            {{ data.title }}
        </h4>
        <div>
            
        </div>
        <p class="mb-4 text-base text-gray-700 font-bold text-[45px] py-2">
            {{ data.currentCount }}
        </p>
        <div v-if="increased" class="flex flex-col space-x-2 ">
            <div class="flex space-x-1">
                <p class="text-green-500" ><i class="pi pi-angle-up text-green-500"></i> {{Math.abs(Math.floor(increased))}} % from previous school year</p>
            </div>
            
            
        </div>

        <div v-if="decreased" class="flex flex-col space-x-2 ">
            <div class="flex space-x-1">
                <p class="text-red-500" ><i class="pi pi-angle-down text-red-500"></i> {{ Math.abs(Math.floor(decreased)) }}% from previous school year</p>
            </div>
        </div>
        <div v-if="noChanges">
            <p class="text-blue-500">{{ noChanges }}</p>
        </div>
        <div v-if="newCount">
            <p class="text-green-700"> {{ newCount }}</p>
        </div>
    </div>
    
    <template>
        
</template>
</template>

<script setup>
import { Colors } from 'chart.js';
import {ref} from 'vue'

const percentChanges = ref(null);
const increased = ref(null);
const decreased = ref(null);
const noChanges = ref(null);
const newCount = ref(null);

// admin changes

if(data.currentCount > data.previousCount && data.previousCount !== 0) // if current is greater than previous means it increased
{
    increased.value = ((data.currentCount-data.previousCount)/data.previousCount)*100
}

if(data.currentCount === data.previousCount && data.previousCount !== 0)
{
    noChanges.value = 'No changes from previous school year';
}

if(data.currentCount < data.previousCount )
{
    decreased.value = ((data.currentCount-data.previousCount)/data.previousCount)*100
}

if(data.previousCount === 0)
{
    newCount.value = 'No record from previous school year'
}
// admin changes



const data = defineProps({
    title:String,
    currentCount: Number,
    previousCount:Number,
    arrow:String,
    textColor:String,
    evaluation:String,
    currentSchoolYear:String,
})
</script>