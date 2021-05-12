<template>
<div class="main-color">

    <v-app-bar
      app
      color="rgba(0, 0, 0, 0.2)"
      dark
      flat
      hide-on-scroll
      height="45"
    >
      <v-avatar size="35" color="white" class="mr-2 pointer" @click="navigateToName('welcome')">
        <img src="/images/logo.jpg" alt="Bingolin">
      </v-avatar>

      <v-toolbar-title class="font-weight-bold">
        <div class="logo-titulo mx-3">{{$App.title}}</div> 
      </v-toolbar-title>

      <v-spacer></v-spacer>


      <v-spacer></v-spacer>


      <v-btn depressed small rounded color="success" @click="navigateToName('login')">
        <v-icon left>mdi-account</v-icon>
        Login
      </v-btn> 

    
    </v-app-bar>


    
    <!-- Contenido -->
    <v-main class="fill-height ">
        <transition name="fade" mode="out-in" >
            <router-view></router-view>
        </transition>
    </v-main>

    <!--Mensaje Sistema-->
    <app-message></app-message>

</div>
</template>

<script>

export default {

}
</script>

<style>

#register-container{
    height: 92.8vh;
}
.holder {
    min-height: 100vh;
    background-image: url('/images/fondo-login.jpg');
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
.form-login{
    border-radius: 20px !important;
}

</style>