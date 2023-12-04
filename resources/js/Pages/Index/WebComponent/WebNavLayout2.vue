<template>
    <nav class="flex justify-center w-full bg-white">
        <div class="p-5 w-full    lg:w-[80%] lg:flex  lg:justify-center lg:justify-between lg:items-center" >
            <!--left elements-->
            <div class="lg:flex lg:justify-center lg:text-center ">
                <div class="flex flex-row justify-between items-center">
                    <span class="flex  items-center text-2xl gap-2">
                        <!-- <img :src="logo" alt="error" class="h-14 inline logo"/>  -->
                        <a :href="route('index')" class="font-bold text-4xl hover:text-cyan-500 duration-500">BINHS</a>
                    </span>
                    <span class="lg:hidden">
                        <i class="pi pi-align-justify cursor-pointer hover:text-green-600" style="font-size: 24px;" @click="openMenu" name="menu"></i>
                    </span>
                </div>
                <ul class="lg:flex lg:items-center  hidden  left-ul  ">
                    <li class="mx-4 my-4">
                        <a :href="route('index')" class="text-xl hover:text-cyan-500 duration-500">Home</a>
                    </li>
                    <li class="mx-4 my-4">
                        <a :href="route('index.about')" class="text-xl hover:text-cyan-500 duration-500">About</a>
                    </li>
                    <li class="mx-4 my-4">
                        <a :href="route('index.contact')" class="text-xl hover:text-cyan-500 duration-500">Contacts</a>
                    </li>
                    <li class="mx-4 my-4">
                        <a :href="route('index.downloads')" class="text-xl hover:text-cyan-500 duration-500">Downloads</a>
                    </li>
                    <li class="mx-4 my-4">
                        <a :href="route('index.news')" class="text-xl hover:text-cyan-500 duration-500">News</a>
                    </li>
                <!--trial link-->
                    <li v-if="user.currentUser && user.currentUser.role === 'student'" class="mx-4 my-4">
                        <a :href="route('test.quiz')" class="text-xl hover:text-cyan-500 duration-500">Test Quiz</a>
                    </li>
                <!--trial link-->
                    <li class="flex items-center mx-4" @click="tleClickHandler" >
                        <a href="#" class="text-xl hover:text-cyan-500 duration-500">TLE Tracks</a>
                        <i class="pi pi-angle-down cursor-pointer" style="font-size: 2rem" ></i>
                        <div :class="tleDropdownClass" >
                            <div class="absolute flex flex-col  p-4 right:-[20px] top-[-12px] md:right-[0px] md:top-[20px] bg-green-600 rounded rounded-md ">
                                <div class="flex justify-start my-2 hover:bg-gray-200 w-[150px] rounded ">
                                    <a :href="route('strand.showAgriFisheryArts')" class="  cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200">
                                        Agri-Fishery Arts
                                    </a>
                                    
                                </div>
                                <div class="flex justify-start  my-2  hover:bg-gray-200 rounded duration-500">
                                    <a :href="route('strand.showHE')" class="  cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200">
                                        Home Economics
                                    </a>
                                    
                                </div>
                                <div class="flex justify-start my-2  hover:bg-gray-200 rounded duration-500 bg-red">
                                    <a :href="route('strand.showICT')" class="  cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200">
                                        ICT
                                    </a>
                                    
                                </div>
                                <div class="flex justify-start my-2  hover:bg-gray-200 rounded duration-500">
                                    <a :href="route('strand.showIA')" class="  cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200">
                                        Industrial Arts
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!--left elements-->

            <!--right elements-->
           
            <div v-if="user.currentUser" >
                <ul class="lg:flex lg:flex-row gap-3 justify-center items-center right-ul hidden  ">
                    <li v-if="user.currentUser.role === 'admin' || user.currentUser.role === 'instructor'" class="mx-4 my-4 lg:my-0 cursor-pointer hover:text-cyan-500 duration-500 text-xl">
                        <a :href="route('admin.showAdminPanel')" class="text-xl hover:text-cyan-500 duration-500">Dashboard</a>
                    </li>
                    <div >
                        <li class="mx-4 lg:mx-0 cursor-pointer " @click="accountDropDownClickHandler">
                            
                            <img :src="userImage" alt="image" class="h-14 w-14 rounded-full hide-on-table "  />
                            <button class="lg:hidden bg-green-700 rounded-md text-gray-100 p-2">{{toUpperFirst(user.currentUser.role)}} {{ user.currentUser.fName ? toUpperFirst(user.currentUser.fName):null }}</button>
                        </li>
                        <div>
                            <div :class="accountDropDownClass" >
                                <div class="absolute  flex flex-col z-[10] top-[-40px] left-[120px] lg:top-1 lg:left-[-125px] bg-green-600 p-4   rounded rounded-md ">
                                    <div class="my-2 hover:bg-gray-200 w-[150px] rounded ">
                                        <a :href="route('user.profile.edit',{id:currentUser.id})" class=" cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200">Manage Account</a>
                                    </div>
                                    <div class=" my-2  hover:bg-gray-200 rounded duration-500">
                                        <a :href="route('forgot.password.show')" class=" cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200">Change Password</a>
                                    </div>
                                    <div class="my-2  hover:bg-gray-200 rounded duration-500">
                                        <Link
                                        class=" cursor-pointer  pl-2 text-gray-100 hover:text-gray-950 duration-500 duration-200"
                                        :href="route('logout')"
                                        data-te-dropdown-item-ref
                                        method="delete"
                                        as="button"
                                        >Logout</Link
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
            <div v-else class=" lg:flex lg:flex-row md:flex-row gap-5 right-ul hidden  my-4 lg:my-0">
                <div class="mx-4 my-4 lg:my-0">
                    <a
                    class="text-xl hover:text-cyan-500 duration-500 "
                    :href="route('login')"
                    data-te-nav-link-ref
                    >
                        Sign In
                    </a> 
                </div>
                <div class="mx-4 my-4 lg:my-0">
                    <a
                    class="text-xl hover:text-cyan-500 duration-500 "
                    :href="route('register.guest')"
                    data-te-nav-link-ref
                    >
                        Register
                    </a> 
                </div>
            </div>
            

        </div>
        
        
    </nav>
   
