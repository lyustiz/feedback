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
                :rules="[rules.max(80)]"
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
            resource: 'payment_type',
            dates:
            {
                
            },
            pickers:
            {
                
            },
            form:
            {
                id: 	null,
				name: 	null,
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