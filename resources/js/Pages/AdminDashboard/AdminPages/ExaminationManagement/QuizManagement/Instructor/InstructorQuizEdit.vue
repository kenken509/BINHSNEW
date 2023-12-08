<template>
    <DashboardLayout :user="user">
        <div class="flex justify-between border-bot-only border-gray-600  mb-4 p-2">
            <span class="text-[20px] font-bold text-gray-500">Edit Quiz Page</span>  
            <div>
                <button type="button" class=" bg-indigo-500 p-2 rounded-md hover:bg-indigo-400 text-gray-100" @click="handleAddQuestionClick(index)">Add Question</button>
            </div>
        </div>
        <div v-if="$page.props.flash.success" class="bg-green-300 mb-2 p-1 rounded-md text-gray-600">{{ $page.props.flash.success  }} </div>

        <div>
            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4 w-full h-full  ">
                    <!--QUIZ DETAILS-->
                    <div class="col-span-2 md:col-span-1 w-full border shadow-xl rounded-md px-4 border-gray-300 ">
                        <div class="flex justify-between items-center py-2 border-b-2 border-gray-600 ">
                            <h1 class="text-[18px] text-gray-600" >Quiz Information</h1>
                        </div>
                        <hr>
                        
                        <div class="w-full mb-4 ">
                            <div class="my-5">Title: </div>
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
                            <Button label="Update" type="submit" class="w-full"/>
                        </div>
                    </div>
                    <!--QUIZ DETAILS-->
                    
                    <!--QUIZ QUESTIONS-->
                    <div class="col-span-2 md:col-span-1 w-full border shadow-md rounded-md px-2 border-gray-300">
                        <div class="flex justify-between items-center p-2 border-b-2 border-gray-500 ">
                            
                            <h1 class="text-[18px] text-gray-600" >Quiz Questions <button v-if="getQuestionsFromLocalStorage().length > 0" class="bg-red-500 rounded px-2 text-gray-200 " disabled>{{ getQuestionsFromLocalStorage().length }}</button></h1>
                            
                        </div>
                        
                        <!--QUESTIONS TABLE-->
                        <div class=" overflow-x-auto shadow-md sm:rounded-lg mt-4 mx-2">
                            <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                           
                                <thead class="text-xs text-gray-200 uppercase bg-green-700  ">
                                    <tr>
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
                                                <div>Option A: {{ question.choices.option_a }}</div>
                                                <div>Option B: {{ question.choices.option_b }}</div>
                                                <div>Option C: {{ question.choices.option_c }}</div>
                                                <div>Option D: {{ question.choices.option_d }}</div>
                                            </td>
                                            
                                            <td>
                                                <div class="flex flex-col p-2  items-center ">
                                                   
                                                    <button type="button" class=" bg-red-600 p-2 rounded-md hover:bg-red-700 text-gray-100 hover:text-white my-2 w-20" @click="handleEditQuestionButton(index)">Edit </button>
                                                    <button type="button" class=" bg-indigo-500 p-2 rounded-md hover:bg-indigo-700 text-gray-100 hover:text-white my-2 w-20" @click="handleDeleteQuestionButton(index,question.id)">delete</button>
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
                            
                <!--ADD QUESTION MODAL START-->
                <Dialog v-model:visible="addQuestion" modal header="Add new question"  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                    <div class="border p-2 rounded-md">
                        <form @submit.prevent="handleAddModalQuestion">
                            <div>Question:</div>
                            <div>
                                <Textarea v-model="preQuestion" rows="3"  class="w-full" placeholder="Enter question" required/>
                            </div>

                            <div class="grid grid-cols-12">
                                <span class=" col-span-11">
                                    Input Options 
                                </span>
                                <span class=" col-span-1">
                                    Answer
                                </span>
                            </div>

                            <div class="">
                                Option A: 
                            </div>

                            <div class="grid grid-cols-12">
                                <div class=" col-span-11">
                                    <span>
                                        <InputText v-model="preOptionA" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswer" inputId="option_a" name="optionGroup" value="A" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option B: 
                            </div>

                            <div class="grid grid-cols-12">
                                <div class=" col-span-11">
                                    <span>
                                        <InputText v-model="preOptionB" id="choice_b"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswer" inputId="option_b" name="optionGroup" value="B" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option C: 
                            </div>

                            <div class="grid grid-cols-12">
                                <div class=" col-span-11">
                                    <span>
                                        <InputText v-model="preOptionC" id="choice_c"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswer" inputId="option_c" name="optionGroup" value="C" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            <div class="">
                                Option D:
                            </div>

                            <div class="grid grid-cols-12">
                                <div class=" col-span-11">
                                    <span>
                                        <InputText v-model="preOptionD" id="choice_d"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswer" inputId="option_d" name="optionGroup" value="D" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>

                            <div class="mt-6">
                                <InputError :error="addQuestionError"/>
                            </div>

                            <div class="w-full mt-6 ">
                                <Button label="Add" class="w-full" type="submit"/>
                            </div>
                        </form>
                    </div>
                    
                    
                    
                </Dialog>
                <!--ADD QUESTION MODAL END---->
                        </div>
                        <!--QUESTIONS TABLE-->
                    </div>
                     <!--QUIZ QUESTIONS-->
                </div>
                
                <!--EDIT QUESTION MODAL START-->
                <Dialog v-model:visible="editQuestion" modal header="Edit Question"  :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
                    
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

                            <div class="grid grid-cols-12">
                                <div class="col-span-11">
                                    <span class="">
                                        <InputText v-model="preOptionAEdit" id="choice_a"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswerEdit" inputId="option_a" name="optionGroup" value="A" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>

                            <div class="">
                                Option B: 
                            </div>

                            <div class="grid grid-cols-12">
                                <div class="col-span-11">
                                    <span class="">
                                        <InputText v-model="preOptionBEdit" id="choice_b"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswerEdit" inputId="option_b" name="optionGroup" value="B" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>

                            <div class="">
                                Option C: 
                            </div>

                            <div class="grid grid-cols-12">
                                <div class="col-span-11">
                                    <span class="">
                                        <InputText v-model="preOptionCEdit" id="choice_c"  class="w-full" placeholder="Enter option" required/>
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswerEdit" inputId="option_c" name="optionGroup" value="C" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>

                            <div class="">
                                Option D: 
                            </div>

                            <div class="grid grid-cols-12">
                                <div class="col-span-11">
                                    <span class="">
                                        <InputText v-model="preOptionDEdit" id="correct_answer"  class="w-full" placeholder="Enter option" required/>                                   
                                    </span>
                                </div>
                                <div class=" col-span-1  flex items-center justify-center h-full" >
                                    <RadioButton v-model="preAnswerEdit" inputId="option_d" name="optionGroup" value="D" />
                                </div>
                                <!-- <InputError :error="form.errors.correct_answer"/> -->
                            </div>
                            
                            <div class="w-full mt-6 ">
                                <Button label="Save" class="w-full" type="submit"/>
                            </div>
                        </form>
                    </div>
                </Dialog>
                <!--EDIT QUESTION MODAL END-->
            </form>
        </div>
    </DashboardLayout>
    
