<template>
  <v-container fluid class="">
    
   <v-app class="transparent">
     
    <v-main >

      <div class="d-block mb-1">
        <v-avatar size="50" color="white" class="mr-2 pointer" @click="navigateToName('welcome')">
          <img src="/images/logo.jpg" alt="Bingolin">
        </v-avatar>
      </div>

      <v-tabs color="deep-orange" v-model="tab" class="rounded-t-lg">
        <v-tab>Subscriptores</v-tab>
        <v-tab>Banner</v-tab>
        <v-tab>Promociones</v-tab>
        <v-tab>Resultados</v-tab>
        <v-tab>Sedes</v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat>
            <v-card-text class="pa-0">
                <v-card-text><AppSuscripcion></AppSuscripcion></v-card-text>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
                <v-card-text><AdminBanner></AdminBanner></v-card-text>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
                <v-card-text><AdminPromotion></AdminPromotion></v-card-text>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
                <v-card-text><AdminWinners></AdminWinners></v-card-text>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
                <v-card-text><AdminLocations></AdminLocations></v-card-text>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-main>
  </v-app>


   <v-dialog
      v-model="isLogin"
      v-if="isLogin"
      fullscreen
      persistent
    >
      <v-card class="main-color">
      <v-card-text>
      <v-row justify="center" align="center">
        <v-col cols="12" md="6">
        <v-card height="27rem" class="rounded-lg mt-6">
          <v-card-title class="deep-orange--text">
            Ingresar
          </v-card-title>
          <v-card-text class="px-6">
            <v-form v-model="valid" ref="loginForm" >
            <v-col cols="12" class="mt-4">
                <v-text-field
                    color="deep-orange"
                    prepend-inner-icon="mdi-account"
                    label="Usuario"
                    hint="Indique el usuario"
                    type="text"
                    v-model="form.nb_usuario"
                    :rules="[rules.required]"
                    filled
                    rounded
                  >
                </v-text-field>
            </v-col>
            <v-col cols="12">
                <v-text-field
                    color="deep-orange"
                    prepend-inner-icon="mdi-lock"
                    :append-icon="show ? 'visibility_off' : 'visibility'"
                    @click:append="show = !show"
                    label="Password"
                    hint="Debe contener letras y numeros y una longitud minima de 8 caracteres"
                    :type="show ? 'text' : 'password'"
                    v-model="form.password"
                    :rules="rules.password"
                    filled
                    rounded
                    >
                </v-text-field>
            </v-col>
            </v-form>
          </v-card-text>
          <v-card-actions class="px-7 pb-4">
            <v-row dense>
              <v-col cols="12">
                  <v-btn block dark color="deep-orange" :loading="loading" @click="login()">Ingresar</v-btn>
              </v-col>
              <v-col cols="12">
                <v-btn block text color="deep-orange" :disabled="loading" @click="navigateToName('welcome')">
                    volver a Inicio
                </v-btn>
              </v-col>
            </v-row>
          </v-card-actions>
      </v-card>
      </v-col>
      </v-row>
      </v-card-text>
      </v-card>
    </v-dialog>


</v-container>
</template>

<script>
import AdminBanner    from './components/AdminBanner'
import AdminPromotion from './components/AdminPromotion'
import AdminWinners   from './components/AdminWinners'
import AdminLocations from './components/AdminLocations'
import AppSuscripcion from '@views/suscripcion/AppSuscripcion'
import AppData        from '@mixins/AppData';

export default {

  components:{
    AdminBanner,
    AdminPromotion,
    AdminWinners,
    AdminLocations,
    AppSuscripcion
  },

  mixins: [AppData],

  created()
  {
    
  },

  data: () => ({
      tab: 0,
      form:{
        nb_usuario: '',
        password  : '',
      },
      show:     false,
      loading:  false,
      valid:    '',
      isLogin:  true
  }),

  methods:{

    login(){
      if (!this.$refs.loginForm.validate())  return 
      if( this.form.nb_usuario = 'admin' && this.form.password == '@pommekt2156')
      {
        this.isLogin = false
      }else{
        alert('Usuario o password invalido')
      }
      this.$refs.loginForm.reset()
    },
  }
}
</script>

<style>

</style>