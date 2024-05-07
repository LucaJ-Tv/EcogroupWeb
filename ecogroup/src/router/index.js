import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue' 
import SignInView from '../views/SignInView.vue'
import notFoundView from '../views/notFound.vue'

import QuestionarioView from '../views/QuestionarioView.vue'
import AllQuestionariView from '../views/logged/AllQuestionariView.vue'

import AdminLoggedView from '../views/adminlogged/AdminLoggedView.vue'
import AdminOperationsView from '../views/adminlogged/AdminOperationsView.vue'
import AdminQuestionsView from '../views/adminlogged/AdminQuestionsView.vue'
import AdminSurveysView from '../views/adminlogged/AdminSurveysView.vue'

import Prove from '../views/prove.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  }, 
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/sign-in',
    name: 'SignIn',
    component: SignInView
  },
  {
    path: '/questionario/:userid',
    name: 'QuestionarioObbligatorio',
    component: QuestionarioView,
    props: true
  },
  {
    path: '/statistiche/:userid',
    name: 'Questionari',
    component: AllQuestionariView,
    props: true
  },
  {
    path: '/admin/:userid',
    name: 'AdminLogged',
    component: AdminLoggedView,
    props: true
  },
  {
    path: '/admin/:userid/aggiungi',
    name: 'AdminOperations',
    component: AdminOperationsView,
    props: true
  },
  {
    path: '/admin/:userid/domande',
    name: 'AdminQuestions',
    component: AdminQuestionsView,
    props: true
  },
  {
    path: '/admin/:userid/questionari',
    name: 'AdminSurveys',
    component: AdminSurveysView,
    props: true
  },
  {
    path: '/prove',
    name: 'Prove',
    component: Prove,
  },
  {
    path: '/:catchAll()',
    name: 'notFound',
    component: notFoundView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
