<template>
    <div class="w-full flex justify-center  primary-bg-green ">
        <div class=" w-[90%]  lg:w-[80%]  flex items-center justify-between ">
            <div class="flex items-center my-4 w-full gap-2 mr-2">
                <img src="../../../../../public/images/webPage/logo1.png" alt="error"  class="w-[80px] h-[80px] lg:w-[150px] lg:h-[150px]" />
                <div class=" w-full flex flex-col justify-center">
                    <h1 class="flex text-[11px] md:text-[16px] border-bot-only lg:text-[20px] border-[#ecf4ed] text-gray-200 tracking-wider py-1 font-serif">Bulihan, Silang, Cavite</h1>
                    <h1 class="flex text-[13px] md:text-[20px]  lg:text-[25px] xl:text-[30px] font-serif text-gray-100 tracking-wider ">Technology and Livelihood Education</h1>
                    
                    
                    
                </div>
            </div>
            <div class="relative my-4">
                <img src="/storage/Images/tleLogo.jpg" alt="error" class="mr-4 w-[70px] h-[70px] lg:w-[130px] lg:h-[130px] tle-logo-hide rounded rounded-full">
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
    }
    @media (max-width:426px)
    {
        .tle-logo-hide{
            display: none;
        }
    }

    
</style>