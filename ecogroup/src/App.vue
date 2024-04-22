<template>
  <div class="flex flex-col h-screen justify-between font-Roboto text-gray-200">
    <UserHeader v-if="userIsLogged || adminIsLogged" @logout="userLogOut"/>
    <SiteNavigation v-if="!userIsLogged && !adminIsLogged" @LoggedInUser="userLogged"/>

    <RouterView @LoggedInUser="userLogged" @LoggedInAdmin="adminLogged"/>
    
    <UserNavigation v-if="userIsLogged" :userid="userid"/>
    <AdminNavigation v-if="adminIsLogged" :userid="userid"/>

    <FooterHome v-if="!userIsLogged && !adminIsLogged"/>
  </div>
</template>

<script>
import { RouterView } from "vue-router";
//user non loggato
import SiteNavigation from "./components/SiteNavigation.vue";
import FooterHome from "./components/SiteFooter.vue";
//user loggato
import UserHeader from "./components/User/UserHeader.vue";
import UserNavigation from "./components/User/UserNavigation.vue";
//admin loggato
import AdminNavigation from "./components/Admin/AdminNavigation.vue";

export default {
  components:{
    RouterView,
    SiteNavigation,
    FooterHome,
    UserHeader,
    UserNavigation,
    AdminNavigation
  },
  data() {
    return {
      userIsLogged: false, //da fare in modo migliore con back end
      adminIsLogged: false,
      userid: ''
    }
  },
  methods:{
    userLogged(id) {
      this.userIsLogged = true;
      this.userid = id;
    },
    adminLogged(id) {
      this.userid = id;
      this.adminIsLogged = true;
    },
    userLogOut() {
      this.userIsLogged = false
      this.adminIsLogged = false
    }
  },
  mounted() {
  }
}
</script>