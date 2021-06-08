<template>

  <v-expansion-panel-content>
       <v-subheader>Detalle</v-subheader>
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
              {{ comission.comission_at }}
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
    comissions: []
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
            })
        }
    },
  }


}
</script>

<style>

</style>