<template>
    
    <StudentDashboardLayout >
        <div class="flex justify-between items-center border-b-2 border-b-gray-600 mb-4">
            <span class="text-[20px] font-bold text-gray-500 ">Quiz Page</span>
            <span >Quiz will end in {{ quizDuration }} min(s) and  {{ remainingSeconds }} sec(s)</span>
        </div>

      
           
        {{ timeUp }}
        
        <div v-if="!finishQuiz">
            <div class="flex items-center justify-center w-full ">
                <span class=" font-bold text-[18px]">
                    Question {{ quizNumber+1 }} of {{ questionLength }}
                </span>
            </div>
            
            <div class="">
                <span class="font-serif text-[18px] font-bold">
                    {{ quizNumber+1 }}. {{ quiz.quiz.question[quizNumber].question }}
                </span>
            </div>
            <div class=" ml-6 gap-5">
                <label>
                    <input type="radio" :value="quiz.quiz.question[quizNumber].choices.option_a" v-model="selectedAnswer" @change="selectAnswer" class="mr-2" @input="userAnswer(quiz.quiz.question[quizNumber].id)" />
                    {{ quiz.quiz.question[quizNumber].choices.option_a }} 
                </label>
            </div>
            <div class="ml-6">
                <input type="radio" :value="quiz.quiz.question[quizNumber].choices.option_b" v-model="selectedAnswer" @change="selectAnswer" class="mr-2" @input="userAnswer(quiz.quiz.question[quizNumber].id)"/>
                {{ quiz.quiz.question[quizNumber].choices.option_b }}
            </div>
            <div class="ml-6">
                <input type="radio" :value="quiz.quiz.question[quizNumber].choices.option_c" v-model="selectedAnswer" @change="selectAnswer" class="mr-2" @input="userAnswer(quiz.quiz.question[quizNumber].id)"/>
                {{ quiz.quiz.question[quizNumber].choices.option_c }}
            </div>
            <div class="ml-6">
                <input type="radio" :value="quiz.quiz.question[quizNumber].choices.option_d" v-model="selectedAnswer" @change="selectAnswer" class="mr-2" @input="userAnswer(quiz.quiz.question[quizNumber].id)"/>
                {{ quiz.quiz.question[quizNumber].choices.option_d}}
            </div>
        </div>
        
        <div v-if="finishQuiz">
            <div class="w-full flex justify-center">
                <span v-if="!displayResult" class="text-[30px]">
                    End of Quiz
                </span>
                <div v-else class="flex flex-col justify-center text-center">
                  <span class="text-[30px]">You got  {{ studentScore }} correct answer over {{ questionLength }}</span> 
                  <span class="text-[30px]" >Your grade is: {{ computedGrade }}%</span>
                </div>
            </div>
        </div>
       
        
        <div class="flex justify-between border-t-2 border-gray-600 mt-2 py-2">
            <div  class="flex items-center gap-2 cursor-pointer" @click="handleBackClick(quizNumber ? quiz.quiz.question[quizNumber-1].id:null)">
                <i class="pi pi-angle-double-left" style="font-size: 2rem"></i>
                <span >back</span> 
            </div>
            <!-- <div v-if="quizNumber+1 === quiz.quiz.question.length" class="mr-4 cursor-pointer">
                submit
            </div> -->
            <div v-if="finishQuiz" ><Button type="button" label="Submit" @click="handleSubmitQuiz"/></div>
            <div v-else  class="flex items-center gap-2 cursor-pointer " @click="handleNextClick(quiz.quiz.question[quizNumber].id)" >
                next 
                <i class="pi pi-angle-double-right" style="font-size: 2rem"></i>
            </div>
        </div>
    </StudentDashboardLayout>
      
    
    
       
      
</template>

<script setup>
import { usePage,useForm } from '@inertiajs/vue3';
import StudentDashboardLayout from '../TestPages/StudentDashboard/StudentDashboardLayout.vue'
import { Link } from '@inertiajs/vue3'
import {ref, onMounted, watch,computed} from 'vue'
import Pagination from '../../AdminDashboard/AdminComponents/Pagination.vue'

const appUrl = '/storage/'
const defaultImage = 'Images/default.png';
const selectedAnswer = ref('');
const userPreAnswers = ref([]);
const finishQuiz = ref(false);
const questionLength = quiz.quiz.question.length
const user = usePage().props.user
const quizQuestions = ref();


const quiz = defineProps({
    quiz:Object,
    studentActiveQuizId:Number,
})

const quizNumber = ref(0); // index number of quizQuestions

