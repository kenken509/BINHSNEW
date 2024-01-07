<template>
    <DashboardLayout :user="user" >
        
        <div class="flex justify-between items-center border-bot-only border-gray-600 shadow-md mb-4 pb-4">
            <span class="text-[20px] font-bold text-gray-500">All Quizzes</span>
            
            <div class="">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="searchField" placeholder="search " @input="handleSearchFieldInput" />
                </span>
            </div> 
        </div>
       
        <div v-if="$page.props.flash.success">{{ successMessage($page.props.flash.success)  }} </div>
        <div v-if="$page.props.flash.error">{{ errorMessage($page.props.flash.error)  }} </div>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               
                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                    <tr>{{ quizzes.quizzes.setnQuiz }}
                        <th scope="col" class="px-6 py-3">
                            ID#sss
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Subject
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Grading Period
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody v-for="quiz in currentPageItems" :key="quiz.id"  >
                   
                    <tr  v-if="!quizIsDone(quiz.id)" class="bg-white border-b ">
                        
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.id }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                        {{ quiz.title }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                            {{ quiz.subject.name}}
                        </td>
                
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.grading_period }}
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.duration }} mins
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                            {{ quiz.question_count }} 
                        </td>
                        <td>
                            <div class=" flex flex  space-x-4 ">
                                
                                <div  v-if="isNotActiveQuiz(quiz.id)" class=" flex space-x-4 ">
                                    <span  class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.left="'Delete Question'" @click="confirmDelete(quiz.id)"></span>
                                <!-- <Link :href="route('quiz.delete', {id: quiz.id})" class="cursor-pointer" v-tooltip.left="'Delete Question'" as="button" method="delete" ><span class="pi pi-trash text-red-700 scale-110 hover:dark:scale-150"></span></Link> -->
                                    <Link :href="route('quiz.edit', {id:quiz.id})" class="cursor-pointer hover:dark:scale-125" v-tooltip.right="'Edit'" ><span class="pi pi-user-edit text-green-600 scale-110 hover:dark:scale-150"></span></Link>
                                </div>
                                
                                <span class="pi pi-eye text-green-600 scale-110 hover:dark:scale-150 cursor-pointer" v-tooltip.right="'Preview'" @click="openModal(quiz.id)" ></span>
                                <span class="pi pi-send cursor-pointer hover:scale-150" style="color: slateblue" v-tooltip.left="'Send Quiz'" @click="showQuizModal(quiz.id)"></span>
                            </div>    
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <!--QUIZ INFO MODAL-->
            <Dialog v-model:visible="visible" modal header="Question Info"  :style="{ width: '80vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                <div ref="printable">
                    <div class="flex flex-col justify-center items-center w-full bg-green-700 header-container-1 mb-2 rounded-md">
                        <div class=" w-[100%] text-center text-2xl font-semibold header-container-2">  
                            <div class="flex w-[100%] justify-between p-2 items-center font-sans header-container-3 ">
                                <div class="flex items-center w-[100%] md:w-[70%] left-header">
                                    <div class="flex "><img :src="'/storage/Images/logo1.png'" alt="TLE Logo" class="w-[100px] logo"/></div>
                                    <div class="flex flex-col items-start ml-2 w-[100%] md:w-[70%] school-info-container ">
                                        <span class="text-[20px] leading-tight mb-[2px] tracking-wider text-gray-200 school-acro">BINHS</span>
                                        <span class="  md:inline-block text-[7px] md:text-[12px] text-gray-300  leading-tight mb-[2px]">Bulihan Integrated National Highschool</span>
                                        <span class=" hidden md:inline-block text-[12px] text-gray-300  leading-tight mb-[2px]">Brgy. Old Bulihan, Silang, Philippines</span>
                                    </div>
                                </div>
                                

                                <div class="flex flex-col justify-end items-end mr-4 invisible w-0 md:w-60  md:visible space-y-1  pt-2 right-header-container ">
                                    <span class="text-[12px] text-center leading-tight w-[200px] text-gray-200 flex items-center   ">
                                        <svg class="h-5 w-5 text-gray-200"  width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                                        <span class="text-[12px] text-center  text-gray-200 ml-2 ">Contact #: 0924-123-4567</span>
                                        
                                    </span>
                                    <div class="flex items-center w-[200px]  ">
                                        <svg class="h-5 w-5 text-gray-200 "  width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="3 9 12 15 21 9 12 3 3 9" />  <path d="M21 9v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />  <line x1="3" y1="19" x2="9" y2="13" />  <line x1="15" y1="13" x2="21" y2="19" /></svg>
                                        <span class="text-[12px] text-center  text-gray-200 ml-2 ">
                                            email: bulihan@gmail.com
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-for="quiz in quizzes.quizzes" :key="quiz.id">                   
                        <div v-if="quiz.id === quizId"> 
                            <div class="flex justify-between my-4 px-2 quiz-info-containter">
                                <div>
                                    <div>
                                        <span class="text-xl">Title : {{ quiz.title }}</span>
                                    </div> 
                                    <div>
                                        <span class="text-xl">Subject : {{ quiz.subject.name }}</span>
                                    </div> 
                                    <div>
                                        <span class="text-xl">Grading Period : {{ quiz.grading_period }}</span>
                                    </div> 
                                </div>

                                <div>
                                    
                                    <div>
                                        <span class="text-xl">Duration : {{ quiz.duration }} mins</span>
                                    </div> 
                                    <div>
                                        <span class="text-xl">Items : {{ quiz.question_count }} </span>
                                    </div> 
                                </div>
                            </div>
                            
                            <hr class="print-hidden-answer">
                            <div v-for="(question,index) in quiz.question" :key="question.id" class="my-2 option-container-1">
                                <div class="question-container"> {{ index+1 }}. <span >{{ question.question }}</span> </div>
                                <div class="print-hidden-answer">Correct Answer : <span class="text-green-500">{{ question.correct_answer }}  asdfasdf</span> </div> 
                                <div class="ml-10 option-container">
                                    <div>A. {{ question.choices.option_a }}</div> 
                                    <div>B. {{ question.choices.option_b }}</div> 
                                    <div>C. {{ question.choices.option_c }}</div> 
                                    <div>D. {{ question.choices.option_d }}</div>
                                </div>
                                <hr class="print-hidden-answer">
                            </div>
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button label="Close" icon="pi pi-times" @click="visible = false" text />
                    <Button label="Print" icon="pi pi-check" @click="printDiv" autofocus />
                </template> 
            </Dialog>
            <!--QUIZ INFO MODAL-->

            <!--ACTIVATE QUIZ MODAL-->
            <Dialog v-model:visible="activateQuizModal" modal header="Send Quiz"  :style="{ width: '60vw' }" :breakpoints="{ '960px': '75vw', '641px': '95vw' }">
                <hr class="bg-gray-400 h-[2px] mb-2">
                
                
                <form @submit.prevent="submit">
                    <div class="mb-4 mt-4 text-[18px] font-bold text-gray-600">Section : </div>
                    <div class="mb-4">
                        <Dropdown  v-model="selectedQuizSection" :options="availableSection" optionLabel="name"  placeholder="Select section" class="w-full md:w-14rem " />
                        <InputError :error="form.errors.section_id"/>
                    </div>

                    <div class="mb-4 text-[18px] font-bold text-gray-600">Start Date: </div>
                    <div class="mb-4">
                        <!-- <Calendar v-model="form.startDate" id="startDate" class="w-full"  /> -->
                        <input class="w-full" type="date" id="start" name="trip-start" v-model="form.startDate"   />
                        <InputError :error="form.errors.startDate"/>                    
                    </div>
                    
                    <div class="mb-4 text-[18px] font-bold text-gray-600">Due Date: </div>
                    <div class="mb-4">
                        <input class="w-full" type="date" id="end" name="trip-end" v-model="form.endDate"   />
                        <InputError :error="form.errors.endDate"/>                    
                    </div>

                    <div class="w-full mt-6 ">
                        <Button label="Submit" class="w-full" type="submit" :disabled="form.processing"/>
                    </div>
                </form>

                
            </Dialog>
            <!--ACTIVATE QUIZ MODAL-->
        </div>

        <div class="flex justify-center w-full space-x-4 mt-4" v-if="totalPages > 1">
            <div @click="prevPage"  class="flex items-center  cursor-pointer hover:text-red-400">
                <i class="pi pi-angle-double-left cursor-pointer" style="font-size: 24px;"></i>
                
            </div>
            <div class="flex space-x-2" >
                <div v-for="(number, index) in totalPages" class="hover:text-green-500 cursor-pointer" @click="changePageClick(index+1)" >
                    <div v-if="currentPage === index+1" class="border bg-green-700 px-2 rounded-lg text-gray-200" >{{ index+1 }}</div>
                    <div v-else class="px-2">{{ index+1 }}</div>
                </div>
            </div>
            <div @click="nextPage"  class="flex items-center  cursor-pointer hover:text-green-400">
                <i class="pi pi-angle-double-right  " style="font-size: 24px;"></i>
            </div>
        </div>
        
        
    </DashboardLayout>
 </template>
 
 <script setup>
 
 import { usePage, Link, useForm } from '@inertiajs/vue3';
 import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
 import { onMounted, ref, watch, computed } from 'vue';
 import InputError from '../../../../../GlobalComponent/InputError.vue'
 import Swal from 'sweetalert2';
 import { router } from '@inertiajs/vue3' // to manually get the route

 const { inertia } = usePage(); // Include inertia in the destructured import
 const user = usePage().props.user;
 
 const quizzes = defineProps({
    quizzes: Array,
    instructorSections:Array,
    sentQuiz:Array,
 })


 
 const isNotActiveQuiz = computed(() => {
  return (quizId) => {
    const isQuizSent = quizzes.quizzes.some((quiz) =>
      quiz.sent_quiz.some((sent) => sent.quiz_id === quizId)
    );
    return !isQuizSent;
  };
});

