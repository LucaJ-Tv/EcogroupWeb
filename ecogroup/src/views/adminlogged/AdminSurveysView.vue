<template>
    <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg min-h-[60%] w-5/6 mx-auto ">
      <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Questionari</h1>
      <div class="flex gap-3 flex-col md:flex-row justify-between">
        <div class="QUESTIONARI bg-black bg-opacity-20 p-2 rounded-xl shadow-md md:w-1/5 h-fit">
          <div @click="SelezionaAzione(azione)" class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer" v-for="azione in azioni"> 
            {{ azione }}
          </div>
        </div>
          <AddSurvey :id="userid" v-if="this.azioneCorrente == this.azioni[0]"></AddSurvey>
          <ModifySurveys v-if="this.azioneCorrente == this.azioni[1]"></ModifySurveys>
          <Surveys v-if="this.azioneCorrente == this.azioni[2]"></Surveys>
      </div>
    </div>
  </template>
    
  <script>
  import Surveys from '../../components/Admin/AdminSurveys.vue';
  import AddSurvey from '../../components/Admin/AdminSurveyAdd.vue';
  import ModifySurveys from '../../components/Admin/AdminSurveyModify.vue';
  
  export default {
    props: ['userid'],
    components: { Surveys, AddSurvey, ModifySurveys},
    data () {
      return {
        azioni: ['Aggiungi', 'Modifica', 'Questionari'],
        azioneCorrente: 'Aggiungi'
      }
    },
    methods: {
      SelezionaAzione(azione) {
        this.azioneCorrente = azione;
      }
    }
  }
  </script>