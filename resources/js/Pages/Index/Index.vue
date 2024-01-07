<template>
    
    <div class=" flex justify-center">
        
            <WebNavLayout2 :currentUser="user"  >
           
            </WebNavLayout2>
      
    </div>
    
    <div class="flex justify-center ">
        <div class="w-full max-h-[500px] overflow-hidden ">
            <WebHeaderLayout/> 
        </div>
    </div>
  
    <!--divider-->
    <div class=" h-[40px] border shadow-md "></div>
    
    <div v-if="$page.props.flash.success" >{{ successMessage($page.props.flash.success) }} </div>
    <div v-if="$page.props.flash.error" >{{ errorMessage($page.props.flash.error) }} </div>

    <!--NEW CAROUSEL-->
    <div class="flex justify-center overflow-hidden">
      <div class="w-[90%] lg:w-[86%] mt-10  max-h-[200px] md:max-h-[400px] lg:max-h-[1020px]  flex justify-center ">
        <Carousel :value="data.carouselImages" :numVisible="1" :numScroll="1" :responsiveOptions="responsiveOptions" circular :autoplayInterval="5000">
          <template #item="slotProps">
              <div class="border-1 surface-border border-round  w-[100%] flex justify-center items-center object-cover relative ">
                  <div class="mb-3  w-[90%] ">
                      <img :src="'/storage/'+slotProps.data.filename" :alt="slotProps.data.name" class="w-full h-full shadow-md max-h-[500px]  " />
                  </div>
                  <div v-if="user && user.role === 'admin'" class=" absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white bg-opacity-[75%] pt-2 pb-1 px-1 rounded-md md:p-4 md:rounded-xl shadow-xl  ">
                    <div class="flex space-x-3 md:space-x-6 ">
                      <div @click="hadleDeleteClick(slotProps.data.id)">
                        <i class="pi  pi-trash text-red-600  hover:cursor-pointer " v-tooltip.left="'Delete Image'" style="font-size: calc(1vw + 1rem);"></i>
                      </div>
                        
                      <div  @click="handleReplaceImageClick(slotProps.data.id)">
                        <i class="pi  pi-pencil text-green-600 hover:cursor-pointer" v-tooltip.left="'Replace Image'" style="font-size: calc(1vw + 1rem);"></i>
                         <input ref="fileInput" type="file" class="hidden" @change="handleFileChange"  /> 
                      </div>
                      <div @click="handleAddImageClick">
                        <i class="pi  pi-plus text-green-600 hover:cursor-pointer" v-tooltip.left="'Add Image'" style="font-size: calc(1vw + 1rem);"></i>
                        <input ref="addFileInput" type="file" class="hidden" @change="handleAddFileChange"  /> 
                      </div>
                    </div>
                  </div>
              </div>
          </template>
        </Carousel>
      </div>
    </div>
    <!--NEW CAROUSEL-->
     
    <!--divider-->
    <hr>
   <div>
    
   </div>
    <div class="flex justify-center w-full mt-4">
        <div class="flex justify-center mt-8 w-[90%] lg:w-[80%]">
            <span class="font-serif text-[30px] lg:text-[50px] tracking-wider  text-gray-800 ">Latest News</span>
        </div>
    </div>
    
    <div class="flex justify-center  ">
        <div class="w-[90%] lg:w-[80%]">
           <IndexCard :newsPost="newsPost"/>
        </div>
    </div>
    <div class=" h-[40px] border shadow-md "></div>
    <div class="flex mt-4 w-full ">
        <div class="flex justify-center items-center  overflow-hidden  ">
            <WebFooter />
        </div>

    </div>
    
</template>



<script setup>
import IndexCard from './IndexComponent/IndexCard.vue';
import WebNavLayout2 from './WebComponent/WebNavLayout2.vue';
import Swal from 'sweetalert2';
import { computed } from '@vue/reactivity';
import { useForm, usePage } from '@inertiajs/vue3';
import WebHeaderLayout from './WebComponent/WebHeaderLayout.vue'
import WebCarousel from './WebComponent/WebCarousel.vue';
import WebFooter from './WebComponent/WebFooter.vue';
import { router } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount, resolveDirective } from 'vue'
import { DialogDescription } from '@headlessui/vue';



