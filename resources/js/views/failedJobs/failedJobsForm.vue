<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.uuid"
                label="Uuid"
                placeholder="Indique Uuid"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.connection"
                label="Connection"
                placeholder="Indique Connection"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.queue"
                label="Queue"
                placeholder="Indique Queue"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.payload"
                label="Payload"
                placeholder="Indique Payload"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.exception"
                label="Exception"
                placeholder="Indique Exception"
                dense
            ></v-text-field>
        </v-col>
                 
        <v-col cols="12" md="6">
            <v-menu
                v-model="pickers.failed_at"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.failed_at"
                        :rules="[rules.fecha]"
                        label="Failed At"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.failed_at" 
                    @input="dates.failed_at = formatPicker(form.failed_at, 'failed_at')">
                </v-date-picker>
            </v-menu>
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
            resource: 'failed_jobs',
            dates:
            {
                failed_at: 	 null,
            },
            pickers:
            {
                failed_at: 	 null,
            },
            form:
            {
                id: 	null,
				uuid: 	null,
				connection: 	null,
				queue: 	null,
				payload: 	null,
				exception: 	null,
				failed_at: 	null,
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