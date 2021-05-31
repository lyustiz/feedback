<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.name"
                label="Nombre"
                dense
            ></v-text-field>
        </v-col>

         <v-col cols="12" md="6">
            <v-select
            :items="selects.user"
            item-text="full_name"
            item-value="id"
            v-model="form.manager_id"
            :rules="[rules.select]"
            label="Manager"
            :loading="loading"
            dense
            ></v-select>
        </v-col>
                   
        <v-col cols="12">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.comments"
                label="Comments"
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
            resource: 'group',
            form:
            {
                id: 	    null,
				name: 	    null,
				value: 	    null,
				comments: 	null,
				status_id: 	null,
				manager_id: null,
				user_id: 	null,
            },
            selects:
            {
                user: ['/list?manager=true']
            },
            default:
            {
                value: 1
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