const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '1199px',
        numVisible: 1,
        numScroll: 1
    },
    {
        breakpoint: '767px',
        numVisible: 1,
        numScroll: 1
    },
    {
        breakpoint: '575px',
        numVisible: 1,
        numScroll: 1
    }
]);

const data =  defineProps({
  currentUrl: String,
  carouselImages: Array,
  newsPost: Object,
})

const user = computed(() => usePage().props.user);
const clicked = ref(false)

const handleClick = () => {
  clicked.value = true
}




onMounted(() => {
  document.addEventListener('click', handleClick);

  const isFirstVisit = sessionStorage.getItem('firstVisit');
  

  if (!isFirstVisit) {
    // If it's the first visit, set the variable to true and store it in sessionStorage
    sessionStorage.setItem('firstVisit', 'true');

    // Store information in the database (simulated asynchronous operation)
    // Replace this with your actual database integration logic
    recordVisit();
  }
})

function successMessage(message) {
  Swal.fire({
    title: 'Success',
    text: message + '!',
    icon: 'success',
    allowOutsideClick: false,
    allowEscapeKey: false
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}

const flashClear = useForm({
  clear: null,
})

const record = useForm({
    type:'visit',
})

function errorMessage(message) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: message + '!',
    allowOutsideClick:false,
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}

const checkFirstVisit = () => {
  return !localStorage.getItem('firstVisit');
};

async function recordVisit() {
  try {
        await record.post(route('analytics.store'), { preserveScroll: true });
        console.log('Visit recorded successfully!');
    } catch (error) {
        console.error('Error recording visit:', error.message);
    }
}

//carousel crud operation logic
const form = useForm({
  id:null,
  filename:null,
})

const fileInput = ref(null); // Create a ref for fileInput

const handleReplaceImageClick = (imageId)=>{
  form.id = imageId;
  fileInput.value.click();
}

function carouselError(error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: error,
      color:'#fd4848',
      allowOutsideClick:false,
    }).then((result) => {
      if (result.isConfirmed) {
        flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
      }
    })
}

const handleFileChange = (event) => {
  // Handle the file change event here if needed
    

    if(!event.target.files[0].type || (event.target.files[0].type !== 'image/jpeg' && event.target.files[0].type !== 'image/jpg') || event.target.files[0].size > 3000000)
    {
        const errorMessage = 'File type must be JPG with maximum size of 3mb'
        console.log(event.target.files[0].type)
        carouselError(errorMessage)
        
    }
    else{
      form.filename = event.target.files[0];
      form.post(route('carousel.replace.image'))
    }
    
};


//add carousel image
const addForm = useForm({
  filename:null,
})

const addFileInput = ref(null)

const handleAddImageClick = ()=>{
    addFileInput.value.click();
}

const handleAddFileChange = (event) => {

  
  if(!event.target.files[0].type || (event.target.files[0].type !== 'image/jpeg' && event.target.files[0].type !== 'image/jpg') || event.target.files[0].size > 3000000 )
    {
        const errorMessage = 'File type must be JPG with maximum size of 3mb'
        console.log(event.target.files[0].type)
        carouselError(errorMessage)
        
    }
    else{
      addForm.filename = event.target.files[0];
      addForm.post(route('carousel.add.image'))
    }
}



// delete carousel image
function hadleDeleteClick(imageId)
{
  Swal.fire({
      title:'Deletion Confirmation',
      text:"You won't be able to revert this action!",
      icon:"warning",
      showCancelButton:true,
      confirmButtonText:'Yes, delete it!',
      cancelButtonText:'Cancel',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      allowOutsideClick:false,
      allowEscapeKey:false,
  }).then((result)=>{
      if(result.isConfirmed)
      {
          const deleteUrl = route('carousel.delete.image', {id:imageId})

          router.delete(deleteUrl);
      }

      if(result.isDismissed)
      {
          Swal.fire({
              title:'Canceled',
              text:'Your action was canceled!',
              icon:'error',
              confirmButtonColor: '#3085d6',
          })
      }
  })

}
</script>

<!-- <style>
  @media (max-width: 600px) {
    .pi-trash {
      font-size: 1vw;
    }
  }

  @media (min-width: 601px) and (max-width: 1024px) {
    .pi-trash {
      font-size: 1.25rem;
    }
  }

  @media (min-width: 1025px) {
    .pi-trash {
      font-size: 1.5rem;
    }
  }
</style> -->