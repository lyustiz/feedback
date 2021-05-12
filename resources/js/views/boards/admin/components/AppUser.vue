<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-text>
      <v-row>
        <v-col>
          <v-list-item> 
              <v-list-item-avatar size="80">
                  <v-icon color="grey" size="100">mdi-account-circle</v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                  <v-list-item-subtitle class="title-section"> Administrador</v-list-item-subtitle>
                  <v-list-item-title> Agencia Ppal</v-list-item-title>
              </v-list-item-content>
              <v-list-item-icon @click="getdata()">
                  <v-icon>mdi-dots-vertical</v-icon>
              </v-list-item-icon>
          </v-list-item>
        </v-col>
      </v-row>
    <v-row>
        <v-col class="text-center">
          <v-subheader>citas</v-subheader>
          <v-progress-circular
              :rotate="-90"
              :size="80"
              :width="8"
              :value="35"
              color="blue">
              35
          </v-progress-circular>
        </v-col>  
        <v-col class="text-center">
          <v-subheader>citas</v-subheader>
          <v-progress-circular
              :rotate="-90"
              :size="80"
              :width="8"
              :value="12"
              color="green">
              12
          </v-progress-circular>
        </v-col>  
        <v-col class="text-center">
          <v-subheader>citas</v-subheader>
          <v-progress-circular
              :rotate="-90"
              :size="80"
              :width="8"
              :value="10"
              color="red">
              10
          </v-progress-circular>
        </v-col>  
      </v-row>
    </v-card-text>
  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
export default {

  mixins: [AppData],

  methods:{
    getdata()
    {
      this.getResource('data').then( data => {
        console.log(data)
      })

    }
  }
}
</script>

<style>

</style>