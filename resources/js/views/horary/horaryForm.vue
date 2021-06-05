<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.name"
                label="Name"
                placeholder="Indique Name"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.turn_id"
                label="Turn Id"
                placeholder="Indique Turn Id"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.hours"
                label="Hours"
                placeholder="Indique Hours"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.value"
                label="Value"
                placeholder="Indique Value"
                dense
            ></v-text-field>
        </v-col>
                 
        <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.start_at"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.start_at"
                        :rules="[rules.fecha]"
                        label="Start At"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.start_at" 
                    @input="dates.start_at = formatPicker(form.start_at, 'start_at')">
                </v-date-picker>
            </v-menu>
        </v-col>
        <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.end_at"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.end_at"
                        :rules="[rules.fecha]"
                        label="End At"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.end_at" 
                    @input="dates.end_at = formatPicker(form.end_at, 'end_at')">
                </v-date-picker>
            </v-menu>
        </v-col> 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.comments"
                label="Comments"
                placeholder="Indique Comments"
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
            resource: 'horary',
            dates:
            {
                start_at: 	 null,
	 	 	 	end_at: 	 null,
            },
            pickers:
            {
                start_at: 	 null,
	 	 	 	end_at: 	 null,
            },
            form:
            {
                id: 	null,
				name: 	null,
				turn_id: 	null,
				hours: 	null,
				value: 	null,
				start_at: 	null,
				end_at: 	null,
				comments: 	null,
				status_id: 	null,
				user_id: 	null,
            },
            selects:
            {
                
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