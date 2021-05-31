<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                 
        <v-col cols="12">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.name"
                label="Name"
                dense
            ></v-text-field>
        </v-col>
                
        <v-col cols="12">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.comments"
                label="Comentarios"
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
            resource: 'turn',
            form:
            {
                id: 	    null,
				name: 	    null,
				value: 	    null,
				comments:   null,
				status_id:  null,
				user_id: 	null,
            },
            select: {

            },
            default: 
            {
                value: 1,
            }
        }
    },

}
</script>

<style>
</style>