<template>

  <v-card class="main-color">
    <v-card-title class="py-1">
        Clients
    </v-card-title>
          
    <v-card-text>
      <v-row>
        <v-col>
            <ClientStatistics></ClientStatistics>
        </v-col>
        <v-col>
            busqueda
        </v-col>
        <v-col>
            envio de cartas
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>

</template>

<script>
import AppData from '@mixins/AppData';
import ClientStatistics  from './components/ClientStatistics'
export default {

    mixins:     [ AppData],

    components: { 
      ClientStatistics
    },

    data: () => ({

    }),
    methods:
    {
   
    }
}
</script>

<style>
</style>