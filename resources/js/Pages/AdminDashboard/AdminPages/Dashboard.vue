<template>
    <DashboardLayout :user="user">
        <div
            class="flex justify-between border-bot-only border-gray-600 shadow-md mb-[30px]"
        >
            <span class="text-[20px] font-bold text-gray-500"
                >Admin Dashboard</span
            >
            <span class="text-[20px] font-bold text-gray-500"
                >School year: {{ currentSchoolYear }}</span
            >
        </div>
        
        
        
        <section class="grid grid-cols-12 mt-4">
            <div class="col-span-12 md:col-span-3">
                <DashboardCard
                    :title="'ADMINS'"
                    :currentCount="data.adminCount"
                    :previousCount="data.adminPrevYearCount"
                    :arrow="'pi pi-angle-down text-red-500'"
                    :textColor="'text-red-500'"
                    :evaluation="'decreased'"
                ></DashboardCard>
                
            </div>
            <!-- <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <DashboardCard :title="'INSTRUCTORS'" :value="10" :percentage="10" :arrow="'pi pi-angle-down text-red-500'" :textColor="'text-red-500'" :evaluation="'decreased'"></DashboardCard>
         </div> -->

            <div class="col-span-12 md:col-span-3">
                <DashboardCard
                    :title="'STUDENTS '"
                    :currentSchoolYear="currentSchoolYear"
                    :currentCount="data.studentCount"
                    :previousCount="data.studentPrevYearCount"
                    :arrow="'pi pi-angle-up text-[#2a9e66]'"
                    :textColor="'text-green-500'"
                    :evaluation="'increased'"
                ></DashboardCard>
            </div>

            <div class="col-span-12 md:col-span-3">
                <DashboardCard
                    :title="'INSTRUCTORS'"
                    :currentCount="data.instructorCount"
                    :previousCount="data.instructorPrevYearCount"
                    :arrow="'pi pi-angle-up text-red-500'"
                    :textColor="'text-red-500'"
                    :evaluation="'increased'"
                ></DashboardCard>
            </div>
            <div class="col-span-12 md:col-span-3">
                <DashboardCard
                    :title="'GUESTS'"
                    :currentCount="data.guestCount"
                    :previousCount="data.guestPrevYearCount"
                    :arrow="'pi pi-angle-up text-red-500'"
                    :textColor="'text-red-500'"
                    :evaluation="'increased'"
                ></DashboardCard>
            </div>
            <!--flowbite tables-->

            <!--flowbite tables-->
        </section>

        <div></div>
        <div class="w-full mt-4 px-2">
            <hr class="border-t-2 border-gray-300" />
        </div>
        <div class="flex justify-center items-center py-4">
            <div>
                <span class="text-[20px] text-gray-500"
                    >Data as of School Year : {{ currentSchoolYear }}</span
                >
            </div>
        </div>

        <div
            class="flex flex-col items-center lg:flex-row space-y-5 lg:space-y-0 lg:space-x-5"
        >
            <div
                class="flex flex-col justify-center lg:items-center w-[100%] lg:w-[40%] border border-gray-300 shadow-md rounded-md"
            >
                <div class="py-4 text-gray-500">USER'S DATA</div>
                <div class="w-full px-2">
                    <hr class="border-t-2 border-gray-300" />
                </div>

                <canvas ref="userPie"></canvas>
            </div>

            <div
                class="flex flex-col justify-center items-center w-[100%] lg:w-[80%] border border-gray-300 shadow-md rounded-md"
            >
                <div class="py-4 text-gray-500">WEB ANALYSIS DATA</div>
                <div class="w-full px-2">
                    <hr class="border-t-2 border-gray-300" />
                </div>
                <canvas ref="analysis" class=""></canvas>
            </div>
        </div>
         
        <div v-if="user.role === 'instructor' && data.instructorTopTen.length > 1">
            <TopTenCard :instructorTopTen="data.instructorTopTen" />
        </div>
        <!-- <div class="flex justify-center items-center border-bot-only border-gray-600 shadow-md mb-[30px] mt-[50px] ">
         <span class="text-[24px] font-bold text-gray-500">TOP 10 STUDENTS</span>  
      </div> -->

        <!-- <section class="grid grid-cols-12 mt-4  shadow-md " >
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
      </section> -->
    </DashboardLayout>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import DashboardLayout from "../Layout/DashboardLayout.vue";
import DashboardCard from "../AdminComponents/DashboardCard.vue";
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";
import TopTenCard from "../../Index/WebComponent/TopTenCard.vue";

const user = usePage().props.user;

