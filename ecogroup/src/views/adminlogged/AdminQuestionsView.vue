<template>
  <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg min-h-[60%] w-5/6 mx-auto ">
    <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Domande</h1>
    <div class="flex gap-3 flex-col md:flex-row justify-between">
      <div class="CATEGORIE bg-black bg-opacity-20 p-2 rounded-xl shadow-md md:w-1/5 h-fit">
        <div @click="SelezionaAzione(azione)" class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer" v-for="azione in azioni"> 
          {{ azione }}
        </div>
      </div>
        <AddQuestions v-if="this.azioneCorrente == this.azioni[0]"></AddQuestions>
        <ModifyQuestions v-if="this.azioneCorrente == this.azioni[1]"></ModifyQuestions>
        <AddCategory v-if="this.azioneCorrente == this.azioni[2]"></AddCategory>
    </div>
  </div>
</template>
  
<script>
import AddQuestions from '../../components/Admin/AdminQuestionsAdd.vue';
import AddCategory from '../../components/Admin/AdminQuestionsCategory.vue';
import ModifyQuestions from '../../components/Admin/AdminQuestionsModify.vue';

export default {
  props: ['userid'],
  components: {
    AddQuestions, AddCategory, ModifyQuestions},
  data () {
    return {
      azioni: ['Aggiungi', 'Modifica', 'Categorie'],
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