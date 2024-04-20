<template>
  <div class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
    <h1 v-if="PaginaCorrente==0" class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Questionari presenti</h1>
    <h1 v-if="PaginaCorrente!=0" class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Modifica questionario</h1>
    <form class="w-full" @submit.prevent="submitForm()">
      <fieldset v-if="PaginaCorrente == 0">
        <table class="w-full">
          <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
            <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">ID</th>
            <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[90%]">Titolo</th>
          </tr>
          <tr v-for="questionario in questionari" class=" hover:cursor-pointer hover:bg-white hover:bg-opacity-10 rounded-xl" @click="modificaQuestionario(questionario)">
            <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center"> {{ questionario.codQuestionario }}</td>
            <td class="border-l-2 border-spacing-2 border-green-800 p-2"> {{ questionario.titolo }}</td>
          </tr>
        </table>
      </fieldset>
      <fieldset v-if="PaginaCorrente == 1" class="flex flex-col gap-2">
        <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="titolo">Titolo:</label>
        <input class="bg-green-900 px-2 mb-3 mx-1 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="titolo" id="titolo" name="titolo" v-model="titolo">
        <div class="flex justify-between gap-2">
          <div class="flex flex-col w-full">
            <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="CategoriaAttuale">Categoria</label>
            <select @change="disponiDomande()" class="bg-green-900 p-1 mt-1 rounded-md ring-1 ring-inset ring-green-700" id="CategoriaAttuale" name="CategoriaAttuale" v-model="categoriaCorrente">
              <option v-for="categoria in categorie">{{ categoria.nomeCategoria }}</option>
            </select>
          </div>
          <div class="flex flex-col w-full">
            <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="SezioneAttuale">Sezione</label>
            <select class="bg-green-900 p-1 mt-1 rounded-md ring-1 ring-inset ring-green-700" id="SezioneAttuale" name="SezioneAttuale" v-model="sezioneCorrente">
              <option v-for="sezione in sezioni">{{ sezione.nome }}</option>
            </select>
          </div>
        </div>
        <div class="overflow-auto box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 max-h-72 mt-2">
          <table class="overflow-auto w-full">
            <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Inserita</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[70%]">Testo</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Impatto</th>
              <th class="border-x-2 border-spacing-2 border-green-800 p-2 w-[10%]">Peso</th>
            </tr>
            <tr v-for="domanda in domandeVisibili" :key="domanda.codDomanda">
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">
                <span @click="domanda.inserire = !domanda.inserire">
                  <p v-if="!domanda.inserire" @click="modificaDomandeQuestionario(domanda)" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">Aggiungi</p>
                  <p v-if="domanda.inserire" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">Rimuovi</p>
                </span>
              </td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2"> {{ domanda.testo }}</td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center">
                <i v-if="domanda.positiva == 1" class="fa-solid fa-plus"></i>
                <i v-if="domanda.positiva == 0" class="fa-solid fa-minus"></i>
              </td>
              <td class="border-x-2 border-spacing-2 border-green-800 p-2 text-center"> <input v-model="domanda.peso" type="number" value="1" min="0" max="10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700"></td>
            </tr>
          </table>
        </div>
      </fieldset>
      <fieldset v-if="PaginaCorrente == 2" class="flex flex-col gap-2">
        <div class="p-2 bg-black bg-opacity-20 rounded-xl shadow-md">
          <label class="block font-bold mb-2 bg-opacity-20 rounded-xl shadow-md" for="commento">Descrizione</label>
          <textarea class="bg-green-900 px-2 py-1 ring-1 w-full h-32 text-start ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" id="commento" name="commento" maxlength="1024" v-model="commento"></textarea>
        </div>
        <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1" type="submit" value="Modifica">
      </fieldset>
      <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
          <p v-if="erroreForm">{{ erroreForm }}</p>
        </div>
        <div v-if="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">
          <p v-if="risultato">{{ risultato }}</p>
        </div>
    </form>
    <div class="flex justify-between">
      <button @click="tornaIndietro" v-if="PaginaCorrente != 0" class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Precedente</button>
      <button @click="avanti" v-if="PaginaCorrente == 1" class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Successivo</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
// per pushare il questionario aggiornato vanno eliminate tutte le occorenze in domande questionari e aggiornate con le nuove

