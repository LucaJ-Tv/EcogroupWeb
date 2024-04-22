<template>
  <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-2/3 mx-auto ">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Questionari</h1>
    <div v-if="primapagina">
      <table class="w-full">
        <tr class="bg-black bg-opacity-20 p-2 shadow-md">
          <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Ordine</th>
          <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Id</th>
          <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[80%]">Titolo</th>
        </tr>
        <tr v-for="questionario in questionari" class=" hover:cursor-pointer hover:bg-white hover:bg-opacity-10">
          <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" @click="mostraRisultati(questionario.codQuestionario)"> {{ questionario.ordine }}</td>
          <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" @click="mostraRisultati(questionario.codQuestionario)"> {{ questionario.codQuestionario }}</td>
          <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" @click="mostraRisultati(questionario.codQuestionario)"> {{ questionario.titolo }}</td>
        </tr>
      </table>
    </div>
    <div v-if="!primapagina" class="px-3 bg-opacity-20 bg-black w-full p-2 rounded-xl shadow-md">
      <h2 class="font-Inter text-lg mb-2 pl-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Risultati aziende</h2>
      <div class="px-4">
        <div v-for="item in punteggiVisibili" :key="item.aziende_codAzienda" class="mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md flex justify-between px-3">
          <p>{{ item.dataCompilazione }}</p>
          <p>{{ item.nomeAzienda }}</p>
          <p>{{ item.punteggio }}</p>
        </div>
      </div>
      <button @click="tornaIndietro" class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Precedente</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
  export default {
    data() {
      return {
        punteggiVisibili: [],
        questionari: [],
        punteggi: [],
        primapagina: true
      }
    },
    mounted() {
      this.mostraQuestionari();
    },
    methods: {
      mostraQuestionari() {
        axios.get('http://localhost/www/api/api-admin-get-surveys-scores.php')
        .then(response => {
          this.questionari = response.data.surveys;
          this.punteggi = response.data.scores;
        }).catch(error => {
          console.error(error);
        });
      },
      disponiQuestionari(codQuestionario) {
        this.punteggiVisibili = [];
        this.punteggi.forEach(element => {
          if(element.codQuestionario == codQuestionario) {
            this.punteggiVisibili.push(element);
          }
        });
      },
      mostraRisultati(codQuestionario) {
        this.primapagina = !this.primapagina;
        this.disponiQuestionari(codQuestionario);
      },
      tornaIndietro() {
        this.primapagina = !this.primapagina;
      }
    }
  }
</script>