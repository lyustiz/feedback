<template>

    <v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat>

        <v-card-text>

        <v-row>

                 
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.rol_id"
                label="Rol Id"
                placeholder="Indique Rol Id"
                dense
            ></v-text-field>
        </v-col>
                  
        <v-col cols="12" md="6">
            <v-text-field
                :rules="[rules.required]"
                v-model="form.menu_id"
                label="Menu Id"
                placeholder="Indique Menu Id"
                dense
            ></v-text-field>
        </v-col>
                 
            <v-checkbox
                   :rules="[rules.check]"
                  v-model="form.sel"
                  label="Sel"
                  :true-value="1"
                  :false-value="0"
                  :indeterminate="(form.sel== null)"
                  dense
            ></v-checkbox>

            <v-checkbox
                   :rules="[rules.check]"
                  v-model="form.ins"
                  label="Ins"
                  :true-value="1"
                  :false-value="0"
                  :indeterminate="(form.ins== null)"
                  dense
            ></v-checkbox>

            <v-checkbox
                   :rules="[rules.check]"
                  v-model="form.upd"
                  label="Upd"
                  :true-value="1"
                  :false-value="0"
                  :indeterminate="(form.upd== null)"
                  dense
            ></v-checkbox>

            <v-checkbox
                   :rules="[rules.check]"
                  v-model="form.del"
                  label="Del"
                  :true-value="1"
                  :false-value="0"
                  :indeterminate="(form.del== null)"
                  dense
            ></v-checkbox>

            <v-checkbox
                   :rules="[rules.check]"
                  v-model="form.adm"
                  label="Adm"
                  :true-value="1"
                  :false-value="0"
                  :indeterminate="(form.adm== null)"
                  dense
            ></v-checkbox>
 
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
            resource: 'permission',
            dates:
            {
                
            },
            pickers:
            {
                
            },
            form:
            {
                id: 	null,
				rol_id: 	null,
				menu_id: 	null,
				sel: 	null,
				ins: 	null,
				upd: 	null,
				del: 	null,
				adm: 	null,
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