</template>

<script setup>
import DashboardLayout from '../../../../Layout/DashboardLayout.vue';
import InputError from '../../../../../GlobalComponent/InputError.vue';
import {onBeforeMount, onBeforeUnmount, onMounted, ref, watch} from 'vue'
import { usePage, Link, useForm,router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
const user = usePage().props.user;

const quiz = defineProps({
    strands:Array,
    quizToEdit:Object,
});



const gradingPeriod = ref([
    {'name':'First Grading'},
    {'name':'Second Grading'},
    {'name':'Third Grading'},
    {'name':'Fourth Grading'},
]) 

const selectedGradingPeriod = ref({'name':quiz.quizToEdit.grading_period})
const selectedSubject   = ref(quiz.quizToEdit.subject);
const preQuestion       = ref(null);
const preOptionA        = ref(null);
const preOptionB        = ref(null);
const preOptionC        = ref(null);
const preOptionD        = ref(null);
const preAnswer         = ref(null);
const addQuestionError  = ref("");


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
const preQuestionsArray = []; //<<<<<<<< dto kelangan mailagay


const handleAddModalQuestion = () => {

    if(preAnswer.value === null)
    {
        addQuestionError.value = "Please specify the \"correct answer\".";
        addQuestion.value = true;
    }
    else
    {
        const newQuestion = {
            id:null,
            question: preQuestion.value,
            correct_answer: preAnswer.value,
            choices: {
                option_a: preOptionA.value,
                option_b: preOptionB.value,
                option_c: preOptionC.value,
                option_d: preOptionD.value,
            }
        };

        
        
        existingQuestion.value.push(newQuestion);

        preQuestion.value = null;
        preOptionA.value = null;
        preOptionB.value = null;
        preOptionC.value = null;
        preOptionD.value = null;
        preAnswer.value = null;

        console.log(existingQuestion.value);
        saveQuestionsToLocalStorage(existingQuestion.value);
        console.log(existingQuestion.value);

        addQuestion.value = !addQuestion.value;
        addQuestionError.value = "";
    }
    
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

const existingQuestion = ref([]);
const hasReloaded = localStorage.getItem('hasReloaded');
onMounted(() => {
    //reload
if (!hasReloaded) {
    localStorage.setItem('hasReloaded', true);
    location.reload();
} else {
    localStorage.removeItem('hasReloaded');
}

  window.addEventListener('beforeunload', deleteDataFromLocalStorage);

  const questionsArray = quiz.quizToEdit.question.map((question) => {
    // Create an object with the necessary properties from the question object
    const questionObject = {
      id:question.id,
      question: question.question,
      correct_answer: question.correct_answer,
      choices: {
        option_a: question.choices.option_a,
        option_b: question.choices.option_b,
        option_c: question.choices.option_c,
        option_d: question.choices.option_d
      }
    };

    return questionObject;
  });

  saveQuestionsToLocalStorage(questionsArray);
  existingQuestion.value = getQuestionsFromLocalStorage();
});


onBeforeUnmount(() => {
  window.removeEventListener('beforeunload', deleteDataFromLocalStorage);
});

const form = useForm({
    id:quiz.quizToEdit.id,
    deleted_question_id:[],
    subject_id:user.subject_id,
    title:quiz.quizToEdit.title,
    grading_period : quiz.quizToEdit.grading_period,
    duration:quiz.quizToEdit.duration,
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
    confirmUpdate()
    //form.questions = getQuestionsFromLocalStorage()
    // deleteDataFromLocalStorage()   // if submit has errors do not delete <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    //form.post(route('quiz.update'),{preserveScroll:true})
    
};

function confirmUpdate()
{
    Swal.fire({
        title:'Update Confirmation',
        text:'The quiz will be updated?',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Update it!',
        allowOutsideClick: false,
        icon:'warning',
    }).then((result)=>{
        console.log(result)
        if(result.isConfirmed)
        {
            const updateUrl = route('quiz.update')
            form.questions = getQuestionsFromLocalStorage()
            router.post(updateUrl, form);
        }

        if(result.isDismissed)
        {
            Swal.fire({
                title:'Cancelled',
                text:'Update cancelled!',
                icon:'error',
            })
            
        }

    })
}
//edit question codes **********************************************


 const   preQuestionEdit        = ref(null) 
 const   preOptionAEdit         = ref(null) 
 const   preOptionBEdit         = ref(null) 
 const   preOptionCEdit         = ref(null) 
 const   preOptionDEdit         = ref(null);
 const   preAnswerEdit          = ref(null) 
 const   questionIndex          = ref(null);
 const handleEditQuestionButton = (index) => {
    const selectedQuestion = getQuestionsFromLocalStorage()[index];
    
    questionIndex.value = index;
    
    preQuestionEdit.value = selectedQuestion.question;
    preOptionAEdit.value = selectedQuestion.choices.option_a;
    preOptionBEdit.value = selectedQuestion.choices.option_b;
    preOptionCEdit.value = selectedQuestion.choices.option_c;
    preOptionDEdit.value = selectedQuestion.choices.option_d;
    preAnswerEdit.value = selectedQuestion.correct_answer;

    editQuestion.value = !editQuestion.value;
};


const handleEditModalQuestion = () => {
  // Get the questions array from localStorage
  const questions = getQuestionsFromLocalStorage();

  // Get the question at the selected index
  const selectedQuestion = questions[questionIndex.value];

  // Update the properties of the selected question
  selectedQuestion.question         = preQuestionEdit.value;
  selectedQuestion.choices.option_a         = preOptionAEdit.value;
  selectedQuestion.choices.option_b         = preOptionBEdit.value;
  selectedQuestion.choices.option_c         = preOptionCEdit.value;
  selectedQuestion.choices.option_d         = preOptionDEdit.value;
  selectedQuestion.correct_answer           = preAnswerEdit.value;

  // Save the updated array back to localStorage
  saveQuestionsToLocalStorage(questions);
  existingQuestion.value = getQuestionsFromLocalStorage()
  // Close the edit modal
  editQuestion.value = false;
};


//edit question codes **********************************************

//delete question codes ************************************************
const deletedQuestionsId = ref([]);
const handleDeleteQuestionButton = (index,question_id)=> {
    //get the currently saved question
    const currentQuestion = getQuestionsFromLocalStorage()
    deletedQuestionsId.value.push(question_id);
    form.deleted_question_id = deletedQuestionsId.value;
    //filter the existing question 
    const newQuestionArray = currentQuestion.filter((question, i) => i !== index );

    
    saveQuestionsToLocalStorage(newQuestionArray);

    existingQuestion.value = getQuestionsFromLocalStorage();

}

//delete question codes ************************************************


</script>