const handleQuizVisibility = () => {
    filteredData.value.forEach((quiz) => {
        const isQuizSentToAllSections = instructorHandledSection.value.every(
            (section) =>
                quiz.sent_quiz.some((sent) => sent.section_id === section.id)
        );

        // Set the quiz visibility based on the check
        quiz.isVisible = !isQuizSentToAllSections;
    });
};


 


 const quizId = ref(null);
 const visible = ref(false);
 const questionId = ref(null);
 const openModal = (id)=> {
    visible.value = true
    quizId.value = id;
}


const activateQuizModal = ref(false);
const selectedQuizSection = ref(null)
const instructorHandledSection = ref([]);
// const filteredSection = ([]);
function sortSection(instructorSec)
{
    instructorSec.forEach((sec)=>{
        if(sec.instructor_id === user.id)
        {
            instructorHandledSection.value.push(sec);
        }
        else
        {
            
        }
    })
    
}



const selectedSentQuiz = ref(null);
const availableSection = ref(null);

function showQuizModal(quizId)
{
    
    form.quiz_id = quizId;
    
    // form.section = selectedQuizSection.value.id
    activateQuizModal.value = !activateQuizModal.value

    selectedSentQuiz.value = quizzes.sentQuiz.filter((quiz)=> quiz.quiz_id === quizId);
    availableSection.value = quizzes.instructorSections.filter((section) =>{
        return selectedSentQuiz.value.every((quiz)=> quiz.section_id !== section.id )
    })
    // availableSection.value = instructorHandledSection.value.filter((section) =>{
    //     return selectedSentQuiz.value.every((quiz)=> quiz.section_id !== section.id )
    // })
       
}

