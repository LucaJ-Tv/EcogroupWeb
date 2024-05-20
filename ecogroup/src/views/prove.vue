<template>
  <button @click="restoreSession" class="border-green-700 bg-blue-700 shadow-md border rounded-xl p-2 mt-2 hover:bg-green-800 cursor-pointer w-full">restore</button>
  <div>
    <p>SESSION: {{ session }}</p>
  </div>
  <p>ciao bello!!</p>
</template>

<script>
  import axios from 'axios';
  export default {
    data() {
      return{
        session: ''
      }
    },
    methods: {
      restoreSession() {
        axios.get('./www/session.php').then(response => {
          this.session = response.data
        }).catch(error => {
          console.error(error);
        });
      },
    }
  }
</script>