<template>
    <div class="flex justify-center border-y-2 my-4 border-gray-300">
        <span class="text-[30px] text-gray-500">TOP 10 </span>
    </div>
    <div class="flex flex-col col-span-12 md:col-span-6 px-4 mb-4">
        <div
            class="flex justify-center items-center font-bold border-t-2 pt-2 border-gray-300"
        >
            {{ getInstructorSubject(user.subject_id) }} - HONORED STUDENTS
        </div>
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-md shadow-md">
                    <table
                        class="min-w-full text-center text-sm font-light border-gray-200"
                    >
                        <thead
                            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-green-600 border"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-4 bg-gray">
                                    TOP
                                </th>
                                <th scope="col" class="px-6 py-4">FIRST</th>
                                <th scope="col" class="px-6 py-4">LAST</th>
                                <th scope="col" class="px-6 py-4">GRADE</th>
                            </tr>
                        </thead>
                        <tbody
                            v-for="(top, index) in instructorTopTen"
                            :key="top.id"
                            class="border border-gray-300"
                        >
                            <tr class="dark:border-neutral-500">
                                <td
                                    class="whitespace-nowrap px-6 py-4 font-medium"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ top.student.fName }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ top.student.lName }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ top.final_grade }} %
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed,ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const user = computed(() => usePage().props.user);
defineProps({
    instructorTopTen: Array,
});

 const instructorSubject = ref(null); 
 

function getInstructorSubject(subjectId){

    
    switch(subjectId){
        case 1:
            instructorSubject.value = 'Agri-Fishery Arts';
            break; 
        
        case 2:
            instructorSubject.value = 'HOME ECONOMICS';
            break;

        case 3:
            instructorSubject.value = 'ICT';
            break;

        case 4:
            instructorSubject.value = 'INDUSTRIAL ARTS';
            break;
    }

    return instructorSubject.value
}
</script>
