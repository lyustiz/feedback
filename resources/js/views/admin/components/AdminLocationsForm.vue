<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-title class="deep-orange">
            <v-row no-gutters>
                <v-col class="white--text">Editar Sede</v-col>
                <v-col cols="auto"> 
                        <v-icon color="white pointer" @click="$emit('closeModal')">mdi-close-circle-outline</v-icon>
                </v-col>
            </v-row>
        </v-card-title>

        <v-card-text>

        <v-row class="mt-3" dense>

                 
        <v-col cols="12">
            <v-text-field
                :rules="[rules.required, rules.max(40)]"
                v-model="form.nb_sede"
                label="Sede"
                placeholder="Indique Sede"
                prepend-icon="mdi-store"
                dense
                outlined
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12">
            <v-text-field
                :rules="[rules.required, rules.max(100)]"
                v-model="form.tx_ubicacion"
                label="Ubicacion"
                placeholder="Indique Ubicacion"
                prepend-icon="mdi-sign-direction"
                dense
                outlined
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12">
            <v-text-field
                :rules="[rules.required, rules.max(400)]"
                v-model="form.tx_mapa"
                label="Mapa"
                placeholder="Indique Mapa"
                prepend-icon="mdi-map-marker-radius-outline"
                dense
                outlined
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12">
            <v-text-field
                :rules="[ rules.max(400)]"
                v-model="form.tx_transmision"
                label="Transmision"
                placeholder="Indique Transmision"
                prepend-icon="mdi-television-play"
                dense
                outlined
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[ rules.max(30)]"
                v-model="form.tx_telefono"
                label="Telefono"
                placeholder="Indique Telefono"
                prepend-icon="mdi-phone"
                dense
                outlined
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[ rules.max(50)]"
                v-model="form.tx_whatsapp"
                label="Whatsapp"
                placeholder="Indique Whatsapp"
                prepend-icon="mdi-whatsapp"
                dense
                outlined
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

export default {

    mixins: [Appform],

    data() {
        
        return {
            resource: 'sede',
            form:
            {
                id: 	          null,
				nb_sede: 	      null,
				tx_ubicacion: 	  null,
				tx_mapa: 	      null,
				tx_transmision:   null,
				tx_telefono: 	  null,
				tx_whatsapp: 	  null,
				id_status: 	      null,
				id_usuario: 	  null,
            },
            selects:
            {
                status: 	 [],
            },
        }
    },
}
</script>

<style>
</style>