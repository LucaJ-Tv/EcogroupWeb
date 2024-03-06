<template>
  <div class="mx-2 my-3 xl:mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-3/4">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-30 p-2 rounded-xl shadow-md justify-start">Questionari compilati</h1>
    <div class="QUESTIONARI">
      <Questionario v-for="questionario in questionari" :key="questionario.id" :id="questionario.id" :titolo="questionario.titolo" :punteggio="questionario.punteggio"></Questionario>
    </div>
  </div>
</template>

<script>

import Questionario from '../../components/Questionario/QuestionarioCompletato.vue';

export default {
  props: ['userid'],
  components: {Questionario},
  data() {
    return {

      //importato dal db con i punteggi calcolati in base alle risposte
      questionari: [{id: '1', titolo: 'Questionario obbligatorio', punteggio: '51'},
      {id: '2', titolo: 'Questionario 2', punteggio: '81'}, 
      {id: '3', titolo: 'Questionario 3', punteggio: '100'}, 
      {id: '4', titolo: 'Questionario 4', punteggio: '91'},]
    }
  },
  setup () {

    return {}
  }
}
</script>