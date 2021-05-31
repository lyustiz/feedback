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
            :items="selects.turn"
            item-text="name"
            item-value="id"
            v-model="form.turn_id"
            :rules="[rules.select]"
            label="Turno"
            :loading="loading"
            dense
            ></v-select>
        </v-col>

        <v-col cols="12" md="6">
            <v-select
            :items="selects.user"
            item-text="full_name"
            item-value="id"
            v-model="form.coordinator_id"
            :rules="[rules.select]"
            label="Coordinador"
            :loading="loading"
            dense
            ></v-select>
        </v-col>
         

        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.max(80)]"
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
            resource: 'table',
            form:
            {
                id: 	    null,
				name: 	    null,
				value: 	    null,
				turn_id: 	null,
				comments: 	null,
				status_id: 	null,
				coordinator_id: null,
                manager_id: null,
				user_id: 	null,
            },
            selects:
            {
                turn: [],
                user: ['/list?coordinator=true']
            },
            default: 
            {
                value: 1,
                manager_id: 2
            }

        }
    },

    methods:
    {

    }
}
</script>

<style>
</style>