<template>

  <v-card class="main-color" >
    <v-card-title class="py-1">
        Clients
    </v-card-title>
          
    <v-card-text>
      <v-row dense>
        <v-col cols="12" md="6" lg="4"> 
            <ClientStatistics></ClientStatistics>
        </v-col>
        <v-col cols="12" md="6" lg="4">
            <ClientTop></ClientTop>
        </v-col>
        <v-col cols="12" md="6" lg="4">
            <ClientSearch></ClientSearch>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>

</template>

<script>
import AppData           from '@mixins/AppData';
import ClientStatistics  from './components/ClientStatistics'
import ClientTop         from './components/ClientTop'
import ClientSearch      from './components/ClientSearch'
export default {

    mixins:     [ AppData],

    components: { 
      ClientStatistics,
      ClientTop,
      ClientSearch
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