<template>
    <div>
        <div class="bg-white fixed top-0 w-full md:px-[100px]  left-[50%] translate-x-[-50%] z-[50] shadow-md ">
            <nav
            class="flex-nowrap relative flex w-100 items-center  justify-between bg-green-[#f7f7f7] py-4  shadow-black/5 dark:bg-gray-[#f7f7f7] dark:shadow-black/10 lg:flex-wrap lg:justify-start   top-0 z-50"
            data-te-navbar-ref>
                <div class="flex w-full flex-wrap items-center justify-between px-2 ">
                    <div
                    class="!visible  flex-grow basis-[100%] items-center lg:!flex lg:basis-auto space-x-4 "
                    id="navbarSupportedContent1"
                    data-te-collapse-item>
                    
                        <a
                            class="mt-2 mr-2 flex items-center text-neutral-900 hover:text-neutral-900 focus:text-neutral-900 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400 lg:mt-0 "
                            :href="route('index')">
                            <img :src="logo" class="w-14 h-14"/>
                            <h1 class="text-3xl font-semibold primary-text-black">BINHS</h1>
                            
                        </a>
                    
                        <!-- Left links -->
                        <div class="md:flex md:flex-between w-auto md:w-full md:items-center  px-4 ">
                            <ul
                                class="list-style-none mr-auto flex flex-col pl-0 lg:flex-row md:space-x-4  "
                                data-te-navbar-nav-ref>
                                <li class="lg:pr-2 my-3 md:my-0" data-te-nav-item-ref>
                                    <a
                                        class="nav"
                                        :href="route('index')"
                                        data-te-nav-link-ref
                                        >Home</a
                                    >
                                
                                
                                </li>
                                <li class="lg:pr-2 my-3 md:my-0" data-te-nav-item-ref>
                                    <a
                                    class="nav"   
                                    :href="route('index.about')"
                                    data-te-nav-link-ref
                                        >About</a
                                    >
                                
                                </li>
                                
                                <li class="lg:pr-2 my-3 md:my-0" data-te-nav-item-ref>
                                    <a
                                        class="nav"  
                                        :href="route('index.contact')"
                                        data-te-nav-link-ref
                                        >Contact</a
                                    >
                                </li>
                            
                                <li class="lg:pr-2 my-3 md:my-0" data-te-nav-item-ref>
                                    <a
                                        class="nav"   
                                        :href="route('index.downloads')"
                                        data-te-nav-link-ref
                                        >Downloads</a
                                    >
                                </li>
                            
                                <li class="lg:pr-2 my-3 md:my-0" data-te-nav-item-ref>
                                    <a
                                        class="nav" 
                                        :href="route('index.news')"
                                        data-te-nav-link-ref
                                        >News</a
                                    >
                                </li>

                                
                                <!--Strands menu-->
                                <div  class="relative" data-te-dropdown-ref>
                                <a
                                class="hidden-arrow mr-4 flex items-center text-neutral-500 hover:text-neutral-700 focus:text-gray-400 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 [&.active]:text-black/90 dark:[&.active]:text-neutral-400"
                                href="#"
                                id="dropdownMenuButton1"
                                role="button"
                                data-te-dropdown-toggle-ref
                                aria-expanded="false">
                                    <a class="nav my-3 md:my-0">TLE Track</a>
                                    <span class="ml-2 w-2 primary-text-black  hover:text-gray-600  focus:text-gray-500">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="h-5 w-5">
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </a>
                                
                                <ul
                                class="absolute left-auto right-0 z-[1000] float-left m-0 mt-1 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                aria-labelledby="dropdownMenuButton1"
                                data-te-dropdown-menu-ref>
                                <li>
                                    <a
                                    class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                    :href="route('strand.showAgriFisheryArts')"
                                    data-te-dropdown-item-ref
                                    >Agri-Fishery Arts</a
                                    >
                                </li>
                                <li>
                                    <a
                                    class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                    :href="route('strand.showHE')"
                                    data-te-dropdown-item-ref
                                    >Home Economics</a
                                    >
                                </li>
                                <li>
                                    <a
                                    class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                    :href="route('strand.showICT')"
                                    data-te-dropdown-item-ref
                                    >ICT</a
                                    >
                                </li>
                                <li>
                                    <a
                                    class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                    :href="route('strand.showIA')"
                                    data-te-dropdown-item-ref
                                    >Industrial Arts</a
                                    >
                                </li>
                                
                                </ul>
                                </div>
                                
                                <li v-if="currentUser" class="lg:pr-2" data-te-nav-item-ref >
                                    <div v-if="currentUser.role === 'student'">
                                        <a
                                        class="nav"   
                                        :href="route('studentExamination.show')"
                                        data-te-nav-link-ref
                                        >Student Portal</a
                                    >
                                    </div>
                                </li>
                            

                            </ul>
                            <!--start ng copy ko-->
                            <div class="relative flex items-justify md:items-center flex-col md:flex-row space-x-4  md:mx-4 my-4 md:mx-0">
                                
                                <div v-if="currentUser" class="lg:pr-2" data-te-nav-item-ref>
                                    <a
                                        v-if="currentUser.role==='admin' || currentUser.role==='instructor' "
                                        class="primary-text-black  hover:text-gray-600  focus:text-gray-400 focus:border-bot-only-focus"
                                        :href="route('admin.showAdminPanel')"
                                        data-te-nav-link-ref
                                        >Dashboard</a
                                    >
                                </div>
                                <p   v-if="currentUser" class="primary-text-black">Welcome Back {{ currentUser.role }} {{ currentUser.fName }} <span class="primary-text-black text-lg">{{ currentUser.name }}</span> </p>
                                <div v-else class=" flex flex-col md:flex-row gap-5 ">
                                    <div>
                                        <a
                                        class="text-indigo-700  hover:text-indigo-400  focus:text-gray-400 hover:scale-110 "
                                        :href="route('login')"
                                        data-te-nav-link-ref
                                        >
                                            Sign In
                                        </a> 
                                    </div>
                                <div>
                                        <a
                                        class="text-indigo-700  hover:text-indigo-400  focus:text-gray-400 hover:scale-110 "
                                        :href="route('register.guest')"
                                        data-te-nav-link-ref
                                        >
                                            Register
                                        </a> 
                                    </div>
                                </div>
                                
                            
                                    
                                <!--bell icon-->
                                
                                <!--User Icon-->
                                <div v-if="currentUser" class="relative" data-te-dropdown-ref>
                                    <a
                                    class="hidden-arrow flex items-center whitespace-nowrap transition duration-150 ease-in-out motion-reduce:transition-none"
                                    href="#"
                                    id="dropdownMenuButton2"
                                    role="button"
                                    data-te-dropdown-toggle-ref
                                    aria-expanded="false">
                                    <img
                                        src="https://tecdn.b-cdn.net/img/new/avatars/2.jpg"
                                        class="rounded-full"
                                        style="height: 25px; width: 25px"
                                        alt=""
                                        loading="lazy" />
                                    </a>
                                    <ul
                                    class="absolute left-auto right-0 z-[1000] float-left m-0 mt-1 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                    aria-labelledby="dropdownMenuButton2"
                                    data-te-dropdown-menu-ref>
                                        <li>
                                            <a
                                            class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                            :href="route('user.profile.edit',{id:currentUser.id})"
                                            data-te-dropdown-item-ref
                                            >Manage account</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                            class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                            :href="route('change.password')"
                                            data-te-dropdown-item-ref
                                            >Change password</a
                                            >
                                        </li>
                                        <li>
                                            <Link
                                            class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30 text-justify"
                                            :href="route('logout')"
                                            data-te-dropdown-item-ref
                                            method="delete"
                                            as="button"
                                            >Logout</Link
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end ng copy ko-->
                        </div>
                        <!-- Left links -->
                </div>
                
                
                    
                
                    <!-- Right elements -->
                    
                   
                    <!-- Right elements -->
                </div>
        
            </nav>
            
        </div>
        
    </div>

        
        

        
    

   
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const logo = '/storage/Images/logo1.png'
defineProps({
    currentUser:Object
})


</script>