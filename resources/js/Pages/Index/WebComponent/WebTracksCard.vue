<template>
    <div class="w-full flex flex-col justify-center ">
        <div v-for="post in data.webPosts" :key="post.id" class="border border-2 border-gray-300 p-8 bg-gray-100 shadow-md my-8  rounded-md">
                    
            <div class=" flex flex-col mb-2 border ">
                <div class="w-full  text-[30px] text-gray-800 font-serif mb-2">
                    {{ toUpperFirst(post.title)  }} --test title--:{{ post.title  }}
                </div>
                
                <div class="text-[12px] text-gray-400 ">
                    Author: {{ toUpperFirst(post.author.fName)  }} {{ toUpperFirst(post.author.lName)  }}
                </div>

                <div class="mb-2">
                    <span class="text-[12px] text-gray-400 "> {{ dateCreated(post.id) }}</span>
                </div>
            </div>
            <div class="relative border "> <!-- mula dito lagay-->
                <div v-if="post.attachments.length && post.attachments[0].type === 'Image' " >
                    <img :src="'../storage/'+post.attachments[0].filename" alt="error" class="border  rounded-md shadow-gray-900 shadow-md"> 
                </div>

                <div v-if="post.attachments.length && post.attachments[0].type === 'Video'">
                    <video :src="'../storage/'+post.attachments[0].filename" controls class="border  rounded-md" ></video>
                </div>
                
                <div class=" whitespace-pre-line mt-4">
                    <p class="flex text-justify px-4">
                        {{ toUpperFirst(truncateText(post.content,10)) }} 
                        <Link :href="route('fullPost.show',{page:page, id:post.id})">
                            <span class="text-blue-500">read more...</span> 
                        </Link>
                    </p>
                    
                    <div @click="handleReactionClick(post.id,post.userHasReacted)" class="border  border-t-black  border-x-transparent border-b-transparent pt-4 flex justify-between">
                        <!-- left reaction-->
                        <div class=" space-x-1 hover:cursor-pointer" @click="handleReactionModalClick(post.id)"> 
                            <i v-if="post.likeReactionsCount" class="pi pi-thumbs-up-fill" style="color: slateblue; font-size: 1rem;"> </i>
                            <i v-if="post.heartReactionsCount" class="pi pi-heart-fill" style="color: red; font-size: 1rem;"> </i>
                            <i v-if="post.reactions_count < 1" class="pi pi-thumbs-up" style="color: slateblue; font-size: 1rem;"> </i>
                            {{  post.reactions_count }}
                        </div>
                        <!-- left reaction-->
                            
                        <!-- right reaction-->
                        <div  v-if="!post.userHasReacted">
                            <i  
                                class="pi pi-thumbs-up hover:cursor-pointer" 
                                style="font-size: 1rem; " 
                            > like</i>
                            <!-- @click="()=>toggleLike(post.id)" -->
                        </div>
                        <div v-else>
                            <i v-if="post.userReactionType === 'like'" class="pi pi-thumbs-up-fill hover:cursor-pointer" style="font-size: 1rem; color: slateblue; " @click="()=>toggleLike(post.id)">
                                <span class=" text-slate-500"> Liked</span> 
                            </i>
                            <i v-if="post.userReactionType === 'heart'" class="pi pi-heart-fill hover:cursor-pointer" style="font-size: 1rem; color: red; " @click="()=>toggleLike(post.id)">
                               <span class=" text-red-500 font-serif"> Loved</span>  
                            </i>
                        </div>
                        <!-- right reaction-->
                        
                    </div>
                    
                </div>
                <!-- reaction options-->
                <div v-if="isVisible[post.id]" class="flex justify-center items-center space-x-5 absolute z-10 bottom-[30px] right-[5px] border border-gray-300 shadow-lg bg-gray-100 rounded-lg p-2 ">
                    <div>
                        <i  
                        class="pi pi-thumbs-up-fill hover:cursor-pointer hover-effect" 
                        :style="{ 'font-size': '2rem', 'color': likeColor }" 
                        @click="()=>toggleLike(post.id,'like')"
                        @mouseover="handleLikeMouseOver"
                        @mouseleave="handleLikeMouseLeave"
                        ></i>
                    </div>
                    <div>
                        <i  
                        class="pi pi-heart-fill hover:cursor-pointer" 
                        :style="{ 'font-size': '2rem', 'color': heartColor }" 
                        @click="()=>toggleLike(post.id,'heart')"
                        @mouseover="handleHeartMouseOver"
                        @mouseleave="handleHeartMouseLeave"
                        > </i>  
                    </div>
                    
                </div>
                <!-- reaction options-->

            </div><!-- hanggang dito -->
            
            <!-- reactions MODAL-->
            <Dialog v-model:visible="reactionModal" modal header=""  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                <div v-for="post in data.webPosts">
                    <div v-if="post.id === reactionModalPostId">
                        <div class="flex items-center border p-2 rounded-md space-x-4">
                            <div class="hover:cursor-pointer" @click="allReactionsClick" >
                                <span class="text-gray-500">All {{ post.reactions_count }}</span> 
                            </div>
                            <div class="hover:cursor-pointer" @click="allLikesClick">
                                <i  class="pi pi-thumbs-up-fill " style="font-size: 1rem; color:slateblue;"> like {{ post.likeReactionsCount }}</i> 
                            </div>
                            <div class="hover:cursor-pointer" @click="allLoveClick">
                                <i  class="pi pi-heart-fill " style="font-size: 1rem; color:red"> love {{ post.heartReactionsCount }}</i> 
                            </div>
                        </div>
                        <!--DATA-->
                        <div v-if="allReactions" class="mt-4" >
                            <div v-for="user in post.reactions" :key="user.id" >
                                <div class="flex justify-between items-center p-2">
                                    <!--left-->
                                    <div class="flex items-center space-x-2">
                                        <img
                                            :src="'/storage/Images/default.png'"
                                            class=" w-8 h-8 "
                                            alt=""
                                        />
                                        <span>{{ user.reacting_user.email }}</span>
                                    </div>
                                    <!--left-->

                                    <!--right-->
                                    <div>
                                        <i v-if="user.type === 'like'" class="pi pi-thumbs-up-fill hover:cursor-pointer" style="font-size: 1rem; color: slateblue; ">
                                        <span class=" text-slate-500"> </span> 
                                        </i>
                                        <i v-if="user.type === 'heart'" class="pi pi-heart-fill hover:cursor-pointer" style="font-size: 1rem; color: red; ">
                                            <span class=" text-red-500 font-serif"> </span>  
                                        </i>
                                    </div>
                                    <!--right-->
                                </div>
                            </div>
                        </div>

                        <div v-if="allLikes" class="">
                            <div v-for="user in post.reactions" :key="user.id" >
                                <div v-if="user.type === 'like'" class="flex justify-between items-center p-2">
                                    <!--left-->
                                    <div class="flex items-center space-x-2">
                                        <img
                                            :src="'/storage/Images/default.png'"
                                            class=" w-8 h-8 "
                                            alt=""
                                        />
                                        <span>{{ user.reacting_user.email }}</span>
                                    </div>
                                    <!--left-->

                                    <!--right-->
                                    <div>
                                        <i class="pi pi-thumbs-up-fill hover:cursor-pointer" style="font-size: 1rem; color: slateblue; " ></i>
                                    </div>
                                    <!--right-->
                                </div>
                            </div>
                        </div>

                        <div v-if="allLove" class="">
                            <div v-for="user in post.reactions" :key="user.id" >
                                <div v-if="user.type === 'heart'" class="flex justify-between items-center p-2">
                                    <!--left-->
                                    <div class="flex items-center space-x-2">
                                        <img
                                            :src="'/storage/Images/default.png'"
                                            class=" w-8 h-8 "
                                            alt=""
                                        />
                                        <span>{{ user.reacting_user.email }}</span>
                                    </div>
                                    <!--left-->


                                    <!--right-->
                                    <div>
                                        <i class="pi pi-heart-fill hover:cursor-pointer" style="font-size: 1rem; color: red; "></i>                                            
                                    </div>
                                    <!--right-->
                                </div>
                            </div>
                        </div>
                        </div>
                        <!--DATA-->
                    </div>
            </Dialog>
            <!-- reactions MODAL-->
        </div>
    </div>
