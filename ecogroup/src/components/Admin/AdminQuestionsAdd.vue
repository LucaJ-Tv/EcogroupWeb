<template>
  <div class="w-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
  <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Aggiunta domanda</h1>
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label class="block font-bold mb-2" for="domandaText">Testo della domanda</label>
        <textarea class="bg-green-900 px-2 py-1 ring-1 w-full h-32 text-start ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" id="domandaText" name="domandaText" maxlength="1024" v-model="testoDomanda"></textarea>
      </div>
      <div class="flex justify-between self-center">
        <div class="mb-4">
          <input class="mr-2 leading-tight bg-green-800" type="checkbox" id="positiveImpact" v-model="positivo">
          <label class="font-bold" for="positiveImpact">Impatto positivo</label>
        </div>
        <div class="mb-4">
          <label class="font-bold mb-2 mr-2" for="category">Categoria</label>
          <select class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" id="category" v-model="categoriaSelezionata">
            <option v-for="categoria in categorie">{{ categoria.nomeCategoria }}</option>
          </select>
        </div>
      </div>
      <div class="mb-4">
        <label for="risposte">Possibili risposte</label>
        <p class="text-xs pb-2">(premi "/" una volta inserita)</p>
        <input  type="text" id="risposte" name="risposte" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md w-full" v-model="tempRisposta" @keyup="addRisposta">
        <div class="gap-2 flex">
          <div class="bg-black bg-opacity-30 rounded-xl px-2 mt-3 cursor-pointer text-green-500" v-for="risposta in risposte" :key="risposta">
            <span @click="removeRisposta(risposta)" class="flex gap-1 items-center"><i class="fa-regular fa-circle-xmark"></i> {{risposta}}</span>
          </div>
        </div>
      </div>
      <div class="flex justify-center">
        <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 w-1/4" type="submit" value="aggiungi">
      </div>
      <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
        <p v-if="erroreForm">{{ erroreForm }}</p>
      </div>
      <div v-if="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">
        <p v-if="risultato">{{ risultato }}</p>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data () {
    return {
      testoDomanda: '',
      categorie: [],
      risposte: [],
      positivo: false,
      tempRisposta: '',
      categoriaSelezionata: '',
      idCategoria: '',
      risultato: '',
      erroreForm: ''
    }
  },
  mounted() {
    this.updateCategories();
  },
  methods: {
    submitForm () {
      this.calcolaCateria(this.categoriaSelezionata);
      this.risultato = '';
      this.erroreForm = '';
      if(this.isFormOk()) {
        const formData = new FormData();
        formData.append('testo', this.testoDomanda);
        formData.append('categoria', this.categoriaSelezionata);
        formData.append('isPositive', this.positivo);
        formData.append('risposte', this.risposte);
        axios.post('http://localhost/www/api/api-admin-add-question.php', 
        formData).then(response => {
          if (response.data.error == ''){
            console.log(response.data);
            this.risultato = 'Domanda aggiunta';
            this.erroreForm = '';

            this.testoDomanda = '';
            this.positivo = false;
            this.categoriaSelezionata = '';
            this.risposte = '';
          } else {
            this.erroreForm = response.data.error;
          };
        }).catch(error => {
          console.error(error);
        });    
      }
    },
    isFormOk() {
      if (!this.categoriaSelezionata || this.categoriaSelezionata.trim() === '' || !this.testoDomanda || this.testoDomanda.trim() === '' || this.risposte.length < 2) {
        this.erroreForm = 'tutti i campi devono essere compilati';
        if(this.risposte.length < 2)
          this.erroreForm = 'una domanda deve avere almeno due risposte';
        return false;
      } else {
        return true;
      }
    },
    updateCategories() {
      axios.get('http://localhost/www/api/api-admin-get-category.php')
      .then(response => {
        this.categorie = response.data;
      }).catch(error => {
        console.error(error);
      });
    },
    addRisposta(e){
      if(e.key === '/' && this.tempRisposta){
        if(!this.risposte.includes(this.tempRisposta)){
          this.tempRisposta = this.rimuoviSlash(this.tempRisposta)
          this.risposte.push(this.tempRisposta)
        }
        this.tempRisposta=''
      }
    },
    removeRisposta(rispostaDaRimuovere){
      this.risposte = this.risposte.filter((risposta) => {
        return rispostaDaRimuovere != risposta
      })
    },
    rimuoviSlash(risposta) {
      return risposta.replace(/\//g, '');
    },
    calcolaCateria(value) {
      for (let categoria of this.categorie) {
        if (categoria.nomeCategoria === value) {
            this.idCategoria = categoria.codCategoria;
        }
    }
    }
  }

}
</script>