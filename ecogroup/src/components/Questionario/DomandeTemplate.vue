<template>
    <div class="flex items-center gap-2 max-w-5xl bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
      <h2 class="bg-black bg-opacity-20 px-2 rounded-full text-center">
        {{ id }}
      </h2>
      <p class="w-[90%]">
        {{ testo }}
      </p>
      <div class="p-1 flex flex-col gap-2 items-left">
        <label for="risposta" class="text-xs">Risposta:</label>
        <select v-model="risposta" @change="inviaRisposta" :key="getselected" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700 w-32" id="risposta">
          <option v-for="scelta in scelte" :value="scelta" :selected=eSelezionata(scelta)>{{ scelta }}</option>
        </select>
      </div>
    </div>
</template>

<script>
export default {
  props: ['id', 'categoria', 'testo', 'scelte', 'rispostaSel'],
  data() {
    return {
      risposta: this.rispostaSel
    }
  },
  methods : {
    prova(){
      console.log(this.id)
    },
    inviaRisposta() {
        this.$emit('eventorisposta', this.risposta)
    },
    eSelezionata(scelta) {
      return this.risposta == scelta
    },
    getselected(){
      return this.risposta
    }
  }
}
</script>