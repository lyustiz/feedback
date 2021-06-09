<template>

  <v-card class="main-color" flat dark>
    <v-card-title>
      <v-row dense>
        <v-col>Conexiones del Dia</v-col>
        <v-col cols="auto"><v-btn icon x-small dark @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn></v-col>
      </v-row>
    </v-card-title>
    <v-card-text>

       <v-expansion-panels class="card-background"> 
         <v-row class="text-center" >
          <v-col>
              Inicio
          </v-col>
          <v-col>
              Fin
          </v-col>
          <v-col>
              Bonus
          </v-col>
          <v-col>
              WriteOff
          </v-col>
          <v-col>
            Status
          </v-col>
        </v-row>

        <v-expansion-panel v-for="presence in presences" :key="presence.id"> 

          <v-expansion-panel-header>  
            

            <v-row>
              <v-col>
                  {{UTCToLocalDate(presence.start_at)}} 
              </v-col>
              <v-col>
                  {{ (presence.status_id == 4) ? UTCToLocalDate(presence.end_at) : 'activo'}}
              </v-col>
              <v-col>
                  {{  formatNumber(presence.bonus) }}
              </v-col>
              <v-col>
                  {{  parseInt(presence.writeoff) }}
              </v-col>
              <v-col>
                <v-icon v-if="presence.status_id == 4" color="green">mdi-checkbox-marked-outline</v-icon>
                <v-icon v-else color="amber" class="mdi-spin pointer">mdi-cog-clockwise</v-icon>
              </v-col>
            </v-row>
          </v-expansion-panel-header>  

          <v-expansion-panel-content>
          
              <ComissionPresence :presence="presence"></ComissionPresence>

          </v-expansion-panel-content>
        
        </v-expansion-panel> 

      </v-expansion-panels> 

    </v-card-text>
  </v-card>

 

</template>

<script>
import AppData from '@mixins/AppData';
import ComissionPresence from './ComissionPresence.vue'
export default {

  mixins: [AppData],

  components:{
    ComissionPresence
  },

  created() {
    this.list()
  },

  props:{
    profile:{
      type: [Array, Object],
      default: () => {}
    }
  },

  data: () => ({
    presences: []
  }),

  methods:
  {
    list() {
      this.getResource(`userPresence/user/${this.userId}/profile/${this.profile.id}`).then( data => {
        this.presences = data
      })
    },
  }

}
</script>

<style>

</style>