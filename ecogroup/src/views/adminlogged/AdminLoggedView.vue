<template>
    <Questionari></Questionari>
  </template>
  
  <script>
  import Questionari from '../../components/Admin/AdminSurveys.vue';
  
  export default {
    props: ['userid'],
    components: {Questionari},
    data () {
      return {
  
      }
    }
  }
  </script>