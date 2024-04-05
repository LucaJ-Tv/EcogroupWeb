<template>
    <nav class="rounded-t-lg bg-opacity-70 shadow-md bg-site-primary border-t border-green-600 mx-1 pt-5 pb-3">
      <div class="flex justify-center gap-3 md:gap-10 text-center w-full mx-auto">
        <RouterLink :to="{name: 'AdminLogged', params: {userid: this.userid}}" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
          <i class="fa-solid fa-chart-pie"></i>
          <span class="self-center text-xl whitespace-nowrap">Statistiche</span>
        </RouterLink>
        <RouterLink :to="{name: 'AdminOperations', params: {userid: this.userid}}" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
          <i class="fa-solid fa-hammer"></i>
          <span class="self-center text-xl whitespace-nowrap">Admin</span>
        </RouterLink>
        <RouterLink :to="{name: 'AdminQuestions', params: {userid: this.userid}}" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
          <i class="fa-solid fa-clipboard-question"></i>
          <span class="self-center text-xl whitespace-nowrap">domande</span>
        </RouterLink>
        <RouterLink :to="{name: 'AdminSurveys', params: {userid: this.userid}}" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
          <i class="fa-solid fa-book"></i>
          <span class="self-center text-xl whitespace-nowrap">Questionari</span>
        </RouterLink>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    data() {
      return {
        userid: '1'
      }
    },
    setup () {
          
  
      return {}
    }
  }
  </script>