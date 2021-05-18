<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                
        <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.day"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.day"
                        :rules="[rules.fecha]"
                        label="Fecha"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.day" 
                    @input="dates.day = formatPicker(form.day, 'day')">
                </v-date-picker>
            </v-menu>
        </v-col> 
        <v-col cols="12" md="6">
            <v-select
                :rules="[rules.select]"
                v-model="form.penalty_type_id"
                :items="selects.penaltyType"
                item-text="name"
                item-value="id"
                label="Tipo Falta"
                dense
            ></v-select>
        </v-col>
                  
        <v-col cols="12">
            <v-text-field
                :rules="[rules.max(80)]"
                v-model="form.comments"
                label="Descripcion"
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

import AppForm from '@mixins/AppForm';

export default {
    mixins: [AppForm],
    data() {
        return {
            resource: 'penalty',
            dates:
            {
                day: 	 null,
            },
            pickers:
            {
                day: 	 null,
            },
            form:
            {
                id: 	         null,
				day: 	         null,
				penalty_type_id: null,
				user_id: 	     null,
				comments: 	     null,
				status_id: 	     null,
				user_id_ed: 	 null,
            },
            selects:
            {
                penaltyType:[]
            },
        }
    },

    methods:
    {
        extraActions(method)
        {
            this.form.user_id_ed = this.userId
        },
    }
}
</script>

<style>
</style>