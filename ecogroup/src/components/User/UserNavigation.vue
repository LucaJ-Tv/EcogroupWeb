<template>
  <nav class="rounded-t-lg bg-opacity-70 shadow-md bg-site-primary border-t border-green-600 mx-1 pt-5 pb-3">
    <div class="flex justify-center gap-3 md:gap-10 text-center w-full mx-auto">
      <RouterLink :to="{name: 'Questionari', params: {userid: this.userid}}" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
        <i class="fa-solid fa-clipboard-check"></i>
        <span class="self-center text-xl whitespace-nowrap">Questionari svolti</span>
      </RouterLink>
      <!-- temporaneamente questo link manda al questionario obbligatorio -->
      <RouterLink :to="{name: 'QuestionarioObbligatorio', params: {userid: this.userid}}" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
        <i class="fa-solid fa-clipboard-question"></i>
        <span class="self-center text-xl whitespace-nowrap">Nuovo questionario</span>
      </RouterLink>
    </div>
  </nav>
</template>

<script>
export default {
  props: ['userid'],
}
</script>