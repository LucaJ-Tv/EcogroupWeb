<template>
  <div class="flex gap-2 justify-between bg-black bg-opacity-20 shadow-md rounded-lg px-2 py-3 mb-3">
    <p>{{ id }}</p>
    <h2>{{ titolo }}</h2>
    <p>{{ punteggio }}</p>
  </div>

</template>

<script>
export default {
  props: ['id', 'titolo', 'punteggio'],//eventualmente punteggio?? in base a come viene calcolato
  setup () {
    return {}
  }
}
</script>