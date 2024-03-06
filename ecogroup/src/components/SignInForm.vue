<template>
    <div class="bg-site-primary  bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg">
      <form @submit.prevent="submitValidator" class="flex flex-col justify-between gap-2">

        <label for="nome">Nome azienda:</label>
        <input class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="nome" name="nome" v-model="nome">

        <label for="email">Email:</label>
        <input class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="email" name="email" v-model="email">

        <label for="password">Password:</label>
        <input class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="password" name="password" v-model="password">
        <div v-if="errorePassword || errorePasswordNumeri" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
          <p v-if="errorePassword">{{ errorePassword }}</p>
          <p v-if="errorePasswordNumeri"> {{ errorePasswordNumeri }}</p>
        </div>

        <label for="dimensioneAzienda">Dimensione azienda:</label>
        <select v-model="dimensioneAzienda" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700">
          <option value="piccola">piccola</option>
          <option value="media">media</option>
          <option value="grande">grande</option>
        </select>

        <label for="cap">CAP:</label>
        <input class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="cap" name="cap" v-model="cap">

        <label for="citta">Città:</label>
        <input class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="citta" name="citta" v-model="citta">

        <label for="ATECO">Codice ATECO:</label>
        <input class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="ATECO" name="ATECO" v-model="ateco">

        <div class="codiciCER">
          <label for="codiciCER">Principali codici CER</label>
          <p class="text-xs pb-2">(premi spazio una volta inserito)</p>
          <input  type="text" name="codiciCER" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md w-full" v-model="tempCER" @keyup="addCER">
          <div class="gap-2 flex">
            <div class="displayCodici bg-black bg-opacity-30 rounded-xl px-2 mt-3 cursor-pointer text-green-500" v-for="codice in codiciCER" :key="codice">
              <span @click="removeCER(codice)" class="flex gap-1 items-center"><i class="fa-regular fa-circle-xmark"></i> {{codice}}</span>
            </div>
          </div>
        </div>

        <input class="border-green-700 bg-green-700 shadow-md border rounded-xl p-2 mt-2 hover:bg-green-800 cursor-pointer" type="submit" value="invia" @click="prossimoStep">

      </form>
    </div>
</template>

<script>
export default {
  data() { 
    return {
      useridDB: '13', //inviando la form al db per l'autenticazione restituisco l'id, in modo da associare l'id al questionario compilato 
      cap: '',
      nome: '',
      email: '',//con v-model il binding dei dati è doppio, questo significa che oltre ad essere 
      password: '', // modificato quando l'utente modifica i dati verrà modificato anche con funzioni
      ateco: '',
      dimensioneAzienda: '',
      tempCER: '',
      codiciCER: [],
      errorePassword: '',
      errorePasswordNumeri: '',
      formOk: false,
    }
  },
  methods: {
    addCER(e){
      if(e.key === ' ' && this.tempCER){
        if(!this.codiciCER.includes(this.tempCER)){
          this.codiciCER.push(this.tempCER)
        }
        this.tempCER=''
      }
    },
    removeCER(codice){
      this.codiciCER = this.codiciCER.filter((codiceCER) => {
        return codice != codiceCER
      })
      console.log(this.codiciCER)
    },
    existsCER(codice){
      return this.codiciCER.includes(codice)
    },
    submitValidator(){
      this.errorePassword = ''
      this.errorePasswordNumeri = ''
      this.formOk = true
      if(this.password.length < 8) {
        this.formOk = false
        this.errorePassword = 'Password troppo corta!'
      }
      if(!this.containsNumbers(this.password)){
        this.formOk = false
        this.errorePasswordNumeri = 'La password deve contenere almeno un numero!'
      }
    },
    containsNumbers(password){
      var regex = /\d/;
      if (regex.test(password)) {
        return true;
      } else {
        return false;
      }
    },
    prossimoStep (){
      if(this.formOk)
        this.$router.push({name: 'QuestionarioObbligatorio', params: {userid: this.useridDB}})
    }
  }
}
</script>
