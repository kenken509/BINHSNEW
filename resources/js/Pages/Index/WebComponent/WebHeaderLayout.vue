<template>
    <div class="w-full flex justify-center  primary-bg-green ">
        <div class=" w-[90%]  lg:w-[80%]  flex items-center justify-between ">
            <div class="flex items-center my-4 w-full gap-2 mr-2">
                <img src="../../../../../public/images/webPage/logo1.png" alt="error"  class="w-[80px] h-[80px] lg:w-[150px] lg:h-[150px]" />
                <div class=" w-full flex flex-col justify-center">
                    <h1 class="flex text-[16px] border-bot-only lg:text-[20px] border-[#ecf4ed] text-[#ecf4ed] tracking-wider">Bulihan, Silang, Cavite</h1>
                    
                    <h1 class="flex   lg:text-[30px] font-bold text-[#ecf4ed] tle-title">Technology and Livelihood Education</h1>
                    <h1 class="flex   text-[14px] lg:text-[30px]  text-[#ecf4ed] lg:hidden tracking-wider text-[20px]">Technology and Livelihood Education</h1>
                </div>
            </div>
            <div class="relative my-4">
                <img src="../../../../../public/images/webPage/logo1.png" alt="error" class=" mr-4 w-[80px] h-[80px] lg:w-[150px] lg:h-[150px] ">
                <div class="absolute top-[8px] left-4 lg:top-[20px] lg:left-8 font-extrabold text-[#f71f00] text-[14px] lg:text-[24px]">TLE LOGO HERE</div>
            </div>
            
        </div>
    </div>
    
    
</template>

<script setup>

</script>

<style scoped>
    @media (max-width:768px){
        .tle-logo{
            display: none;
        }
        .tle-title{
            display: none;
        }
    }
</style>