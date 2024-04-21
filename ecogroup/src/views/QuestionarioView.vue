<template>
    <div class="mx-2 my-3 xl:mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg">
      <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">{{ titolo }}</h1>
      <div class="flex gap-3 flex-col md:flex-row justify-between">
        <div class="sezioni bg-black bg-opacity-20 p-2 rounded-xl shadow-md md:w-2/5">
          <div @click="Selezionasezione(sezione)" class="border border-site-secondary rounded-lg px-2 py-1 mb-1 hover:bg-site-primary cursor-pointer" v-for="sezione in sezioni"> 
            {{ sezione }}
          </div>
          <button @click="questionarioCompletato()" class="border-site-secondary border w-full rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary">Invia</button>

          <div v-if="!finito" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-2 rounded-xl mt-2">
            <p>Completa prima il questionario</p>
          </div>
        </div>
        <div class="DOMANDE w-full">
          <div v-for="domanda in domandeVisibili" :key="domanda.DOMANDE_codDomanda" :v-if="domanda.sezioni_nome == sezioneSelezionata">
            <Domanda :id="domanda.numeroDomanda" :sezione="domanda.sezioni_nome" :testo="domanda.testo" :scelte="domanda.scelteValori" :rispostaSel="getRisposta(domanda.DOMANDE_codDomanda)" @eventorisposta="aggiuniRisposta($event, domanda.DOMANDE_codDomanda)" />
          </div>
        </div>

        <!-- {{ scelte }} -->
        <!-- 
        <div v-for="item in domande" :key="item.codDomandaQuestionario">
          <div v-for="item in item.scelte" :key="item.peso">
            {{ item.valore }}
          </div>
        </div> -->
      
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
      domandeDb:[{id: 1, sezione: 'parametri green', testo: 'Seeking a skilled Frontend Developer with expertise in Vue.js to join our dynamic team. You will be responsible for designing and implementing user interfaces, collaborating with the UX/UI team, and ensuring seamless integration with backend services.', scelte: ['si', 'no', 'forse'] },
      { id: 2, sezione: 'parametri green', testo: 'We are hiring a Vue.js Software Engineer to work on our innovative projects. As a key member of the development team, you will be involved in the full software development lifecycle, from design to deployment. Strong problem-solving skills and a passion for clean, efficient code are essential.', scelte: ['si', 'no', 'forse']},
      { id: 3, sezione: 'parametri green', testo: 'Seeking a skilled Frontend Developer with expertise in Vue.js to join our dynamic team. You will be responsible for designing and implementing user interfaces, collaborating with the UX/UI team, and ensuring seamless integration with backend services.', scelte: ['si', 'no', 'forse'] },
      { id: 4, sezione: 'parametri green', testo: 'We are hiring a Vue.js Software Engineer to work on our innovative projects. As a key member of the development team, you will be involved in the full software development lifecycle, from design to deployment. Strong problem-solving skills and a passion for clean, efficient code are essential.', scelte: ['si', 'no', 'forse']},
      { id: 5, sezione: 'parametri green', testo: 'Seeking a skilled Frontend Developer with expertise in Vue.js to join our dynamic team. You will be responsible for designing and implementing user interfaces, collaborating with the UX/UI team, and ensuring seamless integration with backend services.', scelte: ['si', 'no', 'forse'] },
      { id: 6, sezione: 'parametri green', testo: 'We are hiring a Vue.js Software Engineer to work on our innovative projects. As a key member of the development team, you will be involved in the full software development lifecycle, from design to deployment. Strong problem-solving skills and a passion for clean, efficient code are essential.', scelte: ['si', 'no', 'forse']},
      { id: 7, sezione: 'parametri lean', testo: 'Join our company as a Frontend Architect specializing in Vue.js. In this role, you will lead the architecture and development of Vue.js applications, establish best practices, and mentor junior developers. If you have a strong background in building scalable and maintainable frontend solutions, we want to hear from you!',  scelte: ['si', 'no', 'forse']}],
      domandeVisibili: [],
      sezioni: [],
      scelte: {}, //questa mappa contiene le risposte a tutte le domande
      sezioneSelezionata: '',
      finito: true
    }
  },
  mounted() {
    this.mostraQuestionario()
  },
  methods:{
    mostraQuestionario() {
      const formData = new FormData();
      formData.append('titolo', 'Questionario obbligatorio');
      axios.post('http://localhost/www/api/api-user-get-survey.php', formData)
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
    questionarioCompletato() {
      this.finito = false
      let numeroScelte = Object.keys(this.scelte).length
      if(numeroScelte == this.domande.length) {
        this.finito=true;
      }
    }
  }
}
</script>