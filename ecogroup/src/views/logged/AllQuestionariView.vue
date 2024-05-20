<template>
  <div class="mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-3/4">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-30 p-2 rounded-xl shadow-md justify-start">Questionari compilati</h1>
    <div class="QUESTIONARI">
      <Questionario v-for="questionario in punteggi" :key="questionario.id" :id="questionario.id" :titolo="questionario.titolo" :punteggio="questionario.punteggio"></Questionario>
    </div>
  </div>
</template>

<script>

import Questionario from '../../components/Questionario/QuestionarioCompletato.vue';

import axios from 'axios';
export default {
  props: ['userid'],
  components: {Questionario},
  data() {
    return {
      //importato dal db con i punteggi calcolati in base alle risposte
      punteggi: [],
    }
  },
  mounted() {
    this.mostraQuestionari();
  },
  methods: {
    mostraQuestionari () {
      const formData = new FormData();
      formData.append('codAzienda', this.userid);
      axios.post('./www/api/api-user-get-survey-score.php', formData)
      .then(response => {
        this.punteggi = response.data.result;
      }).catch(error => {
        console.error(error);
      });
    }
  }
}
</script>