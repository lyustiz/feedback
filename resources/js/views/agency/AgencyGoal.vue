<template>
<v-form ref="form" v-model="valid" lazy-validation>

    <v-card :loading="loading" flat class="main-color" dark>

        <v-card-title  class="subtitle-2">
            <v-row>
                <v-col>Definir Metas - {{ agency.name }}</v-col>
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
                                v-model="form.goal_day"
                                label="Meta Dia"
                                type="number"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12"  md="6">
                            <v-text-field
                                :rules="[rules.required]"
                                v-model="form.goal_month"
                                label="Meta Mes"
                                type="number"
                                dense
                                filled
                                outlined
                                hide-details
                            ></v-text-field> 
                        </v-col>

                    </v-row>

                    <v-row>
                        <v-col ></v-col>
                        <v-col cols="auto">
                            <form-buttons
                                @update="update()"
                                @cancel="cancel()"
                                action="upd"
                                :valid="valid"
                                :loading="loading"
                            ></form-buttons>
                        </v-col>
                    </v-row>

                    
                

                </v-col>
            </v-row>

        </v-row>

        </v-card-text>

        <pre v-if="$App.debug">{{ $data }}</pre>

    </v-card>
    
    </v-form>
  
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins: [AppData],

  props:{
    agency: {
        type: Object,
        default: () => {}
    }
 },

  created()
  {
    this.mapForm()
  },

  computed:{

    fullUrlId() 
    {
        return this.fullUrl + '/' + this.item.id + '/goals'
    },
  },

    data() {
        return {
            form: {
                goal_day: null,
                goal_month: null,
                user_id: null
            }
        }
    },

    methods:{

        mapForm()
        {
            this.form.goal_day   = this.agency.goal_day
            this.form.goal_month = this.agency.goal_month
            this.form.user_id    = this.userId
        },

        update()
        {
            this.updateResource(`agency/${this.agency.id}/goals`, this.form).then( data => {
                let agency =  JSON.parse(JSON.stringify(this.agency));
                agency.goal_day = this.form.goal_day
                agency.goal_day = this.form.goal_month
                this.$store.commit('updateAgencyManage' , agency)  
                this.showMessage(data.msj)
            }) 
        },

        cancel()
        {
            this.$emit('closeDialog')
        }
    }
}
</script>

<style>

</style>