<template>
  <Operazioni></Operazioni>
</template>

<script>
import Operazioni from '../../components/Admin/AdminOperations.vue';

export default {
  props: ['userid'],
  components: {Operazioni},
  data () {
    return {

    }
  }
}
</script>