<template>
  <div class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Domande presenti</h1>
    <form class="flex flex-col" @submit.prevent="submitForm">
      <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md" for="CategoriaAttuale" v-if="primaPagina">Categoria</label>
      <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md" for="CategoriaAttuale" v-if="!primaPagina">Modifica</label>
      <select @change="disponiDomande()" class="bg-green-900 p-2 mt-1 mx-1 rounded-md ring-1 ring-inset ring-green-700" id="CategoriaAttuale" name="CategoriaAttuale" v-model="categoriaCorrente" v-if="primaPagina">
        <option v-for="categoria in categorie">{{ categoria.nomeCategoria }}</option>
      </select>
      <table class="w-full mt-4">
        <fieldset v-if="primaPagina">
          <div class="max-h-96 overflow-auto">
            <table class="w-full">
            <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">ID</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[80%]">Testo</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[5%]">Impatto</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[5%]"> Rimuovi</th>
            </tr>
            <tr v-for="domanda in domandeInCategoria" class=" hover:cursor-pointer hover:bg-white hover:bg-opacity-10 rounded-xl">
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" @click="modificaDomanda(domanda)"> {{ domanda.codDomanda }}</td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2" @click="modificaDomanda(domanda)"> {{ domanda.testo }}</td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" @click="modificaDomanda(domanda)"><i v-if="domanda.positiva == 1" class="fa-solid fa-plus"></i><i v-if="domanda.positiva == 0" class="fa-solid fa-minus"></i></td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" @click="eliminaDomanda(domanda.codDomanda)"> 
                <p class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl"> elimina </p>
              </td>
            </tr>
          </table>
          </div>
        </fieldset>
        <fieldset v-if="!primaPagina">
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
          <div class="flex justify-center">
            <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 w-1/4" type="submit" value="modifica">
          </div>
          <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
            <p v-if="erroreForm">{{ erroreForm }}</p>
          </div>
          <div v-if="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">
            <p v-if="risultato">{{ risultato }}</p>
          </div>
        </fieldset>
      </table>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

  export default {
    data () {
    return {
      cod: '',
      categoriaAggiungere: '',
      categoriaCorrente: '',
      categoriaSelezionata: '',
      testoDomanda: '',
      positivo: '',
      categorie:[],
      domandeInCategoria: [],
      primaPagina: true,
      risultato: '',
      erroreForm: ''
    }
    },
    mounted() {
      this.updateCategories();
    }, 
    methods: {
      updateCategories(){
        axios.get('./../../../api/api-admin-get-category.php')
        .then(response => {
          this.categorie = response.data;
          this.categoriaCorrente = this.categorie[0]['nomeCategoria'];
          this.disponiDomande();
        }).catch(error => {
          console.error(error);
        });
      },
      disponiDomande() {
        const formData = new FormData();
        formData.append('categoria', this.categoriaCorrente);
        axios.post('./../../../api/api-admin-get-questions-alterables.php', formData)
        .then(response => {
          this.domandeInCategoria = response.data;
        }).catch(error => {
          console.error(error);
        });
      },
      modificaDomanda(domandaSelezionata) {
        this.primaPagina= !this.primaPagina;
        this.testoDomanda = domandaSelezionata.testo
        this.categoriaSelezionata = domandaSelezionata.CATEGORIE_idCATEGORIA
        if (domandaSelezionata.positiva === 1) {
          this.positivo = true;
        } else {
          this.positivo = false;
        }
        this.cod = domandaSelezionata.codDomanda;
      },
      submitForm () {
      this.risultato = '';
      this.erroreForm = '';
      if(this.isFormOk()) {
        const formData = new FormData();
        formData.append('testo', this.testoDomanda);
        formData.append('categoria', this.categoriaSelezionata);
        formData.append('isPositive', this.positivo);
        formData.append('cod', this.cod);
        axios.post('./../../../api/api-admin-alter-question.php', 
        formData).then(response => {
          if (response.data.error == ''){
            this.risultato = 'Domanda Modificata';
            this.erroreForm = '';
          } else {
            this.erroreForm = response.data.error;
          };
        }).catch(error => {
          console.error(error);
        });    
      }
    },
    eliminaDomanda(codDomanda) {
      const formData = new FormData();
        formData.append('codDomanda', codDomanda);
        axios.post('./../../../api/api-admin-remove-quesion.php', formData)
        .catch(error => {
          console.error(error);
        }).then(() => {
          this.domandeInCategoria = [];
          this.disponiDomande();
        });
    },
    isFormOk() {
      if (!this.categoriaSelezionata || this.categoriaSelezionata.trim() === '' || !this.testoDomanda || this.testoDomanda.trim() === '') {
        this.erroreForm = 'tutti i campi devono essere compilati';
        return false;
      } else {
        return true;
      }
    },
    }
  }
</script>
