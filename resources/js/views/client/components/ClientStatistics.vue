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
                    <v-col cols="6">Total</v-col>
                    <v-col cols="5">{{agency.clients_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="6">Sin Contacto</v-col>
                    <v-col cols="5">{{agency.clients_pending_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="6">Contactados</v-col>
                    <v-col cols="5">{{agency.clients_contacted_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="6">Captados</v-col>
                    <v-col cols="5">{{agency.clients_captured_count}}</v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="6">Nuevo Dia</v-col>
                    <v-col cols="5" >{{agency.clients_day_count}}</v-col>
                    <v-col cols="auto"><list-simple-icon icon="mdi-magnify-scan" label="Detalle Dia" color="amber darken-3" :size="16" @click="detailContacted('day', agency)"></list-simple-icon></v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="6">Nuevo Semana</v-col>
                    <v-col cols="5">{{agency.clients_week_count}}</v-col>
                    <v-col cols="auto"><list-simple-icon icon="mdi-magnify-scan" label="Detalle Semana" color="amber darken-3" :size="16" @click="detailContacted('week', agency)"></list-simple-icon></v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="6">Nuevo Mes</v-col>
                    <v-col cols="5">{{agency.clients_month_count}}</v-col>
                    <v-col cols="auto"><list-simple-icon icon="mdi-magnify-scan" label="Detalle Mes" color="amber darken-3" :size="16" @click="detailContacted('month', agency)"></list-simple-icon></v-col>
                </v-row>
            </v-card-text>
            
        </v-card>
        
        <v-dialog v-model="dialogDetail" scrollable width="95vw" content-class="">
            <DetailClientContacted v-if="dialogDetail" :agency="agency" :type="type" @closeDialog="closeDialog($event)" />
        </v-dialog>
      
    </v-card-text>
  </v-card>
  
</template>

<script>
import AppData from '@mixins/AppData';
import DetailClientContacted from './DetailClientContacted.vue';
export default {

    mixins:     [ AppData],

    components: {
        DetailClientContacted
    },

    created()
    {
        this.list()
    },

    data: () =>({
        agencies: [],
        dialogDetail: false,
        agency: null,
        type: 'day'
    }),

    methods:
    {
        list()
        {
            this.getResource(`agency/clients`).then( data => {
                this.agencies = data;
            })
        },

        detailContacted(type, agency)
        {
           this.type   = type
           this.agency = agency
           this.dialogDetail = true
        },

        closeDialog()
        {
            this.dialogDetail = false
            this.agency = null
        }
    }
}
</script>

<style>

</style>