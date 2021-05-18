<template>
<v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat class="main-color" dark>

        <v-card-title  class="subtitle-2">
            <v-row>
                <v-col>Operador</v-col>
                <v-col cols="auto"><v-btn icon x-small dark @click="cancel()"><v-icon>mdi-close-circle</v-icon></v-btn></v-col>
            </v-row>
        </v-card-title>

        <v-card-text>
        <v-row dense class="mt-1"> 

            <v-row>
                <v-col >

                    <v-row dense>
                        <v-col cols="12" md="6">
                            <v-text-field
                                :rules="[rules.required]"
                                v-model="form.name"
                                label="Nombre"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12"  md="6">
                            <v-text-field
                                :rules="[rules.required]"
                                v-model="form.surname"
                                label="Apellido"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field> 
                        </v-col>
                    </v-row>

                    <v-row dense>

                        <v-col cols="12" md="6">
                            <v-text-field
                                :rules="[rules.required]"
                                v-model="form.email"
                                label="Email"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12"  md="6">
                            <v-text-field
                                :rules="[rules.required]"
                                v-model="form.password"
                                label="Password"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field>
                        </v-col>

                    </v-row>

                    <v-row dense>
                        <v-col cols="12" md="6">
                            <v-select
                                dense
                                outlined
                                filled
                                label="Grupo"
                                v-model="form.group_id"    
                                :items="selects.group"
                                :rules="[rules.required]"
                                item-value="id"
                                item-text="name"
                                append-icon="mdi-account-group"
                                hide-details
                            ></v-select>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select
                                dense
                                outlined
                                filled
                                label="Mesa"
                                v-model="form.table_id"    
                                :items="selects.table"
                                :rules="[rules.required]"
                                item-value="id"
                                item-text="name"
                                append-icon="mdi-table-furniture"
                                hide-details
                            ></v-select>

                        </v-col>

                         <v-col cols="12">
                            <v-text-field
                                :rules="[rules.max(80)]"
                                v-model="form.comments"
                                label="Comments"
                                placeholder="Indique Comments"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field>
                        </v-col>

                    
                    </v-row>

                    
                </v-col>
                      
                <v-col cols="auto" class="mt-4 text-center">
                    <v-input
                        v-model="form.photo"
                    >
                        <UserPhoto @onSetPhoto="setPhoto($event)"></UserPhoto>
                   </v-input>

                <form-buttons
                    @store="store()"
                    @cancel="cancel()"
                    action="ins"
                    :valid="valid"
                    :loading="loading"
                ></form-buttons>

                </v-col>
            </v-row>

        </v-row>

        </v-card-text>

        <pre v-if="$App.debug">{{ $data }}</pre>

    </v-card>
    
    </v-form>
  
</template>

<script>
import AppForm from '@mixins/AppForm'
import UserPhoto from './components/UserPhoto'
export default {

  mixins: [AppForm],

  components:{
      UserPhoto
  },

    data() {
        return {
            resource: 'user',
            form:
            {
                id: 	        null,
				password: 	    null,
				name: 	        null,
				surname: 	    null,
				role_id: 	    null,
                rolename:       null,
				agency_id: 	    null,
				group_id: 	    null,
                table_id:       null,
				photo: 	        null,
				email: 	        null,
				comments: 	    null,
				status_id: 	    null,
            },
            selects:
            {
                table: [],
                group: [],
            },
            default: {
                agency_id:   1,
                role_id:     4,
                status_id:   1,
                rolename: 'operator',
            }
        }
    },

    methods:
    {
        setPhoto(photoSrc) {
            this.form.photo = photoSrc
        },
    }
}
</script>

<style>

</style>