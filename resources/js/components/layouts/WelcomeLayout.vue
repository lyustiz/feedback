<template>
<div class="main-color">
    <!-- App Toolbar -->
    <app-toolbar></app-toolbar>

    <!-- Contenido -->
    <v-main class="fill-height">
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

.main-color{
background: linear-gradient(107deg, rgb(37, 96, 159) 0%, rgb(20, 37, 54) 100%);
}
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