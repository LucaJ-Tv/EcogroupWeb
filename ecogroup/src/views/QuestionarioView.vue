<template>
    <div class="mx-2 my-3 xl:mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg">
      <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">{{ titolo }}</h1>
      <div class="flex gap-3 flex-col md:flex-row justify-between">
        <div class="sezioni bg-black bg-opacity-20 p-2 rounded-xl shadow-md md:w-2/5">
          <div @click="Selezionasezione(sezione)" class="border border-site-secondary rounded-lg px-2 py-1 mb-1 hover:bg-site-primary cursor-pointer" v-for="sezione in sezioni"> 
            {{ sezione }}
          </div>
          <button @click="questionarioCompletato()" class="border-site-secondary border w-full rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary">Invia</button>
          <div v-if="!finito || error != ''" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-2 rounded-xl mt-2">
            <p>{{ error }}</p>
          </div>
        </div>
        <div class="DOMANDE w-full overflow-auto h-96">
          <div v-for="domanda in domandeVisibili" :key="domanda.codDomandaQuestionario" :v-if="domanda.sezioni_nome == sezioneSelezionata">
            <Domanda :id="domanda.numeroDomanda" :sezione="domanda.sezioni_nome" :testo="domanda.testo" :scelte="domanda.scelteValori" :rispostaSel="getRisposta(domanda.codDomandaQuestionario)" @eventorisposta="aggiuniRisposta($event, domanda.codDomandaQuestionario)" />
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios';
import Domanda from '../components/Questionario/DomandeTemplate';

export default {
  props: ['userid'],
  components: {Domanda},
  data(){
    return{
      //struttura della domanda è [codDomanda, numeroDomanda, sezione, testo, e scelte]
      titolo: '',
      domande: [],
      domandeVisibili: [],
      sezioni: [],
      scelte: {}, //questa mappa contiene le risposte a tutte le domande
      sezioneSelezionata: '',
      finito: true,
      error: ''
    }
  },
  mounted() {
    this.mostraQuestionario()
  },
  methods:{
    mostraQuestionario() {
      const formData = new FormData();
      formData.append('titolo', 'Questionario obbligatorio');
      axios.post('./www/api/api-user-get-survey.php', formData)
      .then(response => {
        this.titolo = response.data.titolo;
        this.domande = response.data.result;
      })
      .then(() => {
        this.mostraSezione();
        this.mostraDomande();
      })
      .catch(error => {
        console.error(error);
      });
    },
    submitForm() {
      const formData = new FormData();
      formData.append('codQuestionario', this.domande[0]['sezioni_questionari_codQuestionario']);
      formData.append('codAzienda', this.userid);
      formData.append('codDomande', Object.keys(this.scelte));
      formData.append('risposte', this.convertiScelteInPunteggio());
      axios.post('./www/api/api-user-add-done-survey.php', formData)
      .then(response => {
        this.error = '';
        if(response.data.error == '') {
          this.$emit('loggedInUser')
          this.$router.push({name: 'Questionari', params: {userid: this.userid}});
        } else {
          this.error = response.data.error;
        }
      })
      .catch(error => {
        console.error(error);
      });
    },
    mostraDomande() {
      this.domandeVisibili = this.domande.filter(domanda => {
        return domanda.sezioni_nome == this.sezioneSelezionata
      });
    },
    mostraSezione() {
      this.sezioni = []
      this.domande.forEach(domanda => {
        if(!this.sezioni.includes(domanda.sezioni_nome)){
          this.sezioni.push(domanda.sezioni_nome)
          this.sezioneSelezionata = this.sezioni.at(0)
        }
      });
    },
    Selezionasezione(sezione) {
      this.sezioneSelezionata = sezione
      this.mostraDomande()
    },
    aggiuniRisposta(risposta, id) {
      this.scelte[id] = risposta
    },
    getRisposta(idDatrovare) {
      return this.scelte[idDatrovare]
    },
    convertiScelteInPunteggio() {
      const pesi = [];
      for (const idDomanda in this.scelte) {
      // Ottieni il valore della risposta dall'ID della domanda
        const risposta = this.scelte[idDomanda];
        const domandaCorrispondente = this.domande.find(domanda => domanda.codDomandaQuestionario === parseInt(idDomanda));
        if (domandaCorrispondente && domandaCorrispondente.sceltePesi) {
          const indiceRisposta = domandaCorrispondente.scelteValori.indexOf(risposta);
          if (indiceRisposta !== -1 && indiceRisposta < domandaCorrispondente.sceltePesi.length) {
            const pesoRisposta = domandaCorrispondente.sceltePesi[indiceRisposta];
            pesi.push(pesoRisposta);
          }
        }
      }
      return pesi;
    },
    questionarioCompletato() {
      this.finito = false;
      this.error = 'completa prima il questionario';
      let numeroScelte = Object.keys(this.scelte).length;
      if(numeroScelte == this.domande.length) {
        this.error = '';
        this.finito=true;
        this.submitForm();
      }
    }
  }
}
</script>