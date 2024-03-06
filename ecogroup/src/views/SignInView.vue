<template>
  <div class="flex flex-col mx-auto md:flex-row justify-center gap-4 my-2 w-3/4">
    <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg" v-if="!visibleForm || w > minWidth">
      <p class="w-auto md:w-96">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, minus aliquid magni est debitis velit necessitatibus commodi deleniti mollitia illum ipsum, vero dolorem libero. Commodi natus culpa ex aliquam dolorem?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, minus aliquid magni est debitis velit necessitatibus commodi deleniti mollitia illum ipsum, vero dolorem libero. Commodi natus culpa ex aliquam dolorem?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, minus aliquid magni est debitis velit necessitatibus commodi deleniti mollitia illum ipsum, vero dolorem libero. Commodi natus culpa ex aliquam dolorem?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, minus aliquid magni est debitis velit necessitatibus commodi deleniti mollitia illum ipsum, vero dolorem libero. Commodi natus culpa ex aliquam dolorem?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, minus aliquid magni est debitis velit necessitatibus commodi deleniti mollitia illum ipsum, vero dolorem libero. Commodi natus culpa ex aliquam dolorem?
      </p>
      <button v-if="w < minWidth" @click="next" class="border-green-700 bg-green-700 shadow-md border rounded-xl p-2 mt-2 hover:bg-green-800 cursor-pointer w-full">Ho letto</button>
    </div>
    <button v-if="w < minWidth && visibleForm" @click="back" class="border-green-700 bg-green-700 shadow-md border rounded-xl p-2 mt-2 hover:bg-green-800 cursor-pointer">Torna indietro</button>
    <SignInForm class="w-auto md:w-96" v-if="w > minWidth || visibleForm"></SignInForm>
  </div>
</template>

<script>
import SignInForm from '../components/SignInForm.vue'
    export default {
        mounted() {
        window.addEventListener('resize', () => {
        this.w = window.innerWidth
  })
    },
        data() {
            return {
                w: window.innerWidth,
                minWidth: 768,
                visibleForm: false
            }
        },
        components: {
            SignInForm
        },
        methods: {
            next() {
                this.visibleForm = true
            },
            back(){
                this.visibleForm = false
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>