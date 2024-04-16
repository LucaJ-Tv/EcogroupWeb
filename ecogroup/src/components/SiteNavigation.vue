<template>
  <header class="sticky top-0 z-20 shadow-md bg-site-primary bg-opacity-80 backdrop-blur-lg border-b-green-700 border-b rounded-b-lg mx-1 h-fit">
    <nav class="container flex items-center w-full py-2 justify-between">
      <div class="flex items-center gap-2 font-Inter">
        <img src="../assets/ecogroup-icon.png" class="h-12 w-12" alt="ecogroup logo">
        <router-link class="self-center text-2xl font-semibold whitespace-nowrap" to="/">Eco Group</router-link>
      </div>
      <router-link class=" border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md" to="/login"><i class="fa-solid fa-user"></i> Log in</router-link>
    </nav>
  </header>
</template>

<script>
  export default{
  }
</script>