<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.amolatina_id"
                label="Amolatina Id"
                placeholder="Indique Amolatina Id"
                dense
            ></v-text-field>
        </v-col>
                  
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
            <v-menu
                v-model="pickers.birthday"
                :close-on-content-click="false"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dates.birthday"
                        :rules="[rules.fecha]"
                        label="Birthday"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                        dense
                    ></v-text-field>
                </template>
                <v-date-picker 
                    v-model="form.birthday" 
                    @input="dates.birthday = formatPicker(form.birthday, 'birthday')">
                </v-date-picker>
            </v-menu>
        </v-col> 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.age"
                label="Age"
                placeholder="Indique Age"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.photo"
                label="Photo"
                placeholder="Indique Photo"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.gender"
                label="Gender"
                placeholder="Indique Gender"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.preference"
                label="Preference"
                placeholder="Indique Preference"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.country"
                label="Country"
                placeholder="Indique Country"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.city"
                label="City"
                placeholder="Indique City"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.minage"
                label="Minage"
                placeholder="Indique Minage"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.maxage"
                label="Maxage"
                placeholder="Indique Maxage"
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
            resource: 'profile',
            dates:
            {
                birthday: 	 null,
            },
            pickers:
            {
                birthday: 	 null,
            },
            form:
            {
                id: 	null,
				amolatina_id: 	null,
				name: 	null,
				birthday: 	null,
				age: 	null,
				photo: 	null,
				gender: 	null,
				preference: 	null,
				country: 	null,
				city: 	null,
				minage: 	null,
				maxage: 	null,
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