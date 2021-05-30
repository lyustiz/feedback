<template>


     <v-app-bar
      app
      color="rgba(0, 0, 0, 0.3)"
      dark
      flat
      height="45"
      hide-on-scroll
    >
      <v-avatar size="35" color="white" class="mr-2 pointer" @click="navigateToName('home')">
        <img src="/images/logo.jpg" alt="criptoWeb">
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

      <v-btn icon small color="red" @click="logout">
        <v-icon left>mdi-export</v-icon>
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

    import AppData from '@mixins/AppData'
    export default {

        mixins:[AppData], 

        computed: {
            auth()
            {
                return this.$store.getters['getAuth']
            },
        },

        data(){
            return {
                loading : false,
            }
        },

        methods: {
          logout()
          {
            this.loading = true
            this.showMessage('saliendo de la aplicacion');

            this.$store.dispatch('logout', this.form)
              .catch(error =>
              {                
                  console.log(error);
              })
              .then(() => 
              {
                  this.navigateToName('welcome')
                  location.reload();
                  this.loading = false
              })

          },
        }

    }
</script>
<style scoped>

.logo-titulo{
   font-size: 1.3rem;
}

</style>
