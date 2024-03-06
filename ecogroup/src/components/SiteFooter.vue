<template>
    <footer class="rounded-t-lg bg-opacity-70 shadow-md bg-site-primary border-t border-green-600 mx-1">
      <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
          <div class="sm:flex sm:items-center sm:justify-between">
              <RouterLink to="/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                  <img src="../assets/ecogroup-icon.png" class="h-8" alt="Eco Group Logo" />
                  <span class="self-center text-2xl font-semibold whitespace-nowrap">Eco Group</span>
              </RouterLink>
              <ul class="flex flex-wrap items-center mb-6 text-sm font-medium sm:mb-0">
                  <li>
                      <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                  </li>
                  <li>
                      <a href="#" class="hover:underline">Contact</a>
                  </li>
              </ul>
          </div>
      </div>
    </footer>
</template>

<script>
export default {
    setup () {
        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>