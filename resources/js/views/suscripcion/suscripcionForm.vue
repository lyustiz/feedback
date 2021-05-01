<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                         
        <v-col cols="12" md="6">
            <v-select
            :items="selects.suscriptor"
            item-text="nb_suscriptor"
            item-value="id"
            v-model="form.id_suscriptor"
            :rules="[rules.select]"
            label="Suscriptor"
            :loading="loading"
            dense
            ></v-select>
        </v-col>
                  
        <v-col cols="12" md="6">
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
                  
        <v-col cols="12" md="6">
            <v-select
            :items="selects.tipoSuscripcion"
            item-text="nb_tipo_suscripcion"
            item-value="id"
            v-model="form.id_tipo_suscripcion"
            :rules="[rules.select]"
            label="Tipo Suscripcion"
            :loading="loading"
            dense
            ></v-select>
        </v-col>
         
        <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.fe_subcripcion"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.fe_subcripcion"
                        :rules="[rules.fecha]"
                        label="Subcripcion"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.fe_subcripcion" 
                    @input="dates.fe_subcripcion = formatPicker(form.fe_subcripcion, 'fe_subcripcion')">
                </v-date-picker>
            </v-menu>
        </v-col> 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.nu_dias"
                label="Dias"
                placeholder="Indique Dias"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.nu_monto"
                label="Monto"
                placeholder="Indique Monto"
                dense
            ></v-text-field>
        </v-col>
                 
        <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.fe_vencimiento"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.fe_vencimiento"
                        :rules="[rules.fecha]"
                        label="Vencimiento"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.fe_vencimiento" 
                    @input="dates.fe_vencimiento = formatPicker(form.fe_vencimiento, 'fe_vencimiento')">
                </v-date-picker>
            </v-menu>
        </v-col> 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.tx_observaciones"
                label="Observaciones"
                placeholder="Indique Observaciones"
                dense
            ></v-text-field>
        </v-col>
                          
        <v-col cols="12" md="6">
            <v-select
            :items="selects.status"
            item-text="nb_status"
            item-value="id"
            v-model="form.id_status"
            :rules="[rules.select]"
            label="Status"
            :loading="loading"
            dense
            ></v-select>
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

export default {
    mixins: [Appform],
    data() {
        return {
            resource: 'suscripcion',
            dates:
            {
                fe_subcripcion: 	 null,
	 	 	 	fe_vencimiento: 	 null,
            },
            pickers:
            {
                fe_subcripcion: 	 null,
	 	 	 	fe_vencimiento: 	 null,
            },
            form:
            {
                id: 	             null,
				id_suscriptor: 	     null,
				id_vendedor: 	     null,
				id_tipo_suscripcion: null,
				fe_subcripcion: 	 null,
				nu_dias: 	         null,
				nu_monto: 	         null,
				fe_vencimiento: 	 null,
				tx_observaciones: 	 null,
				id_status: 	         null,
				id_usuario: 	     null,
            },
            selects:
            {
                suscriptor: 	  [],
	 	 	 	vendedor: 	      [],
	 	 	 	tipoSuscripcion:  [],
	 	 	 	status: 	      [],
            },
        }
    },

    methods:
    {

    }
}
</script>

<style>
</style>