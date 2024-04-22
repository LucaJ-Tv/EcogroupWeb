<template>
  <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-2/3 mx-auto ">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Questionari</h1>

  
  </div>
</template>

<script>
import axios from 'axios';
  export default {
    data() {
      return {
        questionari: []
      }
    },
    mounted() {
      this.mostraQuestionari();
    },
    methods: {
      mostraQuestionari() {
        axios.get('http://localhost/www/api/api-admin-get-surveys-scores.php')
        .then(response => {
          this.questionari = response.data;
        }).catch(error => {
          console.error(error);
        });
      }
    }
  }
</script>