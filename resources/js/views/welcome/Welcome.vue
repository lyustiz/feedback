<template>
<v-app class="transparent">
  <v-main>
    <v-container fluid class="mt-n12">
      <v-row dense> 

        <v-col>
          <v-card color="rgba(0,0,0,0.4)" class="rounded-lg " height="90vh">
            <v-card-text>
            <v-row>
              <v-col>
                <AppUser></AppUser>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <AppDashBoard></AppDashBoard>
              </v-col>
            </v-row>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col>
            <AppOperatos></AppOperatos>
        </v-col>

        <v-col>
            <AppProfile></AppProfile>
        </v-col>

      </v-row>
    </v-container>
  </v-main>
</v-app>
</template>

<script>

import AppUser from './components/AppUser'
import AppDashBoard from './components/AppDashBoard'
import AppOperatos from './components/AppOperatos'
import AppProfile from './components/AppProfile'

export default {
  name: 'Welcome',

  components:{
    AppUser,
    AppDashBoard,
    AppOperatos,
    AppProfile,
  },
  
  data: () => ({
    clientes:[
       { id: 1, name: 'Luis Jose', month: 330, day: 30, fault: 2},
       { id: 2, name: 'Roberto Marques', month: 530, day: 21, fault: 4} ,
       { id: 3, name: 'Raul Garcia', month: 830, day: 100, fault: 1} ,
       { id: 4, name: 'Laura Miranda', month: 230, day: 15, fault: 0} 
    ]
  }),

  }
</script>

<style>
.city-name{
  color: white;
  text-shadow: 2px 2px #383838;
  background-color: rgba(43, 39, 39, 0.2);
}

.text-image{
   text-shadow: 2px 2px #383838;
}

.badground-image{
   background-color: rgba(43, 39, 39, 0.2);
}

.text-image-white{
   text-shadow: 1px 1px rgb(255, 255, 255);
}

.v-slide-group__next, .v-slide-group__prev{
  min-width: 1px !important;
}

.v-slide-group__content{
  justify-content: center !important;
}

.promocion-color{
  background-color: #FFFFFF !important;
}
.resultado-color{
  background-color: #9B069B !important;
}
.sorteo-color{
  background-color:#16B033 !important; 
}

.pointer{
  cursor: pointer;
}
</style>