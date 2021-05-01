<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row  dense>

         <v-col cols="12">
            <v-autocomplete
            :items="selects.suscriptor"
            item-text="nb_suscriptor"
            item-value="id"
            v-model="form.id_suscriptor"
            :rules="[rules.select]"
            label="Suscriptor"
            :loading="loading"
            dense
            >
            <template v-slot:append-outer>
                <v-menu content-class="rounded-xl" left offset-x :close-on-content-click="false" v-model="menuSuscriptor">
                    <template v-slot:activator="{ on, attrs }">
                     <v-btn icon color="success" v-on="on" v-bind="attrs"><v-icon>mdi-plus-circle</v-icon></v-btn>     
                    </template>
                    <AppSuscriptorForm @closeMenu="menuSuscriptor=false" @newSuscriptor="newSuscriptor($event)"></AppSuscriptorForm>
                </v-menu>
            </template>
            
            </v-autocomplete>
        </v-col>
                          
        <v-col cols="12">
            <v-select
            :items="selects.vendedor"
            item-text="nb_vendedor"
            item-value="id"
            v-model="form.id_vendedor"
            :rules="[rules.select]"
            label="Vendedor"
            :loading="loading"
            dense
            ></v-select>
        </v-col>
          
        <v-col cols="12" md="4">
            <v-select
            :items="selects.tipoSuscripcion"
            item-text="nb_tipo_suscripcion"
            item-value="id"
            v-model="form.id_tipo_suscripcion"
            :rules="[rules.select]"
            label="Tipo Suscripcion"
            :loading="loading"
            dense
            @change="setDiaMonto($event)"
            ></v-select>
        </v-col>

        <v-col cols="12" md="4">
            <v-text-field
                v-model="form.nu_dias"
                label="Dias"
                readonly
                placeholder="Indique Dias"
                type="number"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="4">
            <v-text-field
                v-model="form.nu_monto"
                readonly
                label="Monto"
                placeholder="Indique Monto"
                dense
            ></v-text-field>
        </v-col>
                  
       <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.fe_suscripcion"
                :close-on-content-click="false"
                min-width="290px"
                :disabled="!form.id_tipo_suscripcion"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.fe_suscripcion"
                        :rules="[rules.fecha]"
                        label="Fecha"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.fe_suscripcion" 
                    @input="setFechas()">
                </v-date-picker>
            </v-menu>
        </v-col> 
                
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="dates.fe_vencimiento"
                label="Fecha Vencimiento"
                dense
            ></v-text-field>
        </v-col>


         <v-col cols="12">
            <v-text-field
                :rules="[rules.max(100)]"
                v-model="form.tx_observaciones"
                label="Observaciones"
                placeholder="Indique Observaciones"
                dense
            ></v-text-field>
        </v-col>
         

        </v-row>

        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>
            <form-buttons
                @update="update()"
                @store="store()"
                @clear="clear()"
                @cancel="cancel()"
                :action="action"
                :valid="valid"
                :loading="loading"
            ></form-buttons>
        </v-card-actions>

        <pre v-if="$App.debug">{{ $data }}</pre>

    </v-card>
    
    </v-form>

</template>

<script>

import Appform from '@mixins/Appform';
import AppSuscriptorForm from '@views/suscriptor/AppSuscriptorForm'

export default {

    components:{
        AppSuscriptorForm
    },

    mixins: [Appform],

    data() {
        return {
            resource: 'suscripcion',
            dates:
            {
                fe_suscripcion:      null,
                fe_vencimiento: 	 null,
            },
            pickers:
            {
                fe_suscripcion:      null,
                fe_vencimiento: 	 null,
            },
            form:
            {
                id: 	             null,
				id_suscriptor: 	     null,
				id_vendedor: 	     null,
				id_tipo_suscripcion: null,
				fe_suscripcion: 	 null,
				nu_dias: 	         null,
				nu_monto: 	         null,
				fe_vencimiento: 	 null,
				tx_observaciones: 	 null,
				id_status: 	         null,
				id_usuario: 	     null,
            },
            selects:
            {
                suscriptor: 	 ['?activo=1&combo=1'],
	 	 	 	vendedor: 	     ['?activo=1&combo=1'],
	 	 	 	tipoSuscripcion: ['?activo=1&combo=1'],
            },
            menuSuscriptor: false
        }
    },

    methods:
    {
        setDiaMonto(idTipoSubcripcion){
            
            if(!idTipoSubcripcion) return

            let tipoSubcripcion = this.selects.tipoSuscripcion.find( data => data.id == idTipoSubcripcion)
            this.form.nu_dias   = tipoSubcripcion.nu_dias
            this.form.nu_monto  = tipoSubcripcion.nu_monto

            this.setVencimiento()
        },

        setFechas()
        {
            this.dates.fe_suscripcion = this.formatPicker(this.form.fe_suscripcion, 'fe_suscripcion')
            
            this.setVencimiento()
        },

        setVencimiento()
        {
            if(!this.form.nu_dias) return

            if(!this.form.fe_suscripcion) return

            this.sumWorkingdays(this.form.fe_suscripcion, this.form.nu_dias)

            this.form.fe_vencimiento = this.sumWorkingdays(this.form.fe_suscripcion, this.form.nu_dias).toISOString().substr(0, 10)
            this.dates.fe_vencimiento = this.formatPicker(this.form.fe_vencimiento, 'fe_suscripcion')
        },

        sumWorkingdays(date, days)
        {
            days = parseInt(days) - 1 //include current day
            
            let newDate  = new Date(date)
            
            let currentDay = null

            let weekday   = 0
 
            for (let day = 1; day <= days; day++) { 
                
                currentDay = new Date(newDate.setDate(newDate.getDate() + parseInt(1)))
                weekday = currentDay.getDay()
                if (weekday == 6 )  days++ 
            }

            return currentDay
        },

        newSuscriptor(suscriptor)
        {
            this.selects.suscriptor.push(suscriptor)
            this.form.id_suscriptor = suscriptor.id
            this.menuSuscriptor = false
        }
        
    }
}
</script>

<style>
</style>