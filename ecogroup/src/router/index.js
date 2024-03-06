import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue' 
import SignInView from '../views/SignInView.vue'
import notFoundView from '../views/notFound.vue'

import LoggedView from '../views/logged/userLoggedView.vue'
import QuestionarioView from '../views/QuestionarioView.vue'
import AllQuestionariView from '../views/logged/AllQuestionariView.vue'

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
    path: '/user/:userid',
    name: 'LoggedIn',
    component: LoggedView,
    props: true
  },
  {
    path: '/questionario/:userid',
    name: 'QuestionarioObbligatorio',
    component: QuestionarioView,
    props: true
  },
  {
    path: '/questionari/:userid',
    name: 'Questionari',
    component: AllQuestionariView,
    props: true
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
