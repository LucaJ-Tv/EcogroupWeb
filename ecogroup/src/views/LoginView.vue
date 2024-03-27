<template>
  <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-1/3 mx-auto ">
    <form @submit="submitValidator" class="flex flex-col justify-between gap-2">
      <label for="email">Email:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="email" name="email" v-model="email">
      <label for="password">Password:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="password" name="password" v-model="password">
      <button @click="mandamail">Hai dimenticato la password?</button>

      <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary" type="submit" value="invia" @click="prossimoStep">
    </form>
  </div>
</template>

<script>
  export default{
    data() {
      return{
        email: '',
        password: '',
        id: '',
        errorePassword: '',
        formOk: false,
      }
    },
    methods: {
      mandamail() {
        //da capire come fare
      },
      prossimoStep(){
        if(this.formOk) {
          this.ottieniID();
          this.$emit('LoggedInUser')
          this.$router.push({name: 'LoggedIn', params:{userid: this.id}})
        }
      },
      submitValidator(){
        this.errorePassword = ''
        this.formOk = true
        if (this.formOk) {
          this.prossimoStep()
        }
        //controllo da fare con php e di conseguenza dare una risposta
        //if()
        //  this.errorePassword = 'password sbagliata'
      },
      ottieniID(){
        id = 1;
      }
    }
  }
</script>
