<template>

    <v-form ref="form" v-model="valid" lazy-validation>

   <v-card >
        <v-card-text>
            <v-row dense class="mt-3">

                <v-col cols="12" md="4">
                    <v-text-field
                        :rules="[rules.required, rules.max(80)]"
                        v-model="form.nb_suscriptor"
                        label="Nombre Suscriptor"
                        dense
                        autofocus
                        tabindex="1"
                    ></v-text-field>
                </v-col>
                        
                <v-col cols="12" md="4">
                    <v-text-field
                        :rules="[rules.required]"
                        v-model="form.tx_documento"
                        label="Documento"
                        type="number"
                        dense
                        tabindex="2"
                    ></v-text-field>
                </v-col>
                        
                <v-col cols="12" md="4">
                    <v-text-field
                        :rules="[rules.required, rules.max(50)]"
                        v-model="form.tx_telefono"
                        label="Telefono"
                        dense
                        tabindex="3"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions class="mt-n4">
            <v-spacer></v-spacer>
            <v-btn fab x-small color="error" @click="$emit('closeMenu')"><v-icon>mdi-close</v-icon></v-btn>
            <v-btn fab small color="success" @click="save()"><v-icon>mdi-check</v-icon></v-btn>
        </v-card-actions>
    </v-card>
    
    </v-form>

</template>

<script>

import AppData from '@mixins/AppData';

export default {
    mixins: [AppData],
    data() {
        return {
            resource: 'suscriptor',
            form:
            {
                id: 	          null,
				nb_suscriptor: 	  null,
				tx_documento: 	  null,
				tx_telefono: 	  null,
				id_status: 	      null,
				id_usuario: 	  null,
            },
            default:
            {
                id_status: 1
            }
        }
    },

    methods:
    {
        save()
        {
            this.storeResource('suscriptor', this.form).then( data => {
                this.showMessage(data.msj)
                this.$emit('newSuscriptor', data.suscriptor)
            });
        }

    }
}
</script>

<style>
</style>