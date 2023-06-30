<template>
    <DashboardLayout :user="user">
        <div class="flex justify-between border-bot-only border-gray-600 shadow-md mb-4 p-2">
            <span class="text-[20px] font-bold text-gray-500">Add Quiz Page</span>  
            <div>
                <button type="button" class=" bg-indigo-500 p-2 rounded-md hover:bg-indigo-400 text-gray-100" @click="handleAddQuestionClick(index)">Add Question</button>
            </div>
        </div>
        <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>

        <div class="mt-5">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4 w-full h-full  ">
                    <!--QUIZ DETAILS-->
                    <div class="col-span-2 md:col-span-1 w-full border shadow-xl rounded-md px-2 border-gray-300 ">
                        <div class="flex justify-between items-center py-2 border-b-2 border-gray-600 ">
                            <h1 class="text-[18px] text-gray-600" >Quiz Information</h1>
                            
                        </div>
                        
                        <div class="w-full">
                            <div  class="w-full mb-4 col-span-12 md:col-span-4 " >
                                <div class="my-5">Strand: </div>
                                <Dropdown  v-model="selectedSubject" :options="quiz.strands" optionLabel="name" placeholder="Select a Subject" class="w-full md:w-14rem " />
                                <InputError :error="form.errors.subject_id"/>
                            </div>
                        </div>
                        <div class="w-full mb-4 ">
                            <div class="mb-5">Title: </div>
                                <span class="p-float-label">
                                    <InputText v-model="form.title" id="title"  class="w-full" />
                                    <label for="title">Enter quiz title</label>
                                </span>
                                <InputError :error="form.errors.title"/>
                            </div>
                        <div class="w-full mb-4 ">
                            <div class="mb-5">Grading Period: </div>
                                <span class="p-float-label">
                                    <Dropdown  v-model="selectedGradingPeriod" :options="gradingPeriod" optionLabel="name"  placeholder="Select grading period" class="w-full md:w-14rem " />
                                    
                                </span>
                                <InputError :error="form.errors.grading_period"/>
                        </div>
                        <div class="w-full mb-4 ">
                            <div class="mb-5">Duration: </div>
                                <span class="p-float-label">
                                    <InputNumber v-model="form.duration" inputId="integeronly" id="duration" class="w-full" />
                                    <label for="duration">Enter minutes</label>
                                </span>
                                <InputError :error="form.errors.duration"/>
                        </div>
                        <div class="w-full col-span-2 mb-4 ">
                            <Button label="Submit" type="submit" class="w-full"/>
                        </div>
                    </div>
                    <!--QUIZ DETAILS-->
                    
                    <!--QUIZ QUESTIONS-->
                    <div class="col-span-2 md:col-span-1 w-full border shadow-md rounded-md px-2 border-gray-300">
                        <div class="flex justify-between items-center p-2 border-b-2 border-gray-600 ">
                            <h1 class="text-[18px] text-gray-600" >Quiz Questions <button v-if="getQuestionsFromLocalStorage().length > 0" class="bg-red-500 rounded px-2 text-gray-200 " disabled>{{ getQuestionsFromLocalStorage().length }}</button></h1>
                            
                        </div>
                       
                        <!--QUESTIONS TABLE-->
                        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-4">
                            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                           
                                <thead class="text-xs text-gray-200 uppercase bg-green-700 ">
                                    <tr >
                                        <th scope="col" class="px-6 py-3">
                                            Question
                                        </th>
                                        <th scope="col" class="flex justify-center px-6 py-3 ">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <!-- <div v-if="retrievedQuestions" class="text-red-500">MERONG LAMAN</div>
                                <div v-else class="text-red-500">WALANG LAMAN</div> -->
                                    
                                    <tbody v-for="(question,index ) in existingQuestion" :key="index" >
                                        <tr class="bg-white border-b hover:bg-gray-200 cursor-pointer">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900  ">
                                                <div>{{ index+1 }}.  {{ question.question }}</div>
                                                <div>Answer: {{ question.correct_answer }}</div>
                                                <div>Option A: {{ question.option_a }}</div>
                                                <div>Option B: {{ question.option_b }}</div>
                                                <div>Option C: {{ question.option_c }}</div>
                                            </td>
                                            
                                            <td>
                                                <div class="flex flex-col p-2  items-center ">
                                                   
                                                    <button type="button" class=" bg-red-600 p-2 rounded-md hover:bg-red-700 text-gray-100 hover:text-white my-2 w-20" @click="handleEditQuestionButton(index)">Edit </button>
                                                    <button type="button" class=" bg-indigo-500 p-2 rounded-md hover:bg-indigo-700 text-gray-100 hover:text-white my-2 w-20" @click="handleDeleteQuestionButton(index)">delete</button>
                                                </div>    
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                    
                                    
                            </table>
                            <div v-if="getQuestionsFromLocalStorage().length === 0" class="flex justify-center text-red-300 p-2">
                                Empty List
                               
                            </div>
                            <div v-if="form.errors.questions" class="flex justify-center text-gray-500">
                                <InputError :error="form.errors.questions"/>
                            </div>
                            
                <!--ADD QUESTION MODAL-->
                <Dialog v-model:visible="addQuestion" modal header="Add new question"  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                    <div class="border p-2 rounded-md">
                        <form @submit.prevent="handleAddModalQuestion">
                            <div>Question:</div>
                            <div>
                                <Textarea v-model="preQuestion" rows="3"  class="w-full" placeholder="Enter question" required/>
                            </div>

                            <div>
                                Input Options
                            </div>

                            <div class="">
                                Option A: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preOptionA" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option B: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preOptionB" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option C: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preOptionC" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Correct Answer: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preCorrectAnswer" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="w-full mt-6 ">
                                <Button label="Add" class="w-full" type="submit"/>
                            </div>
                        </form>
                    </div>
                    
                    
                    
                </Dialog>
                <!--ADD QUESTION MODAL---->
                        </div>
                        <!--QUESTIONS TABLE-->
                    </div>
                     <!--QUIZ QUESTIONS-->
                </div>
                
                <!--EDIT QUESTION MODAL-->
                <Dialog v-model:visible="editQuestion" modal header="Add new question"  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                    
                    <div class="border p-2 rounded-md">
                        <form @submit.prevent="handleEditModalQuestion">
                            <div>Question:</div>
                            <div>
                                <Textarea v-model="preQuestionEdit" rows="3"  class="w-full" placeholder="Enter question" required/>
                               
                            </div>

                            <div>
                                Input Options
                            </div>

                            <div class="">
                                Option A: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preOptionAEdit" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option B: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preOptionBEdit" id="choice_b"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option C: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preOptionCEdit" id="choice_c"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Correct Answer: 
                            </div>

                            <div>
                                <span class="">
                                    <InputText v-model="preCorrectAnswerEdit" id="correct_answer"  class="w-full" placeholder="Enter option" required/>
                                
                                </span>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="w-full mt-6 ">
                                <Button label="Add" class="w-full" type="submit"/>
                            </div>
                        </form>
                    </div>
                </Dialog>
                <!--EDIT QUESTION MODAL-->
            </form>
        </div>
    </DashboardLayout>
    
