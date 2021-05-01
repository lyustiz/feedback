<template>
<div class="main-color">

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

</style>