const handleNextClick = (id)=>
{
    
    let exists = false;
   

    for(let i = 0; i < userPreAnswers.value.length; i++ )
    {
        if (userPreAnswers.value[i].questionId === id) 
        {
            exists = true;
            break;
        }
    }
    

    if(exists)
    {
        userPreAnswers.value[quizNumber.value].questionId = id;
        userPreAnswers.value[quizNumber.value].userSelectedAnswer = selectedAnswer.value;
        
        quizQuestions.value.forEach((question)=>{
            if(question.id === id)
            {
                userPreAnswers.value[quizNumber.value].correct_answer = question.correct_answer;
            }
        })
    }
    else
    {
        quizQuestions.value.forEach((question)=>{
            if(question.id === id)
            {
                userPreAnswers.value.push(
                    {
                        'questionId': id,
                        'userSelectedAnswer': selectedAnswer.value,
                        'correct_answer': question.correct_answer,
                    }
                    )
            }
        })
    }

    if(quizNumber.value+1 < quiz.quiz.question.length )
    {
        quizNumber.value = quizNumber.value+1
    }
    else
    {
        finishQuiz.value = !finishQuiz.value
        quizNumber.value = quizNumber.value+1   //dto nagtapos
    }
    
    if(userPreAnswers.value.length > quizNumber.value)
    {
        selectedAnswer.value = userPreAnswers.value[quizNumber.value].userSelectedAnswer
    }
    else
    {
        selectedAnswer.value = null;
    }
    
    
}

const handleBackClick = (id)=>
{
    finishQuiz.value = false;
    if(quizNumber.value+1 > 1)
    {
        quizNumber.value = quizNumber.value-1

        userPreAnswers.value.forEach((answer)=>{
            if(answer.questionId === id)
            {
                selectedAnswer.value = answer.userSelectedAnswer
            }
        })
    }
    
}

// Function to update the stored values in localStorage
function updateStoredValues() {
  localStorage.setItem('quizDuration', quiz.quiz.duration); //
  localStorage.setItem('remainingSeconds',60); //60
}

// Function to delete stored values in localStorage
function clearStoredValues() {
  localStorage.removeItem('quizDuration');
  localStorage.removeItem('remainingSeconds');
}
onMounted(()=>{
    quizQuestions.value = quiz.quiz.question
    const storedQuizDuration = localStorage.getItem('quizDuration');
    const storedRemainingSeconds = localStorage.getItem('remainingSeconds');

    if (storedQuizDuration && storedRemainingSeconds) {
        // Use the stored values if they exist
        quizDuration.value = parseInt(storedQuizDuration);
        remainingSeconds.value = parseInt(storedRemainingSeconds);
    }
    else
    {
        console.log('wala pa')
        updateStoredValues();
        quizDuration.value = parseInt(localStorage.getItem('quizDuration'));
        remainingSeconds.value = parseInt(localStorage.getItem('remainingSeconds'));
    }
    
    // Start the timer
    updateDurationTime()
})

function userAnswer(id)
{
  quizQuestions.value.forEach((question)=>{
     if(question.id === id)
     {
        if(question.correct_answer === selectedAnswer.value)
        {
            // console.log('tama ang sagot');
        }
        else{
            // console.log('mali ang sagot');
            // console.log('user select:'+ selectedAnswer.value)
            // console.log('correct answer:'+ question.correct_answer)
        }
     }
  })
}

const quizDuration = ref(null); 
const remainingSeconds = ref(null);
let intervalId;



function updateDurationTime() {
  if (remainingSeconds.value >= 0) 
  {
    intervalId = setInterval(() => 
    {
        if(quizDuration.value === 1)
        {
            quizDuration.value = quizDuration.value-1
            localStorage.setItem('quizDuration', quizDuration.value);

        }

        remainingSeconds.value = remainingSeconds.value - 1;
        localStorage.setItem('remainingSeconds', remainingSeconds.value);

        if (remainingSeconds.value < 0) 
        {
            clearInterval(intervalId); // Clear the interval when remainingSeconds reaches 0 or less
            remainingSeconds.value = 59;
            localStorage.setItem('remainingSeconds', 59);
            updateDurationTime();
            if(quizDuration.value > 0)
            {
                quizDuration.value = quizDuration.value-1
                localStorage.setItem('quizDuration', quizDuration.value);
            }
            else
            {
                clearInterval(intervalId);
                localStorage.setItem('remainingSeconds', 0);
                remainingSeconds.value = localStorage.getItem('remainingSeconds');
            }
        }

        

        
    }, 1000);
  }
}

const timeUp = computed (()=>{
    if(quizDuration.value === 0 && remainingSeconds.value === 0)
    {
        handleSubmitQuiz()
    }
})
const studentScore = ref(0)
const quizGrade = ref(0);
const computedGrade = ref(0);
const displayResult = ref(false);
const handleSubmitQuiz = ()=>{

    displayResult.value = true;
    userPreAnswers.value.forEach((answer)=>{
        if(answer.userSelectedAnswer === answer.correct_answer)
        {
            studentScore.value = studentScore.value+1
        }
    })

    quizGrade.value = (studentScore.value / questionLength) * 100
    computedGrade.value = quizGrade.value.toFixed(2);   

    form.studentScore = studentScore.value;
    form.quizGrade = computedGrade.value;

    //remove stored timer
    localStorage.removeItem('remainingSeconds')
    localStorage.removeItem('quizDuration')
    clearInterval(intervalId);

     form.post(route('quiz.submit'));
}

const form = useForm({
    studentActiveQuizId:quiz.studentActiveQuizId,
    studentId:user.id,
    quizId:quiz.quiz.id,
    gradingPeriod:quiz.quiz.grading_period,
    studentScore:null,
    quizGrade:null,
    status:'done',
})


</script>