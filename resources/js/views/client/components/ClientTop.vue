<template>
<v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>
        <v-row class="title">
            <v-col cols="auto" >
              <v-icon left>mdi-chart-bar</v-icon>  Estadisticas
            </v-col>
            <v-col cols="auto" ><v-icon  small @click="list()">mdi-reload</v-icon> </v-col>
            <v-col > </v-col>
            <v-col cols="auto">

            </v-col>
        </v-row>
        

    </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      
        <v-card v-for="agency in agencies" :key="agency.id" color="rgba(0,0,0,0.2)">

            <v-card-title class="pa-2">
                {{agency.name}}
            </v-card-title>
            <v-card-text>
                <v-subheader>Clientes</v-subheader>

                <v-row no-gutters>
                    <v-col>Total</v-col>
                    <v-col>{{agency.clients_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col>Sin Contacto</v-col>
                    <v-col>{{agency.clients_pending_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col>Contactados</v-col>
                    <v-col>{{agency.clients_contacted_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col>Captados</v-col>
                    <v-col>{{agency.clients_captured_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col>Nuevo Dia</v-col>
                    <v-col>{{agency.clients_day_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col>Nuevo Semana</v-col>
                    <v-col>{{agency.clients_week_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col>Nuevo Mes</v-col>
                    <v-col>{{agency.clients_month_count}}</v-col>
                </v-row>
            </v-card-text>
            
        </v-card>
      
    </v-card-text>
  </v-card>
  
</template>

<script>
import AppData from '@mixins/AppData';
export default {

    mixins:     [ AppData],

    created()
    {
        this.list()
    },

    data: () =>({
        agencies: []
    }),

    methods:
    {
        list()
        {
            this.getResource(`agency/clients`).then( data => {
                this.agencies = data;
            })
        },
    }
}
</script>

<style>

</style>