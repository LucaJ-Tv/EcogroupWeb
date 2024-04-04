<template>
  <div class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Categorie</h1>
    <div class="flex justify-center gap-2">
      <div class="w-1/2 text-center box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 h-fit">
        <form class="flex flex-col gap-2 text-left" @submit.prevent="submitForm">
          <label class="font-Inter text-xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md" for="categoria">Aggiungi categoria:</label>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="categoria" id="categoria" name="categoria" v-model="categoriaAggiungere">
          <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1" type="submit" value="aggiungi">
        </form>
        <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
          <p v-if="erroreForm">{{ erroreForm }}</p>
        </div>
        <div v-if="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">
          <p v-if="risultato">{{ risultato }}</p>
        </div>
      </div>
      <div class="w-1/2 box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 max-h-96">
      <h3 class="font-Inter text-xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Già resenti:</h3>
        <ul class="h-[85%] overflow-auto ">
          <li v-for="categoria in categorie" class="mb-2">
            <div class="flex flex-auto gap-2">
              <p class="bg-black bg-opacity-20 shadow-md px-2 rounded-full py-1"> {{ categoria.codCategoria }} </p>
              <p class="bg-black bg-opacity-20 shadow-md px-2 mr-1 rounded-xl w-full pl-3 py-1"> {{ categoria.nomeCategoria }} </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data () {
    return {
      categoriaAggiungere: '',
      categorie:[],
      risultato: '',
      erroreForm: ''
    }
  },
  mounted() {
    this.updateCategories();
  },
  methods: {
    submitForm () {
      this.risultato = '';
      const formData = new FormData();
      formData.append('categoria', this.categoriaAggiungere);
      
      axios.post('http://localhost/www/api/api-admin-add-category.php', 
      formData).then(response => {
        if (response.data.error == ''){
          console.log(response.data);
          this.risultato = 'categoria aggiunta';
          this.erroreForm = '';
          //resetto per aggiungere altre categorie
          this.categoriaAggiungere = '';
        } else {
          this.erroreForm = response.data.error;
        };
        this.updateCategories();
      }).catch(error => {
        console.error(error);
      });    
    },
    updateCategories(){
      axios.get('http://localhost/www/api/api-admin-get-category.php')
      .then(response => {
        this.categorie = response.data;
      }).catch(error => {
        console.error(error);
      });
    }
  }

}
</script>

<style>
  /* tailwind non permette di personalizzare la scrollbar :( */
   ::-webkit-scrollbar {
    width: 10px;
  }

  ::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.3); /* Nero con 30% di opacità */
    border-radius: 6px;
  }

  ::-webkit-scrollbar-track {
    background-color: rgba(0, 0, 0, 0.3); /* Nero con 30% di opacità */
    border-radius: 6px;
  }
</style>