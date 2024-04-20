<template>
    <div class="mx-2 my-3 xl:mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg">
      <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Questionario sull'ecosostenibilità</h1>
      <div class="flex gap-3 flex-col md:flex-row justify-between">
        <div class="CATEGORIE bg-black bg-opacity-20 p-2 rounded-xl shadow-md md:w-2/5">
          <div @click="SelezionaCategoria(categoria)" class="border border-site-secondary rounded-lg px-2 py-1 mb-1 hover:bg-site-primary cursor-pointer" v-for="categoria in categorie"> 
            {{ categoria }}
          </div>
          <button @click="questionarioCompletato()" class="border-site-secondary border w-full rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary">Invia</button>

          <div v-if="!finito" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-2 rounded-xl mt-2">
            <p>Completa prima il questionario</p>
          </div>
        </div>
        <div class="DOMANDE">
          <div v-for="domanda in domandeVisibili" :key="domanda.id" :v-if="domanda.categoria == categoriaSelezionata">
            <Domanda :id="domanda.id" :categoria="domanda.categoria" :testo="domanda.testo" :scelte="domanda.scelte" :rispostaSel="getRisposta(domanda.id)" @eventorisposta="aggiuniRisposta($event, domanda.id)" />
          </div>
        </div>
        {{ domande }}
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
      //struttura della domanda è [numeroDomanda, sezione, testo, e scelte]
      domande: [],
      domandeDb:[{id: 1, categoria: 'parametri green', testo: 'Seeking a skilled Frontend Developer with expertise in Vue.js to join our dynamic team. You will be responsible for designing and implementing user interfaces, collaborating with the UX/UI team, and ensuring seamless integration with backend services.', scelte: ['si', 'no', 'forse'] },
      { id: 2, categoria: 'parametri green', testo: 'We are hiring a Vue.js Software Engineer to work on our innovative projects. As a key member of the development team, you will be involved in the full software development lifecycle, from design to deployment. Strong problem-solving skills and a passion for clean, efficient code are essential.', scelte: ['si', 'no', 'forse']},
      { id: 3, categoria: 'parametri green', testo: 'Seeking a skilled Frontend Developer with expertise in Vue.js to join our dynamic team. You will be responsible for designing and implementing user interfaces, collaborating with the UX/UI team, and ensuring seamless integration with backend services.', scelte: ['si', 'no', 'forse'] },
      { id: 4, categoria: 'parametri green', testo: 'We are hiring a Vue.js Software Engineer to work on our innovative projects. As a key member of the development team, you will be involved in the full software development lifecycle, from design to deployment. Strong problem-solving skills and a passion for clean, efficient code are essential.', scelte: ['si', 'no', 'forse']},
      { id: 5, categoria: 'parametri green', testo: 'Seeking a skilled Frontend Developer with expertise in Vue.js to join our dynamic team. You will be responsible for designing and implementing user interfaces, collaborating with the UX/UI team, and ensuring seamless integration with backend services.', scelte: ['si', 'no', 'forse'] },
      { id: 6, categoria: 'parametri green', testo: 'We are hiring a Vue.js Software Engineer to work on our innovative projects. As a key member of the development team, you will be involved in the full software development lifecycle, from design to deployment. Strong problem-solving skills and a passion for clean, efficient code are essential.', scelte: ['si', 'no', 'forse']},
      { id: 7, categoria: 'parametri lean', testo: 'Join our company as a Frontend Architect specializing in Vue.js. In this role, you will lead the architecture and development of Vue.js applications, establish best practices, and mentor junior developers. If you have a strong background in building scalable and maintainable frontend solutions, we want to hear from you!',  scelte: ['si', 'no', 'forse']}],
      domandeVisibili: [],
      categorie: [],
      scelte: {}, //questa mappa contiene le risposte a tutte le domande
      categoriaSelezionata: '',
      finito: true
    }
  },
  mounted() {
    this.mostraQuestionario();
    this.mostraCategorie();
    this.mostraDomande();
  },
  methods:{
    mostraQuestionario() {
      console.log(1);
      const formData = new FormData();
      formData.append('titolo', 'Questionario obbligarorio');
      axios.post('http://localhost/www/api/api-user-get-survey.php', formData)
      .then(response => {
        this.domande = response.data;
      }).catch(error => {
        console.error(error);
      });
    },
    mostraDomande() {
      this.domandeVisibili = this.domandeDb.filter(domanda => {
        return domanda.categoria == this.categoriaSelezionata
      });
    },
    mostraCategorie() {
      this.categorie = []
      this.domandeDb.forEach(domanda => {
        if(!this.categorie.includes(domanda.categoria)){
          this.categorie.push(domanda.categoria)
          this.categoriaSelezionata = this.categorie.at(0)
        }
      });
    },
    SelezionaCategoria(categoria) {
      this.categoriaSelezionata = categoria
      this.mostraDomande()
      console.log(this.domandeVisibili)
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
       if(numeroScelte == this.domandeDb.length) {
          this.finito=true
       }
    }
  }
}
</script>