</template>

<script setup>
import {toUpperFirst} from '../../Functions/Methods.vue'
import {truncateText} from '../../Functions/Methods.vue'
import { ref } from 'vue';
import {Link, useForm} from '@inertiajs/vue3'

const data = defineProps({
    webPosts:Array,
    page:String,
})

const likeColor = ref('slateblue')
const heartColor = ref('red');
const isVisible = ref({});
const reactionModal = ref(false);

//reactions data 
const allReactions  = ref(true);
const allLikes      = ref(false);
const allLove       = ref(false);
const reactionModalPostId = ref(null);

const handleReactionModalClick = (postId)=>{
    reactionModalPostId.value = postId;
    reactionModal.value = !reactionModal.value
}

const allReactionsClick = ()=>{
    allReactions.value = true;
    allLikes.value = false;
    allLove.value = false;
}

const allLikesClick = ()=>{
    allReactions.value = false;
    allLikes.value = true;
    allLove.value = false;
}

const allLoveClick = ()=>{
    allReactions.value = false;
    allLikes.value = false;
    allLove.value = true;
}


function dateCreated (id){
    let dateString;

    data.webPosts.forEach((post)=>{
        if(post.id === id){
            dateString = post.created_at
        }
    })

    const postDate = new Date(dateString)
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = postDate.toLocaleDateString('en-US', options);

    

     return formattedDate;
}

const form = useForm({
    web_post_id:null,
    type:null,
})

function toggleLike(webPost, reaction){
    
    form.web_post_id = webPost
    form.type = reaction
    form.post(route('post.toggleLike'),{preserveScroll:true});
    isVisible.value = false;
};






const handleReactionClick = (postId , hasReacted) => {
  // Toggle visibility for the clicked post
    if(!hasReacted)
    {
        isVisible.value = {
            ...isVisible.value,
            [postId]: !isVisible.value[postId],
        }
    
  };
}

const handleLikeMouseOver = ()=>{
    
   likeColor.value = '#3439ba';
}

const handleLikeMouseLeave = ()=>{
    likeColor.value = 'slateblue';
    
}

const handleHeartMouseOver = ()=>{
    
    heartColor.value = '#b30f04';
 }
 
 const handleHeartMouseLeave = ()=>{
     heartColor.value = 'red';
     
 }
</script>