</template>

<script setup>
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
import InputError from '../../../../../GlobalComponent/InputError.vue';
import {onBeforeMount, onBeforeUnmount, onMounted, ref, watch} from 'vue'
import { usePage, Link, useForm } from '@inertiajs/vue3';
const user = usePage().props.user;
const existingQuestion = ref([]);
const quiz = defineProps({
    strands:Array,
});



const gradingPeriod = ref([
    {'name':'1st'},
    {'name':'2nd'},
    {'name':'3rd'},
    {'name':'4th'},
]) 

const selectedGradingPeriod = ref(null)
const selectedSubject = ref({});
const preQuestion      = ref(null);
const preOptionA        = ref(null);
const preOptionB        = ref(null);
const preOptionC        = ref(null);
const preCorrectAnswer  = ref(null);



const addQuestion = ref(false)
function handleAddQuestionClick(){
    addQuestion.value = !addQuestion.value;
}

const editQuestion = ref(false)


const preQuestionObject = {
        'question'      :null,
        'correct_answer':null,
        'option_a'      :null,
        'option_b'      :null,
        'option_c'      :null,
}
const preQuestionsArray = [];


const handleAddModalQuestion = () => {
    const newQuestion = {
        question: preQuestion.value,
        correct_answer: preCorrectAnswer.value,
        option_a: preOptionA.value,
        option_b: preOptionB.value,
        option_c: preOptionC.value,
    };

    existingQuestion.value.push(newQuestion);

    preQuestion.value = null;
    preOptionA.value = null;
    preOptionB.value = null;
    preOptionC.value = null;
    preCorrectAnswer.value = null;

    //console.log(preQuestionsArray);
    saveQuestionsToLocalStorage(existingQuestion.value);
    //console.log(preQuestionsArray);

    addQuestion.value = !addQuestion.value;
};




 
function saveQuestionsToLocalStorage(arrayToSave) {
  localStorage.setItem('questionsArray', JSON.stringify(arrayToSave));
} 


