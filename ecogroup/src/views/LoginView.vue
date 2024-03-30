<template>
  <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-1/3 mx-auto ">
    <form @submit.prevent="submitForm" class="flex flex-col justify-between gap-2">
      <label for="email">Email:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="email" name="email" v-model="email">
      <label for="password">Password:</label>
      <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="password" name="password" v-model="password">
      <button @click="mandamail">Hai dimenticato la password?</button>

      <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary" type="submit" value="invia">
      <div v-if="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">
        <p v-if="erroreForm">{{ erroreForm }}</p>
      </div>
    </form>
    <!-- <button class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary mt-2" @click="checkUserLoggedIn">controlloSessione</button> -->
  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    data() {
      return{
        email: '',
        password: '',
        id: '',
        erroreForm: '',
        formOk: true,
      }
    },
    methods: {
      mandamail() {
        //da capire come fare
      },
      submitForm(){
        const formData = new FormData();
        formData.append('email', this.email);
        formData.append('password', this.password);

        if (this.formOk) {
          axios.post('http://localhost/www/api/api-user-login.php', 
          formData).then(response => {
            if (response.data.error == ''){
              this.$emit('loggedInUser')
              console.log(response.data)
              this.$router.push({name: 'LoggedIn', params: {userid: response.data.userid}});
            } else {
              this.erroreForm = response.data.error;
            };
          }).catch(error => {
            console.error(error);
          });
        }
      },
      // checkUserLoggedIn() {
      //   axios.get('http://localhost/www/session.php'
      //   ).then(response => {
      //     console.log(response.data);
      //   }).catch(error => {
      //     console.error(error);
      //   });
      // }
    }
  }

</script>
