<template>
   <DashboardLayout :user="user">
      <div class="flex justify-between border-bot-only border-gray-600 shadow-md mb-[30px]">
            <span class="text-[20px] font-bold text-gray-500">Admin Dashboard</span>
            <span class="text-[20px] font-bold text-gray-500">School year: {{ data.currentSchoolYear }}</span>    
      </div>
      <section class="grid grid-cols-12 mt-4" >
         <div class="col-span-12 md:col-span-3 ">
            <DashboardCard :title="'ADMINS'" :value="data.adminCount" :percentage="10" :arrow="'pi pi-angle-down text-red-500'" :textColor="'text-red-500'" :evaluation="'decreased'"></DashboardCard>
         </div>
         <!-- <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <DashboardCard :title="'INSTRUCTORS'" :value="10" :percentage="10" :arrow="'pi pi-angle-down text-red-500'" :textColor="'text-red-500'" :evaluation="'decreased'"></DashboardCard>
         </div> -->
         
         <div class="col-span-12 md:col-span-3  ">
            <DashboardCard :title="'STUDENTS '" :currentSchoolYear="currentSchoolYear" :value="data.studentCount" :percentage="23" :arrow="'pi pi-angle-up text-[#2a9e66]'" :textColor="'text-green-500'" :evaluation="'increased'"></DashboardCard>
         </div>
         
         <div class="col-span-12 md:col-span-3 ">
            <DashboardCard :title="'INSTRUCTORS'" :value="data.instructorCount" :percentage="30" :arrow="'pi pi-angle-up text-red-500'" :textColor="'text-red-500'" :evaluation="'increased'"></DashboardCard>
         </div>
         <div class="col-span-12 md:col-span-3 ">
            <DashboardCard :title="'GUESTS'" :value="data.guestCount" :percentage="30" :arrow="'pi pi-angle-up text-red-500'" :textColor="'text-red-500'" :evaluation="'increased'"></DashboardCard>
         </div>
         <!--flowbite tables-->

         <!--flowbite tables-->
         
      </section >

      <div>
         
      </div>
      <div class="flex justify-center items-center border border-t-2 border-l-0 border-r-0 border-b-0 border-gray-300 pt-4 mt-2">
         <div>Data as of  {{ year }}</div>
      </div>

      <div class="flex flex-col items-center lg:flex-row space-y-5 lg:space-y-0 lg:space-x-5 ">

         <div class=" flex justify-center  lg:items-center  w-[100%] lg:w-[40%] border border-gray-300 shadow-md rounded-md ">
            <canvas ref="userPie"></canvas>
         </div>
         
         <div class="w-[100%] lg:w-[80%]   border border-gray-300 shadow-md rounded-md" >
            <canvas ref="analysis" class=""></canvas>
         </div>
               
      </div>

      

      <div class="flex justify-center items-center border-bot-only border-gray-600 shadow-md mb-[30px] mt-[50px] ">
         <span class="text-[24px] font-bold text-gray-500">TOP 10 STUDENTS</span>  
      </div>
         
      <section class="grid grid-cols-12 mt-4  shadow-md " >
         <div class="flex flex-col col-span-12  md:col-span-6 px-2 mb-4">
            <div class="flex justify-center items-center font-bold">HOME ECONOMICS</div>
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 ">
               <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                  <table class="min-w-full text-center text-sm font-light border-gray-200">
                     <thead
                        class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-green-600 border ">
                        <tr>
                        <th scope="col" class=" px-6 py-4 bg-gray">#</th>
                        <th scope="col" class=" px-6 py-4">First</th>
                        <th scope="col" class=" px-6 py-4">Last</th>
                        <th scope="col" class=" px-6 py-4">Grades</th>
                        </tr>
                     </thead>
                     <tbody class="border border-gray-200">
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">1</td>
                           <td class="whitespace-nowrap  px-6 py-4">Mark</td>
                           <td class="whitespace-nowrap  px-6 py-4">Villela</td>
                           <td class="whitespace-nowrap  px-6 py-4">98.75</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">2</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">97.5</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">3</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">96.3</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">4</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">95.0</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">5</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">92.0</td>
                        </tr>
                        
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="flex flex-col col-span-12  md:col-span-6 px-2 mb-4">
            <div class="flex justify-center items-center font-bold">ICT</div>
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
               <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                  <table class="min-w-full text-center text-sm font-light">
                     <thead
                        class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-green-600 border border-gray-200">
                        <tr>
                        <th scope="col" class=" px-6 py-4">#</th>
                        <th scope="col" class=" px-6 py-4">First</th>
                        <th scope="col" class=" px-6 py-4">Last</th>
                        <th scope="col" class=" px-6 py-4">Grades</th>
                        </tr>
                     </thead>
                     <tbody class="border border-gray-200">
                        <tr class="border-b dark:border-neutral-500 ">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">1</td>
                           <td class="whitespace-nowrap  px-6 py-4">Mark</td>
                           <td class="whitespace-nowrap  px-6 py-4">Villela</td>
                           <td class="whitespace-nowrap  px-6 py-4">98.75</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">2</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">97.5</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">3</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">96.3</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">4</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">95.0</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">5</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">92.0</td>
                        </tr>
                        
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>

         <div class="flex flex-col col-span-12  md:col-span-6 px-2 mb-4">
            <div class="flex justify-center items-center font-bold">INDUSTRIAL ARTS</div>
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
               <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                  <div class="">
                     <table class="min-w-full text-center text-sm font-light">
                        <thead
                           class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-green-600 border border-gray-200">
                           <tr>
                           <th scope="col" class=" px-6 py-4">#</th>
                           <th scope="col" class=" px-6 py-4">First</th>
                           <th scope="col" class=" px-6 py-4">Last</th>
                           <th scope="col" class=" px-6 py-4">Grades</th>
                           </tr>
                        </thead>
                        <tbody class="border border-gray-200">
                           <tr class="border-b dark:border-neutral-500">
                              <td class="whitespace-nowrap  px-6 py-4 font-medium">1</td>
                              <td class="whitespace-nowrap  px-6 py-4">Mark</td>
                              <td class="whitespace-nowrap  px-6 py-4">Villela</td>
                              <td class="whitespace-nowrap  px-6 py-4">98.75</td>
                           </tr>
                           <tr class="border-b dark:border-neutral-500">
                              <td class="whitespace-nowrap  px-6 py-4 font-medium">2</td>
                              <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                              <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                              <td class="whitespace-nowrap  px-6 py-4">97.5</td>
                           </tr>
                           <tr class="border-b dark:border-neutral-500">
                              <td class="whitespace-nowrap  px-6 py-4 font-medium">3</td>
                              <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                              <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                              <td class="whitespace-nowrap  px-6 py-4">96.3</td>
                           </tr>
                           <tr class="border-b dark:border-neutral-500">
                              <td class="whitespace-nowrap  px-6 py-4 font-medium">4</td>
                              <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                              <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                              <td class="whitespace-nowrap  px-6 py-4">95.0</td>
                           </tr>
                           <tr class="border-b dark:border-neutral-500">
                              <td class="whitespace-nowrap  px-6 py-4 font-medium">5</td>
                              <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                              <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                              <td class="whitespace-nowrap  px-6 py-4">92.0</td>
                           </tr>
                           
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>

         <div class="flex flex-col col-span-12  md:col-span-6  px-2 mb-4">
            <div class="flex justify-center items-center font-bold">SMAW</div>
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
               <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                  <table class="min-w-full text-center text-sm font-light">
                     <thead
                        class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-green-600 border border-gray-200">
                        <tr>
                        <th scope="col" class=" px-6 py-4">#</th>
                        <th scope="col" class=" px-6 py-4">First</th>
                        <th scope="col" class=" px-6 py-4">Last</th>
                        <th scope="col" class=" px-6 py-4">Grades</th>
                        </tr>
                     </thead>
                     <tbody class="border border-gray-200">
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">1</td>
                           <td class="whitespace-nowrap  px-6 py-4">Mark</td>
                           <td class="whitespace-nowrap  px-6 py-4">Villela</td>
                           <td class="whitespace-nowrap  px-6 py-4">98.75</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">2</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">97.5</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">3</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">96.3</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">4</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">95.0</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                           <td class="whitespace-nowrap  px-6 py-4 font-medium">5</td>
                           <td class="whitespace-nowrap  px-6 py-4 ">Jacob</td>
                           <td class="whitespace-nowrap  px-6 py-4">Pangilinan</td>
                           <td class="whitespace-nowrap  px-6 py-4">92.0</td>
                        </tr>
                        
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>
      </section>
      


   </DashboardLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayout from '../Layout/DashboardLayout.vue';
