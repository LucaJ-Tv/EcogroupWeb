<template>
  <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-1/3 mx-auto ">
    <h1 class="text-2xl font-Inter font-bold text-center mb-2">Aggiungi Admin</h1>
    <form @submit.prevent="submitForm" class="flex flex-col justify-between gap-2">
      <label for="username">Username:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="username" name="username" v-model="username">
      <label for="email">Email:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="email" name="email" v-model="email">
      <label for="password">Password:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="password" name="password" v-model="password">
      <label for="ripetipassword">Ripeti Password:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="password" name="ripetipassword" v-model="passwordRepeat">
      <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1" type="submit" value="invia">
      {{ formOk }}
      {{ password }}
      {{ passwordRepeat }}
      <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
        <p v-if="erroreForm">{{ erroreForm }}</p>
      </div>
      <div v-if="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">
        <p v-if="risultato">{{ risultato }}</p>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['userid'],
    data () {
        return {
          username: '',
          email: '',
          password: '',
          passwordRepeat: '',
          erroreForm: '',
          formOk: false,
          risultato: ''
        }
    },
    methods: {
      validator() {
        this.formOk = true
        if(this.password.length < 8) {
          this.formOk = false
          this.erroreForm = 'Password troppo corta!'
        }
        if(!this.containsNumbers(this.password)){
          this.formOk = false
          this.erroreForm = 'La password deve contenere almeno un numero!'
        }
        if(!(this.password === this.passwordRepeat)){
          this.formOk = false
          this.erroreForm = 'Le password non corrispondono!'
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
      submitForm () {
        this.risultato = '';
        const formData = new FormData();
        formData.append('username', this.username);
        formData.append('email', this.email);
        formData.append('password', this.password);
        formData.append('passwordRepeat', this.passwordRepeat)

        this.validator();
        if (this.formOk) {
          axios.post('http://localhost/www/api/api-admin-signup.php', 
          formData).then(response => {
            if (response.data.error == ''){
              console.log(response.data);
              this.risultato = 'admin aggiunto';
              this.erroreForm = '';
              //resetto per aggiungere altri admin
                    // this.username = '';
                    // this.email = '';
                    // this.password = '';
                    // this.passwordRepeat = '';
                    // this.erroreForm = '';
                    // this.formOk = false;
                    // this.risultato = '';
            } else {
              this.erroreForm = response.data.error;
            };
          }).catch(error => {
            console.error(error);
          });
        }
      }
    }
}
</script>