const done = ref(null);
function quizIsDone(quizId)
{
    selectedSentQuiz.value = quizzes.sentQuiz.filter((quiz)=> quiz.quiz_id === quizId);
    done.value = quizzes.instructorSections.filter((section) =>{
        return selectedSentQuiz.value.every((quiz)=> quiz.section_id !== section.id )
    })

    // Return true if the quiz is done, false otherwise
    return done.value.length === 0;
}



const form = useForm({
    quiz_id : null,
    startDate:null, // Set to the current date in ISO format
    endDate:null, // Set to the current date in ISO format
    subject_id:user.subject_id,
    section_id:null,
})

function deleteDataFromLocalStorage() {
    localStorage.removeItem('questionsArray');
    }

function getQuestionsFromLocalStorage() {
    const storedData = localStorage.getItem('questionsArray');

    return storedData ;
    
}
onMounted(()=>{
    //sortSection(quizzes.sections);
    filteredData.value = quizzes.quizzes
    pageNumbers.length = totalPages.value
    // Set the time portion to midnight for both start and end dates
    // form.startDate.setHours(0, 0, 0, 0);
    // form.endDate.setHours(0, 0, 0, 0);

    // Calculate the minimum date as today's date in the YYYY-MM-DD format
    const today = new Date();
    const minDate = today.toISOString().split('T')[0]; 
    
    if(getQuestionsFromLocalStorage())
    {
        deleteDataFromLocalStorage();
    }

    
})

// const submit = ()=> {
//     form.post(route('quiz.send'))
//     activateQuizModal.value = !activateQuizModal.value

    
// };

