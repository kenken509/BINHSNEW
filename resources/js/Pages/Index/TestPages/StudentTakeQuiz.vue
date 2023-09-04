<template>
    
    <StudentDashboardLayout >
        <div class="col-span-6 md:col-span-5 border-b-2 border-b-gray-600 mb-4">
            <span class="text-[20px] font-bold text-gray-500 ">Quiz Page</span>
        </div>
        {{ userPreAnwers }} 
        <div class="">
            <span class="font-serif text-[18px] font-bold">
                {{ quizNumber+1 }}. {{ quiz.quiz.question[quizNumber].question }}
            </span>
        </div>
        <div class=" ml-6 gap-5">
            <label>
                <input type="radio" :value="quiz.quiz.question[quizNumber].choices.option_a" v-model="selectedAnswer" @change="selectAnswer" class="mr-2" @input="userAnswer(quiz.quiz.question[quizNumber].id)" />
                {{ quiz.quiz.question[quizNumber].choices.option_a }} {{ quiz.quiz.question[quizNumber].id }}
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
        {{ selectedAnswer }}
        
        
        <div class="flex justify-between border-t-2 border-gray-600 mt-2 py-2">
            <div class="flex items-center gap-2 cursor-pointer" @click="handleBackClick">
                <i class="pi pi-angle-double-left" style="font-size: 2rem"></i>
                <span>back</span> 
            </div>
            <div v-if="quizNumber+1 === quiz.quiz.question.length" class="mr-4 cursor-pointer">
                submit
            </div>
            <div v-else class="flex items-center gap-2 cursor-pointer " @click="handleNextClick(quiz.quiz.question[quizNumber].id)" >
                next 
                <i class="pi pi-angle-double-right" style="font-size: 2rem"></i>
            </div>
        </div>
    </StudentDashboardLayout>
      
    
    
       
      
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import StudentDashboardLayout from '../TestPages/StudentDashboard/StudentDashboardLayout.vue'
import { Link } from '@inertiajs/vue3'
import {ref, onMounted} from 'vue'
import Pagination from '../../AdminDashboard/AdminComponents/Pagination.vue'

const appUrl = '/storage/'
const defaultImage = 'Images/default.png';
const selectedAnswer = ref('');
const userPreAnwers = ref([]);
const user = usePage().props.user
const quizQuestions = ref();
const quiz = defineProps({
    quiz:Object,
    
})

const quizNumber = ref(0);

const handleNextClick = (id)=>
{
    
    if(quizNumber.value+1 < quiz.quiz.question.length )
    {
        quizNumber.value = quizNumber.value+1
    }
    quizQuestions.value.forEach((question)=>{
        if(question.id === id){
            userPreAnwers.value.push(
                {
                    'questionId': id,
                    'userSelectedAnswer': selectedAnswer.value,
                    'correct_answer': question.correct_answer,
                }
            )
        }
    })

    selectedAnswer.value = null;
}

const handleBackClick = ()=>
{
    if(quizNumber.value+1 > 1)
    {
        quizNumber.value = quizNumber.value-1
    }
}

onMounted(()=>{
    quizQuestions.value = quiz.quiz.question
})

function userAnswer(id)
{
  quizQuestions.value.forEach((question)=>{
     if(question.id === id)
     {
        
        if(question.correct_answer === selectedAnswer.value)
        {
            console.log('tama ang sagot');
        }
        else{
            console.log('mali ang sagot');
            // console.log('user select:'+ selectedAnswer.value)
            // console.log('correct answer:'+ question.correct_answer)
        }
     }
  })
}
</script>