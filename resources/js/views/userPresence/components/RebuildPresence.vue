<template>
<v-card class="main-color" dark>
    <v-card-title class="py-2 px-2">
        <v-row dense class="subtitle-1">
            <v-col>Recalcular Progreso</v-col>
            <v-col cols="auto"><v-btn :loading="loading" icon x-small dark @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn></v-col>
        </v-row>
    </v-card-title>
    <v-card-text class="custom-scroll"> 
        <v-date-picker 
            no-title
            scrollable
            full-width
            v-model="day"
            color="indigo"
            class="rounded-lg"
            elevation="3"
            :first-day-of-week="1"
            :max="maxDay"
            light
        ></v-date-picker>
        <v-btn :loading="loading" small block color="orange" dark class="mt-2" @click="confirmRebuild()">Recalcular</v-btn>
    </v-card-text>
</v-card>
  
</template>

<script>
import AppData from '@mixins/AppData'

export default {

    mixins: [AppData],

    data()
    {
        return {
            day:    null,
            maxDay: new Date().toISOString().substr(0, 10),
        }
    },

    methods:{
        confirmRebuild()
        {
            if(!this.day){
                this.showError('Indicar Fecha de inicio de calculo')
                return
            }

            if(confirm('Esta accion hara el recalculo a partir del dia indicado, \nDesea continuar?'))
            {
                this.updateResource(`userPresence/rebuild`, { date: this.day }).then(data =>{
                    this.showMessage(data.msj)
                })
            }
            
        }
    }
}
</script>

<style>

</style>