</template>

<script setup>
import {ref, watch} from 'vue'
import {toUpperFirst} from '../../Functions/Methods.vue'
import {Link} from '@inertiajs/vue3'

const userImage = user.currentUser ?  (user.currentUser.image ? '/storage/'+user.currentUser.image: '/storage/Images/default.png') : '/storage/Images/default.png'                       
const logo = 'images/webPage/logo1.png'

const tleDropdownClass = ref('hidden') ;
const tleVisible = ref(false);
const tleMenuClick = ref(false);

const accountDropDownClass = ref('hidden');
const accountDropDownVisible = ref(false);
const accountDropDownClick = ref(false);

const user = defineProps({
    currentUser:Object,
    click:Boolean
})

const tleClickHandler = ()=>{
    tleVisible.value = !tleVisible.value
    accountDropDownVisible.value = false
    
    console.log("tleVisible: "+tleVisible.value);
    console.log("accountDropDownVisible: "+accountDropDownVisible.value);

    if(tleVisible.value === true)
    {
        tleDropdownClass.value = 'relative'
        accountDropDownClass.value = 'hidden'
    }
    else
    {
        tleDropdownClass.value = 'hidden'
    }
    
    console.log(tleDropdownClass.value)
}

const accountDropDownClickHandler = ()=>{
    accountDropDownVisible.value = !accountDropDownVisible.value
    tleVisible.value = false
    
    console.log("tleVisible: "+tleVisible.value);
    console.log("accountDropDownVisible: "+accountDropDownVisible.value);
    if(accountDropDownVisible.value === true)
    {
        accountDropDownClass.value = 'relative'
        tleDropdownClass.value = 'hidden'
    }
    else
    {
        accountDropDownClass.value = 'hidden'
    }
}


    const openMenu = () => {
        let leftElement = document.querySelector(".left-ul");
        let rightElement = document.querySelector(".right-ul")

        if (leftElement) {
            leftElement.classList.toggle('hidden');
            leftElement.classList.toggle('opacity-100');
        }

        if(rightElement)
        {
            rightElement.classList.toggle('hidden');
        }
    }
    
    // Call openMenu() when needed


</script>



<style scoped>
/* .hide-on-table {
  display: none; 
} */


.myStyle{
    display: none;
}

@media  (min-width: 1024px) {
    .logo {
        display:none;
    }
}

@media (max-width: 768px) { /* Adjust the breakpoint according to your design */
  .hide-on-table {
    display: none; /* Show the element when the view size is "table" */
  }
}
</style>