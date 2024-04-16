<template>
  <div class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Crea questionario</h1>
    <form @submit.prevent="submitForm">
      <fieldset class="flex flex-col gap-2 text-left" v-if="primaPagina">
        <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="titolo">Titolo:</label>
        <input class="bg-green-900 px-2 mb-3 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="titolo" id="titolo" name="titolo" v-model="titolo">

        <label for="sezioni" class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Sezioni</label>
        <p class="text-xs pb-2 ml-2">(premi "/" una volta inserita)</p>
        <input  type="text" id="sezioni" name="sezioni" class="bg-green-900 px-2 mb-3 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" v-model="tempSezione" @keyup="addSezione">
        <div class="gap-2 flex flex-wrap">
          <div class="bg-black bg-opacity-30 rounded-xl px-2 cursor-pointer text-green-500 flex" v-for="sezione in sezioni" :key="sezione">
            <span @click="removeSezione(sezione)" class="flex gap-1 items-center"><i class="fa-regular fa-circle-xmark"></i> {{sezione}}</span>
          </div>
        </div>
        <!-- {{ sezioni }} -->
      </fieldset>
      <fieldset v-if="!primaPagina" class="flex flex-col gap-2 text-left">
        <div class="flex justify-between gap-2">
          <div class="flex flex-col w-full">
            <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="CategoriaAttuale">Categoria</label>
            <select @change="disponiDomande()" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" id="CategoriaAttuale" name="CategoriaAttuale" v-model="categoriaCorrente">
              <option v-for="categoria in categorie">{{ categoria.nomeCategoria }}</option>
            </select>
          </div>
          <div class="flex flex-col w-full">
            <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="SezioneAttuale">Sezione</label>
            <select class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" id="SezioneAttuale" name="SezioneAttuale" v-model="sezioneCorrente">
              <option v-for="sezione in sezioni">{{ sezione }}</option>
            </select>
          </div>
        </div>
        <div class="w-full box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 max-h-96 mt-5">
          <table class="w-full">
            <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Inserita</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[70%]">Testo</th>
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Impatto</th>
              <th class="border-x-2 border-spacing-2 border-green-800 p-2 w-[10%]">Peso</th>
            </tr>
            <tr v-for="domanda in domandeInCategoria">
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">
                <span @click="toggleInserita(domanda.testo), addDomandeQuestionari()">
                  <p v-if="!domanda.inserire" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">Aggiungi</p>
                  <p v-if="domanda.inserire" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">Rimuovi</p>
                </span>
              </td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2"> {{ domanda.testo }}</td>
              <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center"><i v-if="domanda.positiva == 1" class="fa-solid fa-plus"></i><i v-if="domanda.positiva == 0" class="fa-solid fa-minus"></i></td>
              <td class="border-x-2 border-spacing-2 border-green-800 p-2 text-center"> <input v-model="domanda.peso" type="number" value="1" min="0" max="10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700"></td>
            </tr>
          </table>
        </div>
        <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1" type="submit" value="Crea">
      </fieldset>

    </form>
    <button @click="cambiaPagina" v-if="primaPagina" class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Successivo</button>
    <button @click="cambiaPagina" v-if="!primaPagina" class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Precedente</button>
    <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
      <p v-if="erroreForm">{{ erroreForm }}</p>
    </div>
    <div v-if="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">
      <p v-if="risultato">{{ risultato }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
  export default {
    props: {
      id: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        titolo: '',
        categorie:[],
        categoriaCorrente: '',
        domandeInCategoria: [],
        domandeQuestionari: [],
        tempSezione: '',
        sezioni: [],
        risultato: '',
        erroreForm: '',
        primaPagina: true,
        indiceDomandaInternoAlQuestionario: 0,
        numeriDomandaAssoc: [],
        pesiAssoc: [],
        codiciDomandaAssoc: [],
        sezioniDomandaAssoc: [],
        sezioneCorrente: ''
      }
    }, 
    mounted() {
      this.updateCategories();
    },
    methods: {
      updateCategories(){
        axios.get('http://localhost/www/api/api-admin-get-category.php')
        .then(response => {
          this.categorie = response.data;
        }).catch(error => {
          console.error(error);
        });
      },
      cambiaPagina() {
        this.erroreForm = '';
        this.risultato = '';
        if(!this.primaPagina) {
          this.addDomandeQuestionari();
          this.domandeInCategoria = [];
          if(this.categoriaCorrente.length != 0) {
            this.disponiDomande();
          }
        }
        this.primaPagina = !this.primaPagina;
      },
      disponiDomande() {
        const formData = new FormData();
        formData.append('categoria', this.categoriaCorrente);
        axios.post('http://localhost/www/api/api-admin-get-questions.php', formData)
        .then(response => {
          this.domandeInCategoria = response.data;
          if(this.domandeInCategoria !== undefined)
            this.domandeInCategoria = this.controlloDomandeQuestionari(this.domandeInCategoria);
        }).catch(error => {
          console.error(error);
        });
      },
      toggleInserita(testo) {
        this.erroreForm = '';
        if (this.sezioneCorrente != '') {
          this.domandeInCategoria.forEach(domanda => {
            if (domanda.testo === testo) {
              if (domanda.inserire === undefined) {
                domanda.inserire = true;
                domanda.numeroDomanda = this.indiceDomandaInternoAlQuestionario;
                this.indiceDomandaInternoAlQuestionario++;
              } else {
                if (!domanda.inserire) {
                  domanda.numeroDomanda = this.indiceDomandaInternoAlQuestionario;
                  this.indiceDomandaInternoAlQuestionario++;
                }
                domanda.inserire = !domanda.inserire;
              }
            }
          });
        } else {
          this.erroreForm = 'seleziona una sezione';
        }
      },
      //serve una funzione di aggiunta all'array associativo Domande_questionari.
      // se il codice della domanda non è presente in una riga del nuovo array
      // presa in input una riga del array vecchio controlla il campo domanda inserire se = true allora aggiunge il codice della domanda, il peso, codice della domanda 
      addDomandeQuestionari(){
        this.domandeInCategoria.forEach(domanda => {
          if(domanda.inserire !== undefined) {
            if(!this.giaPresente(domanda.codDomanda) && domanda.inserire) {
              // se non completato diamo un valore di default alla domanda
              if(domanda.peso === undefined) {
                domanda.peso = 1;
              } else {
                this.domandeQuestionari.push({
                  codDomanda: domanda.codDomanda,
                  numeroDomanda: domanda.numeroDomanda,
                  peso: domanda.peso,
                  sezione : this.sezioneCorrente
                });
              }
            } else {
              if(!domanda.inserire) {
                const index = this.domandeQuestionari.findIndex(item => item.codDomanda === domanda.codDomanda);
                if (index !== -1) {
                  this.domandeQuestionari.splice(index, 1);
                }
              }
            }
          }
        });
      },
      giaPresente(codiceDomanda) {
        for (let domanda of this.domandeQuestionari) {
          if (domanda.codDomanda === codiceDomanda) {
            return true;
          }
        }
        return false;
      },
      controlloDomandeQuestionari(domande) {
        domande.forEach((elemento) => {
          if (this.giaPresente(elemento.codDomanda)){
            elemento.inserire = true;
            this.domandeQuestionari.forEach((domanda) => {
              if(elemento.codDomanda == domanda.codDomanda) {
                elemento.peso = domanda.peso;
                elemento.numeroDomanda = domanda.numeriDomanda;
                elemento.sezione = domanda.sezione;
              }
            });
          } else {
            elemento.sezione = this.sezioni[0];
            elemento.peso = 1;
            elemento.numeroDomanda = '';
          }
          delete elemento.moderatori_codModeratore;
        });
        return domande;
      },
      submitForm() {
        this.erroreForm = '';
        this.risultato = '';
        if(this.checkForm()){
          const formData = new FormData();
          this.sistemaArrayAssociativo();
          formData.append('adminID', this.id);
          formData.append('titolo', this.titolo);
          formData.append('numeroDomanda', this.numeriDomandaAssoc);
          formData.append('peso', this.pesiAssoc);
          formData.append('codDomanda', this.codiciDomandaAssoc);
          formData.append('sezione', this.sezioniDomandaAssoc);
          formData.append('sezioniDaAggiungere', this.sezioni);

          axios.post('http://localhost/www/api/api-admin-add-survey.php', 
          formData).then(response => {
          if (response.data.error == ''){
            this.risultato = response.data.result;
            
            this.domandeQuestionari = [];
            this.titolo = '';
          } else {
            this.erroreForm = response.data.error;
          };
          }).catch(error => {
            console.error(error);
          });    
        }
      },
      checkForm(){
        if(this.titolo == '') {
          this.erroreForm = 'il questionario non ha titolo';
          return false;
        }
        if(this.domandeQuestionari.length < 1) {
          this.erroreForm = 'il questionario non ha domande';
          return false;
        }
        for (let domanda of this.domandeQuestionari) {
          if (domanda.peso <= 0 || domanda.peso > 10) {
            this.erroreForm = 'il peso delle domande deve essere compreso tra 0 e 10';
            return false;
          }
        }
        return true;
      },
      addSezione(e){
        if(e.key === '/' && this.tempSezione){
          if(!this.sezioni.includes(this.tempSezione)){
            this.tempSezione = this.rimuoviSlash(this.tempSezione)
            this.sezioni.push(this.tempSezione)
          }
          this.tempSezione=''
        }
      },
      removeSezione(sezioneDaRimuovere){
        this.sezioni = this.sezioni.filter((sezione) => {
          return sezioneDaRimuovere != sezione
        })
      },
      rimuoviSlash(risposta) {
        return risposta.replace(/\//g, '');
      },
      sistemaArrayAssociativo( ){
        let numeriDomanda = [];
        let pesi = [];
        let codiciDomanda = [];
        let sezioni = [];
        this.domandeQuestionari.forEach(domanda => {
          numeriDomanda.push(domanda.numeroDomanda);
          pesi.push(domanda.peso);
          codiciDomanda.push(domanda.codDomanda);
          sezioni.push(domanda.sezione);
        });

        this.numeriDomandaAssoc = numeriDomanda;
        this.pesiAssoc = pesi;
        this.codiciDomandaAssoc = codiciDomanda;
        this.sezioniDomandaAssoc = sezioni;
      }
    }
  }
</script>