const submit = async () => {
    try {
        const response = await form.post(route('quiz.send'));

        if(response)
        {
            activateQuizModal.value = !activateQuizModal.value
        }
        
    } catch (error) {
        // Handle any other errors that may occur during the form submission
        console.error('An error occurred during the form submission:', error);
    }
};

watch(selectedQuizSection, (val)=>{
    form.section_id = val.id;
})


function confirmDelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false,
        }).then((result) => {
            
        if (result.isConfirmed) {
            const deleteUrl = route('quiz.delete', { id: id });

            router.delete(deleteUrl)
            // Swal.fire(
            // 'Deleted!',
            // 'Your file has been deleted.',
            // 'success'
            // )
        }else if (result.isDismissed) 
        {
            Swal.fire(
            'Cancelled',
            'Your quiz file is safe!',
            'error'
            )
        }
    })
}

function successMessage(message){
    Swal.fire({
        title: 'Success',
        text: message,
        icon: 'success',
        allowOutsideClick: false,
    }).then((result)=>{
        if(result.isConfirmed)
        {
            location.reload()
        }
    })
}

const flashClear = useForm({
  clear: null,
})

function errorMessage(message) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    html: '<span style="color: red;">' + message + '!</span>',
    allowOutsideClick:false,
  }).then((result) => {
    if (result.isConfirmed) {
      flashClear.get(route('clear.flash.messages'), { preserveScroll: true });
    }
  })
}


// search logic
const filteredData = ref([])
const searchField  = ref(null)

function handleSearchFieldInput(){
    if(!searchField.value)
    {
        filteredData.value = quizzes.quizzes
    }
    else
    {
        filteredData.value = quizzes.quizzes.filter( quiz =>
            Object.values(quiz).some(value => typeof value === 'string' && value.toLowerCase().includes(searchField.value.toLowerCase()))
        )  
    }
}

// pagination logic
const itemsPerPage = ref(10);
const currentPage = ref(1);


const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage.value));
const pageNumbers = ref([]);

watch(currentPage,(val)=>{
    console.log(val);
})
const currentPageItems = computed(() => {
    
  const start = (currentPage.value - 1) * itemsPerPage.value; 
  const end = start + itemsPerPage.value;
  
  return filteredData.value.slice(start, end);
}); 

const nextPage = () => {
    
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const changePageClick = (index)=>
{
    currentPage.value = index;
}


// PRINT LOGIC
const printable = ref(null);

function printDiv() {
    const printContents = printable.value.innerHTML;

    // Create a new windows
    const printWindow = window.open('', '_blank');

    // Write the printable content to the new window
    printWindow.document.write('<html><head><title>Quiz Information</title>');

    //Manually include some Tailwind CSS styles
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: "Arial", sans-serif; background-color:white; }');
    printWindow.document.write('.text-red-500 { color: #ef4444; }'); // Example Tailwind class 
    
   
    printWindow.document.write('.header-container-1{background-color: #034515; padding:4px}')
    printWindow.document.write('.header-container-2{   }')
    printWindow.document.write('.header-container-3{ display:flex; justify-content: space-between; color:whitesmoke   }')
    printWindow.document.write('.logo{ width: 100px; height: 100px}')
    printWindow.document.write('.left-header{ display:flex; align-items:center }')
    printWindow.document.write('.right-header-container{ display:flex; flex-direction: column;   justify-content:center; align-items:center;  margin-right:10px;}')
    printWindow.document.write('.school-info-container{ display:flex; flex-direction: column; margin-left:2px}')
        // ml-10 option-container
    printWindow.document.write('.quiz-info-containter{ display:flex; justify-content:space-between; padding:10px 4px 10px 4px; border-bottom:2px solid black} ')
    printWindow.document.write('.print-hidden-answer{ display:none; }')
    printWindow.document.write('.option-container{ margin-left:30px; }')
    printWindow.document.write('.option-container-1{ padding:10px 0 5px 0; }')
    printWindow.document.write('.question-container{ padding:0px 0 5px 0; }')    


    //Include other styles as needed
    printWindow.document.write('</style>');

    // Complete the head section and start the body
    printWindow.document.write('</head><body>');
    
    // Add the printable content
    printWindow.document.write(printContents);

    // Complete the body and HTML
    printWindow.document.write('</body></html>');
    printWindow.document.close();
        
    // Use setTimeout to ensure that the styles are applied before printing
    setTimeout(() => {
        printWindow.print();
        printWindow.onafterprint = () => {
            printWindow.close();
            showGradeInfo.value = false; // Close the modal after printing
        };
    }, 1000); // Adjust the delay as needed
}
 </script>