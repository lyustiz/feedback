<template>


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

     <!--  <v-btn small text @click="promocion=true">
        Promocion
      </v-btn>

      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn small v-bind="attrs" v-on="on" text>
            Sorteos <v-icon>mdi-chevron-down</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item
            v-for="(item, index) in items"
            :key="index"
          >
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-btn small text>
        Como Jugar <v-icon>mdi-chevron-down</v-icon>
      </v-btn>
        
      <v-btn small text>
        Ayuda
      </v-btn> -->

      <v-spacer></v-spacer>

      <!-- <v-btn depressed small rounded black class=" mr-3">
        <v-icon left>mdi-account-plus</v-icon>
        Registro
      </v-btn>-->

      <v-btn depressed small rounded color="success" @click="navigateToName('admin')">
        <v-icon left>mdi-account</v-icon>
        Login
      </v-btn> 

    
    </v-app-bar>

    

        <!-- Logged
        <template v-if="auth">
        
            --Ayuda 
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <app-help v-on="on"></app-help>
                </template>
                <span>Ayuda</span>
            </v-tooltip>

            --Mensajes 
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <app-mensajes v-on="on"></app-mensajes>
                </template>
                <span>Mensaje</span>
            </v-tooltip>

            --Notificaciones 
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <app-notifications v-on="on"></app-notifications>
                </template>
                <span>Notificaciones</span>
            </v-tooltip>
            
            --User -
            <app-user></app-user>
 

        </template>
        -->


</template>
<script>

    import { mapMutations } from 'vuex';
    export default {

        computed: {
            auth()
            {
                return 1 //return this.$store.getters['getAuth']
            },
        },

        data(){
            return {
                loading : false,
                promocion: false,
                 items: [
        { title: 'Semanal' },
        { title: 'Diario' },
        { title: 'Especial Navideño' },
      ],
            }
        },

    }
</script>
<style scoped>

.logo-titulo{
   font-size: 1.3rem;
}

</style>