export default {
    props: ['id'],
    data() {
      return{
        PaginaCorrente: 0,
        questionari: [],
        domandeQuestionario: [],
        domandeVisibili: [],
        categorie: [],
        sezioni: [], 
        sezioneCorrente: [],
        categoriaCorrente: '',
        numeroDomanda: 0,
        cod: '',
        titolo: '',
        commento: '',
        numeriDomandaAssoc: [],
        pesiAssoc: [],
        codiciDomandaAssoc: [],
        sezioniDomandaAssoc: [],
        erroreForm: '',
        risultato: '',
      }
    },
    mounted() {
      this.mostraQuestionari();
    },
    methods:{
      mostraQuestionari(){
        axios.get('http://localhost/www/api/api-admin-get-surveys-alterables.php')
        .then(response => {
          this.questionari = response.data;
        }).catch(error => {
          console.error(error);
        });
      },
      mostraDomandeQuestionario() {
        const formData = new FormData();
        formData.append('codQuestionario', this.cod);
        axios.post('http://localhost/www/api/api-admin-get-questions-survey.php', formData)
        .then(response => {
          this.domandeQuestionario = response.data;
          this.calcolaPrimoNumeroDomanda();
        }).catch(error => {
          console.error(error);
        });
      },
      mostraCategorie() {
        axios.get('http://localhost/www/api/api-admin-get-category.php')
        .then(response => {
          this.categorie = response.data;
        }).catch(error => {
          console.error(error);
        });
      },
      mostraSezioni() {
        const formData = new FormData();
        formData.append('codQuestionario', this.cod);
        axios.post('http://localhost/www/api/api-admin-get-sections.php', formData)
        .then(response => {
          this.sezioni = response.data;
          this.sezioneCorrente = this.sezioni[0]['nome'];
        }).catch(error => {
          console.error(error);
        });
      },
      submitForm() {
        this.risultato = '';
        this.erroreForm = '';
        if(this.controlloModifiche()) {
          this.sistemaArrayAssociativo();
          const formData = new FormData();
          formData.append('codModeratore', this.id);
          formData.append('commento', this.commento);
          formData.append('titolo', this.titolo);
          formData.append('codQuestionario', this.cod);
          formData.append('numeroDomanda', this.numeriDomandaAssoc);
          formData.append('peso', this.pesiAssoc);
          formData.append('codDomanda', this.codiciDomandaAssoc);
          formData.append('sezione', this.sezioniDomandaAssoc);

          axios.post('http://localhost/www/api/api-admin-alter-survey.php', formData)
          .then(response => {
            if (response.data.error == '') {
              this.risultato = 'Questionario modificato';
            } else {
              this.erroreForm = response.data.error;
            }
          }).catch(error => {
            console.error(error);
          });
        }
      },
      disponiDomande() {
        this.domandeVisibili = [];
        this.domandeQuestionario.forEach(element => {
          if(element.CATEGORIE_idCATEGORIA == this.categoriaCorrente) {
            this.domandeVisibili.push(element);
          }
        });
      },
      modificaQuestionario(questionarioSelezionato) {
        this.PaginaCorrente = 1;
        this.titolo = questionarioSelezionato.titolo
        this.cod = questionarioSelezionato.codQuestionario;
        this.mostraDomandeQuestionario();
        this.mostraSezioni();
        this.mostraCategorie();
      },
      tornaIndietro(){
        this.erroreForm = '';
        this.risultato = '';
        this.PaginaCorrente--;
        if(this.PaginaCorrente == 0){
          this.domandeQuestionario = [];
        }
      },
      avanti(){
        if(this.controlloModifiche()){
          this.PaginaCorrente++;
        }
      },
      calcolaPrimoNumeroDomanda(){
        this.domandeQuestionario.forEach(element => {
          if (element.numero > this.numeroDomanda) {
            this.numeroDomanda = element.numero;
          }
        });
        if(this.numeroDomanda != 0)
          this.numeroDomanda++;
      },
      modificaDomandeQuestionario(domanda){
        domanda.sezione = this.sezioneCorrente;
        domanda.numero = this.numeroDomanda;
        this.numeroDomanda++;
      },
      controlloModifiche(){
        this.erroreForm = '';
        let numeroDiDomande = 0;
        let domandeSenzaPeso = 0;
        this.domandeQuestionario.forEach(element => {
          if (element.inserire) {
            numeroDiDomande++;
            if (element.peso <= 0) {
            domandeSenzaPeso++;
            }
          }
        });
        //appena arrivato a casa aggiungere textbox e backend
        if(this.titolo == '') {
          this.erroreForm = 'inserire un titolo valido';
          return false;
        } else if(numeroDiDomande == 0) {
          this.erroreForm = 'inserire almeno una domanda';
          return false;
        } else if(domandeSenzaPeso != 0) {
          this.erroreForm = 'inserire il peso in tutte le domande';
          return false;
        } else if (this.PaginaCorrente == 2 && this.commento == '') {
          this.erroreForm = 'inserire un commento';
          return false;
        } else {
          return true;
        }
      },
      sistemaArrayAssociativo(){
        let numeriDomanda = [];
        let pesi = [];
        let codiciDomanda = [];
        let sezioni = [];
        this.domandeQuestionario.forEach(domanda => {
          if(domanda.inserire){
            numeriDomanda.push(domanda.numero);
            pesi.push(domanda.peso);
            codiciDomanda.push(domanda.codDomanda);
            sezioni.push(domanda.sezione);
          }
        });

        this.numeriDomandaAssoc = numeriDomanda;
        this.pesiAssoc = pesi;
        this.codiciDomandaAssoc = codiciDomanda;
        this.sezioniDomandaAssoc = sezioni;
      }
    }
}
</script>