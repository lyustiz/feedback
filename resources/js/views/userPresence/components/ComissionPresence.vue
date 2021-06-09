<template>

  <v-expansion-panel-content>
       <v-subheader>
         <v-row no-gutters>
           <v-col>Detalle</v-col>
           <v-col>
             <v-icon size="16" color="green" left>mdi-cash-plus</v-icon>
              {{formatNumber(bonus || 0.00)}}
           </v-col>
           <v-col>
             <v-icon size="16" color="red" class="ml-2"  left>mdi-cash-remove</v-icon>
              {{ writeoff || 0}}
           </v-col>
         </v-row>
         </v-subheader>
      
      <v-row v-for="comission in comissions" :key="comission.comission_id">

          <v-col cols="auto">
            <v-avatar color="blue" class="elevation-3" :size="30">
              <v-img :src="`/storage/photo/client/${(comission.client) ? comission.client.photo || 'nophoto' : 'nophoto'}.jpg`" ></v-img>
            </v-avatar>
          </v-col>
          <v-col>
              {{(comission.client) ? comission.client.name : '-'}}
          </v-col>
          <v-col>
              {{  (comission.comission_at) ? UTCToLocalDate(comission.comission_at) : "0000"  }} 
          </v-col>
          <v-col :class="(comission.positive = 1) ? 'green--text' : 'red--text' " >
              {{ formatNumber(comission.points) }}
          </v-col>
          <v-col>
            <list-simple-icon  
              :size="24"
              :icon="comission.has_service.icon" 
              :label="comission.has_service.name"
              :color="comission.has_service.color"
              v-if="comission.has_service"
            ></list-simple-icon>
            <list-simple-icon  
              :size="24"
              icon="mdi-comment-question" 
              :label="comission.service"
              color="amber"
              v-else
            ></list-simple-icon>
          </v-col>
      </v-row>

      <v-overlay  :opacity="0.4" :value="loading">
        <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
      </v-overlay>
  </v-expansion-panel-content>
 
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins:[AppData],

  props: {
    presence: {
        type: Object,
        default: () => {}
    }
  },

  data: () => ({
    comissions: [],
    bonus: 0.0,
    writeoff: 0
  }),

  created() {
    this.list()
  },

  methods: {
    list() {
       console.log('presence', this.presence)
        if(this.presence)
        {
            this.getResource(`comission/presence/${this.presence.id}`).then(data =>{
                this.comissions = data
                this.setTotals()
            })
        }
    },

    setTotals()
    {
        for (const comission of this.comissions) {
          if(comission.positive == 1)
          {
            this.bonus = parseFloat(comission.points) + this.bonus
          } else{
            this.writeoff = this.writeoff + 1
          }
        }
    },

  }


}
</script>

<style>

</style>