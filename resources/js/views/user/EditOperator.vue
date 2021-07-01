<template>
<v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat class="main-color" dark>

        <v-card-title  class="subtitle-2">
            <v-row>
                <v-col>usuario</v-col>
                <v-col cols="auto"><v-btn icon x-small dark @click="cancel()"><v-icon>mdi-close-circle</v-icon></v-btn></v-col>
            </v-row>
        </v-card-title>

        <v-card-text>
        <v-row dense class="mt-1"> 

            <v-row>
                <v-col >

                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                                v-model="form.username"
                                label="Usuario"
                                dense
                                filled
                                outlined
                                hide-details
                                readonly
                                prepend-icon="mdi-account"
                            ></v-text-field>
                        </v-col>

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
                                :rules="[rules.max(64)]"
                                v-model="form.password"
                                label="Password"
                                type="password"
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
                                @change="editTurns($event)"
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                dense
                                outlined
                                filled
                                label="Turno"
                                v-model="form.table_turn_id"    
                                :items="turns"
                                :rules="[rules.required]"
                                item-value="id"
                                item-text="name"
                                append-icon="mdi-calendar-clock"
                                hide-details
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                dense
                                outlined
                                filled
                                label="Rol"
                                v-model="form.role_id"    
                                :items="selects.role"
                                :rules="[rules.required]"
                                item-value="id"
                                item-text="name"
                                append-icon="mdi-shield-account"
                                hide-details
                            ></v-select>
                        </v-col>

                        <v-col cols="6" md="4">
                            <v-select
                                dense
                                outlined
                                filled
                                label="Jornada"
                                v-model="form.work_time"    
                                :items="workTime"
                                :rules="[rules.required]"
                                append-icon="mdi-clock"
                                hide-details
                            ></v-select>
                        </v-col>

                         <v-col cols="6" md="4">
                            <v-checkbox
                                v-model="form.in_house"
                                :label="`In House`"
                                prepend-icon="mdi-home"
                                hide-details
                                class="shrink mr-2 mt-0"
                                color="amber"
                            ></v-checkbox>
                        </v-col>

                        <v-col cols="6" md="4">
                            <v-checkbox
                                v-model="form.is_alternate"
                                :label="`Suplente`"
                                prepend-icon="mdi-account-switch-outline"
                                hide-details
                                class="shrink mr-2 mt-0"
                                color="green"
                            ></v-checkbox>
                        </v-col>

                    
                    </v-row>

                    
                </v-col>
                      
                <v-col cols="auto" class="mt-4 text-center">
                    <v-input
                        v-model="form.photo"
                    >
                        <UserPhoto :photo="form.photo" @onSetPhoto="setPhoto($event)"></UserPhoto>
                   </v-input>

                <form-buttons
                    @update="update()"
                    @cancel="cancel()"
                    action="upd"
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

  created()
  {
    this.mapForm()
    this.getTurns(this.item.table_id)
  },

  components:{
      UserPhoto
  },

    data() {
        return {
            resource: 'user',
            form:
            {
                id: 	       null,
                username:      null,
				password: 	   null,
				name: 	       null,
				surname: 	   null,
				role_id: 	   null,
                rolename:      null,
				agency_id: 	   null,
				group_id: 	   null,
                table_id:      null,
                turn_id:       null,
                table_turn_id: null,
                work_time:     null,
                in_house:      null,
                is_alternate:  null,
				photo: 	       null,
				email: 	       null,
				comments: 	   null,
				status_id: 	   null,
            },
            selects:
            {
                table: [],
                group: [],
                role:  ['/list']
            },
            default: {
                agency_id:   1,
                status_id:   1,
                turn_id:     1,
            },
            defaultForm: {
                in_house: 0
            },
            turns: [],
            workTime: [ { text: '8H', value: 8 }, { text: '12H', value: 12 }]
        }
    },

    methods:
    {
        setPhoto(photoSrc) {
            this.form.photo = photoSrc
        },

        editTurns(tableId)
        {
            this.form.table_turn_id = null
            this.getTurns(tableId)
        },

        getTurns(tableId){
            
            this.getResource(`tableTurn/combo/${tableId}`).then( data =>{
                this.turns = data
            })
        },

        extraActions(method)
        {
            let role = this.selects.role.find( role => role.id = this.form.role_id)
            this.form.rolename = role.path

            this.form.in_house  = (this.form.in_house) ? this.form.in_house : 0
            this.form.is_alternate  = (this.form.is_alternate) ? this.form.is_alternate : 0
            
            if(role.id == 3) //coordinator
            {
               let table = this.selects.table.find( table => table.id != this.form.table_id ) 
              /*  
               if( table.coodinator_id != this.form.id){
                   alert('esta accion reemplazar el coordinador de la mesaa ' + table.name)
               } */
            }
        },
    }
}
</script>

<style>

</style>