import DashboardCard from '../AdminComponents/DashboardCard.vue';
import { onMounted, ref } from 'vue';
import Chart from 'chart.js/auto';

const user = usePage().props.user;

const date = new(Date);
const year = date.getFullYear();
const data = defineProps({
   adminCount:Number,
   instructorCount:Number,
   studentCount:Number,
   guestCount:Number,
   currentSchoolYear:String,
   monthlyVisit:Array,
})

// const testData = [
//     { year: 2010, count: 10 },
//     { year: 2011, count: 20 },
//     { year: 2012, count: 15 },
//     { year: 2013, count: 25 },
//     { year: 2014, count: 22 },
//     { year: 2015, count: 30 },
//     { year: 2016, count: 28 },
//   ];

  const testData = [
    { year: 2010, count: 10 },
    { year: 2011, count: 20 },
    { year: 2012, count: 15 },
    { year: 2013, count: 25 },
    { year: 2014, count: 22 },
    { year: 2015, count: 30 },
    { year: 2016, count: 28 },
  ];

  const NUMBER_CFG = [{'count': 10}];
const currentSchoolYear = ref(null);

const analysis = ref(null);
const userPie = ref(null);
onMounted(()=>{
   currentSchoolYear.value = data.currentSchoolYear;

   const ctx = analysis.value.getContext('2d');
   
    new Chart(ctx, {
      type: 'bar',
      options: {
        animation: true,
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            enabled: true
          }
        }
      },
      data: {
        labels: data.monthlyVisit.map(row => row.month_name),
        datasets: [
          {
            label: 'Web page visitors per month',
            data: data.monthlyVisit.map(row => row.total_visits),
            borderColor: '#36A2EB',
            backgroundColor: '#057A55',
          },
          
          
        ]
      },
      options: {
         layout: {
               padding: {
                  left: 5,
                  top:10,
                  right:0,
                  bottom:0,
               },
         }
      }
    });

    const userPieCtx = userPie.value.getContext('2d');
    new Chart(userPieCtx, {
      type: 'pie',
      options: {
        animation: true,
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            enabled: true
          },
          title: {
            display: true,
            text: 'Chart.js Pie Chart'
         }
        }
      },
      data: {
        labels: ['Admins', 'Instructors', 'Students', 'Guest'],
        datasets: [
          {
            label: 'Users',
            data:[4, 8, 105,50],
            backgroundColor: ['#ff700a', '#ffeab8', '#a6deae', '#020E54'],
          },
         
        ]
      },
      options: {
         layout: {
               padding: {
                  left: 5,
                  top:10,
                  right:0,
                  bottom:0,
               },
         }
      }
    });

    
})
// chart.canvas.parentNode.style.height = '128px';
// chart.canvas.parentNode.style.width = '128px';
</script>

<style scoped>
  .chart-container {
    width: 70%; /* Ensure the container allows the canvas to take up the full width */
    height:100%; 
    /* position: relative;  */
    padding-left: 10px; 
    border: solid rgb(2, 36, 2) 2px; 
  }

  canvas {
    width: 100%; /* Make the canvas element 100% width */
    display: block; /* Remove any default inline-block styling */
  }
</style>