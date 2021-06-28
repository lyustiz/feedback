<template>
<v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-card-title class="px-3 py-1">
        <v-row no-gutters class="title">
            <v-col cols="auto" >
              <v-icon left size="20">mdi-podium-silver</v-icon>  Top Clientes
            </v-col>
            <v-spacer></v-spacer>
            <v-col cols="auto" ><v-icon  small @click="list()">mdi-reload</v-icon> </v-col>
            <v-col cols="auto" ><v-icon color="red" small @click="detailClient()">mdi-reload</v-icon> </v-col>
            <v-col cols="auto" ><v-icon color="blue" small @click="clientPhoto()">mdi-reload</v-icon> </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col>
                <v-select
                    v-model="agency"
                    label="Agencias"
                    item-text="name"
                    item-value="id"
                    :items="agencies"
                    :loading="loading"
                    hide-details
                    outlined
                    filled
                    dense
                    class="mt-2"
             ></v-select>
            </v-col>
        </v-row>
        
    </v-card-title>

    <v-card-text class="pa-0 accounts-container custom-scroll">
    
        <v-window v-model="agency" class="elevation-0" reverse>
        <v-window-item v-for="agency in agencyClientsTop" :key="agency.id" class="elevation-0" :value="agency.id">
        <v-row no-gutters>
            <v-col cols="12" v-for="client in agency.clients_captured" :key="client.id" class="d-flex align-center "> 
                <ClientCard :client="client"></ClientCard>
            </v-col> 
        </v-row>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
  
</template>

<script>
import AppData from '@mixins/AppData';
import ClientCard from './ClientCard'
export default {

    mixins:     [ AppData],

    components:{
        ClientCard
    },

    created()
    {
        this.list()
    },

    computed: {
        agencies()
        {
            return this.$store.getters['getAgency']
        },
    },

    data: () =>({
        agencyClientsTop: [],
        agency: null
    }),

    methods:
    {
      list()
      {
        this.getResource(`agency/clients/top`).then( data => {
            this.agencyClientsTop = data;
        })
      },

      detailClient()
      {
        this.getResource(`client/all/detail`).then( data => {
            this.showMessage(data.msj);
        })
      },

      clientPhoto()
      {
        this.getResource(`client/all/photo`).then( data => {
            this.showMessage(data.msj);
        })
      }
    }
}
</script>

<style>

</style>