function getQuestionsFromLocalStorage() {
    const storedData = localStorage.getItem('questionsArray');
  
    return storedData ? JSON.parse(storedData) : [];
    
}

function deleteDataFromLocalStorage() {
  localStorage.removeItem('questionsArray');
}

onMounted(() => {
  window.addEventListener('beforeunload', deleteDataFromLocalStorage);
});

onBeforeUnmount(() => {
  window.removeEventListener('beforeunload', deleteDataFromLocalStorage);
});

const form = useForm({
    subject_id:null,
    title:null,
    grading_period : null,
    duration:null,
    questions:null,
})

watch(selectedSubject, (val)=>{
    //console.log(val.id);
    form.subject_id = val.id;
})
watch(selectedGradingPeriod,(val)=>{
    form.grading_period = val.name
})
const submit = () => {
    form.questions = getQuestionsFromLocalStorage()
    deleteDataFromLocalStorage()
    form.post(route('quiz.store'))
    
};

//edit question codes **********************************************


 const   preQuestionEdit        = ref(null) 
 const   preOptionAEdit         = ref(null) 
 const   preOptionBEdit         = ref(null) 
 const   preOptionCEdit         = ref(null) 
 const   preCorrectAnswerEdit   = ref(null) 
 const   questionIndex          = ref(null);
 const handleEditQuestionButton = (index) => {
    const selectedQuestion = getQuestionsFromLocalStorage()[index];
    
    questionIndex.value = index;

    preQuestionEdit.value = selectedQuestion.question;
    preOptionAEdit.value = selectedQuestion.option_a;
    preOptionBEdit.value = selectedQuestion.option_b;
    preOptionCEdit.value = selectedQuestion.option_c;
    preCorrectAnswerEdit.value = selectedQuestion.correct_answer;

    editQuestion.value = !editQuestion.value;
};
const handleEditModalQuestion = () => {
  // Get the questions array from localStorage
  const questions = getQuestionsFromLocalStorage();

  // Get the question at the selected index
  const selectedQuestion = questions[questionIndex.value];

  // Update the properties of the selected question
  selectedQuestion.question         = preQuestionEdit.value;
  selectedQuestion.option_a         = preOptionAEdit.value;
  selectedQuestion.option_b         = preOptionBEdit.value;
  selectedQuestion.option_c         = preOptionCEdit.value;
  selectedQuestion.correct_answer   = preCorrectAnswerEdit.value;

  // Save the updated array back to localStorage
  saveQuestionsToLocalStorage(questions);
  existingQuestion.value = getQuestionsFromLocalStorage();
  // Close the edit modal
  editQuestion.value = false;
};


//edit question codes **********************************************

//delete question codes ************************************************

const handleDeleteQuestionButton = (index)=> {
    //get the currently saved question
    const currentQuestion = getQuestionsFromLocalStorage()
   
    //filter the existing question 
    const newQuestionArray = currentQuestion.filter((question, i) => i !== index );

    
    saveQuestionsToLocalStorage(newQuestionArray);

    existingQuestion.value = getQuestionsFromLocalStorage();

}

//delete question codes ************************************************
</script>