<template>
        <div  class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 pointer-events-none w-full ">
            <div   class="flex justify-center items-center flex-col" >
                
                <ProgressSpinner  style="width: 50px; height: 50px;" strokeWidth="4" fill="none" animationDuration="1s" aria-label="Custom ProgressSpinner" />
                <span class="flex items-baseline mt-2 ">
                    Getting access to:&nbsp; <span class="text-blue-600">{{data.installerLink}}&nbsp;</span>
                    <span class="flex items-baseline mt-2 ellipsis space-x-0">
                        <span class="text-[14px] font-bold">.</span>
                        <span class="text-[14px]">.</span>
                        <span class="text-[14px]">.</span>
                    </span>
                </span>
            </div>                           
        </div>
</template>
<script setup>
import { ref } from 'vue'

const data = defineProps({
    installerLink:String,
})

const installerLink = ref('https test muna');

</script>

<style scoped>
    @keyframes ellipsis {
    0%, 75% {
        opacity: 0;
    }
    25%, 100% {
        opacity: 1;
    }
    }

    .ellipsis span {
    display: inline-block;
    width: 1em;
    overflow: hidden;
    vertical-align: bottom;
    animation: ellipsis 1.5s infinite steps(4);
    }

    .ellipsis span:nth-child(1) {
    animation-delay: 0.25s;
    }

    .ellipsis span:nth-child(2) {
    animation-delay: 0.5s;
    }

    .ellipsis span:nth-child(3) {
    animation-delay: 0.75s;
    }
</style>