const date = new Date();
const year = date.getFullYear();
const data = defineProps({
    adminPrevYearCount:Number,
    studentPrevYearCount:Number,
    instructorPrevYearCount:Number,
    guestPrevYearCount:Number,
    adminCount: Number,
    instructorCount: Number,
    studentCount: Number,
    guestCount: Number,
    currentSchoolYear: String,
    monthlyVisit: Array,
    usersData: Array,
    windowsMonthlyDownloads: Array, // [{"year":2023,"month":1,"count":5}]
    androidMonthlyDownloads: Array, // [{"year":2023,"month":1,"count":5}]
    instructorTopTen: Array,
});

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
    {
        role: "Admins",
        count: "5",
    },
    {
        role: "Instructors",
        count: "10",
    },
    {
        role: "Students",
        count: "15",
    },
    {
        role: "Guests",
        count: "10",
    },
];

//   const calculatedTestData = [
//     {
//       'role':'Admins',
//       'percent': '25',

//     },
//     {
//       'role':'Instructors',
//       'percent': '25',
//     },
//     {
//       'role':'Students',
//       'percent': '25',
//     },
//     {
//       'role':'Guests',
//       'percent': '25',
//     }
//   ];

// Step 1: Find the total count
const totalCount = data.usersData.reduce(
    (sum, role) => sum + parseInt(role.count),
    0
);

// Step 2 and 3: Calculate percentages and create calculatedTestData
const calculatedData = data.usersData.map((role) => ({
    role: role.role,
    percent: ((parseInt(role.count) / totalCount) * 100).toFixed(2),
}));

const NUMBER_CFG = [{ count: 10 }];
const currentSchoolYear = ref(null);

const analysis = ref(null);
const userPie = ref(null);


onMounted(() => {
    currentSchoolYear.value = data.currentSchoolYear;

  
    const ctx = analysis.value.getContext("2d");


    new Chart(ctx, {
        type: "bar",
        options: {
            animation: true,
            plugins: {
                legend: {
                    display: true,
                },
                tooltip: {
                    enabled: true,
                },
            },
            layout: {
                padding: {
                    left: 5,
                    top: 10,
                    right: 0,
                    bottom: 0,
                },
            },
            onHover: (event, chartElement) => {
                analysis.value.style.cursor = chartElement[0]
                    ? "pointer"
                    : "default";
            },
        },
        data: {
            labels: data.monthlyVisit.map((row) => row.month_name),
            datasets: [
                {
                    label: "Winddows installer download attempt", //windowsMonthlyDownloads:Array, // [{"year":2023,"month":1,"count":5}]
                    data: data.windowsMonthlyDownloads.map((row) => row.count), // ['#ff700a', '#ffeab8', '#a6deae', '#020E54'],
                    borderColor: "#36A2EB",
                    backgroundColor: "#ffeab8",
                },
                {
                    label: "Android installer download attempt",
                    data: data.androidMonthlyDownloads.map((row) => row.count),
                    borderColor: "#36A2EB",
                    backgroundColor: "#a6deae",
                },
                {
                    label: "Web page visitors per month",
                    data: data.monthlyVisit.map((row) => row.total_visits),
                    borderColor: "#36A2EB",
                    backgroundColor: "#057A55",
                },
            ],
        },
    });

    const userPieCtx = userPie.value.getContext("2d");
    const chart = new Chart(userPieCtx, {
        type: "pie",
        options: {
            animation: true,
            plugins: {
                legend: {
                    display: true,
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: (context) => {
                            const label = context.dataset.label || "";
                            const value = context.parsed.toFixed(2);
                            return `${label}: ${value} %`;
                        },
                    },
                },
            },
            layout: {
                padding: {
                    left: 20,
                    top: 20,
                    right: 20,
                    bottom: 20,
                },
            },
            events: ["mousemove"], // Use 'mousemove' event for hover
            onHover: (event, chartElements) => {
                userPie.value.style.cursor = chartElements[0]
                    ? "pointer"
                    : "default";
            },
        },
        data: {
            labels: calculatedData.map((row) => row.role),
            datasets: [
                {
                    label: " Users",
                    data: calculatedData.map((row) => row.percent),
                    backgroundColor: [
                        "#ff700a",
                        "#ffeab8",
                        "#a6deae",
                        "#020E54",
                    ],
                },
            ],
        },
    });
});
// chart.canvas.parentNode.style.height = '128px';
// chart.canvas.parentNode.style.width = '128px';
</script>

<style scoped>
.chart-container {
    width: 70%; /* Ensure the container allows the canvas to take up the full width */
    height: 100%;
    /* position: relative;  */
    padding-left: 10px;
    border: solid rgb(2, 36, 2) 2px;
}

canvas {
    width: 100%; /* Make the canvas element 100% width */
    display: block; /* Remove any default inline-block styling */
}
</style>
