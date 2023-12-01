<template>
    <div class="flex flex-col items-center justify-center border border-5 border-red-500 h-screen w-full">
        <div>
            my chart
        </div>
        <div>
            
        <div style="width: 400px;">
            <canvas ref="acquisitionsCanvas"></canvas>
        </div>
        </div>
    </div>
    
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import Chart from 'chart.js/auto';
  
  const analysis = defineProps({
    monthlyVisit:Array,
  })

  const data = [
    { year: 2010, count: 10 },
    { year: 2011, count: 20 },
    { year: 2012, count: 15 },
    { year: 2013, count: 25 },
    { year: 2014, count: 22 },
    { year: 2015, count: 30 },
    { year: 2016, count: 28 },
  ];

  

  // const data = [
  //   { day: Monday, count: 10 },
  //   { day: Tuesday, count: 20 },
  //   { day: Wednesday, count: 15 },
  //   { day: Thursday, count: 25 },
  //   { day: Friday, count: 22 },
  //   { day: Saturday, count: 30 },
  //   { day: Sunday, count: 28 },
  // ];
  
  const acquisitionsCanvas = ref(null);
  
  onMounted(() => {
    const ctx = acquisitionsCanvas.value.getContext('2d');
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
        labels: analysis.monthlyVisit.map(row => row.month_name),
        datasets: [
          {
            label: 'Visitors per month',
            data: analysis.monthlyVisit.map(row => row.total_visits)
          },
          
        ]
      }
    });
  });
  </script>
  