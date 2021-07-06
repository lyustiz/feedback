<template>

   <v-card color="transparent" flat dark min-height="93vh">
    <v-card-text>
        <v-row dense>
            <v-col cols="auto">

                <v-card color="rgba(0,0,0,0.4)" width="20vw" class="pa-2">

                    <v-subheader>
                        <v-row no-gutters>
                            <v-col>
                                Comisiones
                            </v-col>
                             <v-col cols="auto">
                                <v-btn small icon color="success" :loading="loading" @click="list()"> <v-icon>mdi-reload</v-icon></v-btn>
                            </v-col>
                        </v-row>
                       
                        </v-subheader>

                <v-row dense>
                    <v-col>
                        <v-select
                          v-model="table"
                          prepend-inner-icon="mdi-table-furniture"
                          label="Mesas"
                          item-text="name"
                          :items="tables"
                          :loading="loading"
                          hide-details
                          outlined
                          filled
                          dense
                          return-object
                          @change="list()"
                          autofocus
                          :rules="[rules.required]"
                        ></v-select>
                    </v-col>

                    <v-col cols="12">
                        <PresenceCalendar @onUpdateDate="setDay($event)"></PresenceCalendar>
                    </v-col>

                </v-row>
                </v-card>

            </v-col>

            <v-col>
                <v-card color="rgba(0,0,0,0.4)" class="pa-2" max-height="92vh" mix-height="88vh">
                    <v-card-title class="pa-1">
                        <v-row no-gutters>
                          <v-col>{{(table) ? table.name : 'Seleccione Mesa' }}</v-col>
                          <v-col>
                            <v-radio-group v-model="turn" row  dense hide-details class="mt-0" prepend-icon="mdi-close" @click:prepend="turn=null">
                              <v-radio label="Mañana" value="1" color="yellow" ></v-radio>
                              <v-radio label="Tarde" value="2" color="orange"></v-radio>
                              <v-radio label="Noche" value="3" color="purple"></v-radio>
                            </v-radio-group>
                          </v-col>
                          <v-col cols="auto" v-if="table">
                              <v-icon size="20" color="green" left>mdi-cash-plus</v-icon>
                              {{totalBonusTable(precense) || 0.00}}
                          </v-col>
                          <v-col cols="auto" v-if="table">
                              <v-icon size="20" color="red" class="ml-2" left>mdi-cash-remove</v-icon>
                              {{totalWriteOffTable(precense) || 0}}
                          </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="comission-container custom-scroll">
                        
                      <v-expansion-panels>
                          <v-expansion-panel v-for="user in precense" :key="user.id">
                            <v-expansion-panel-header>
                              <v-row dense >
                                <v-col cols="auto" >
                                  <v-avatar color="grey" class="elevation-3" :size="30">
                                    <v-img :src="`/storage/photo/operator/${user.photo || 'nophoto'}`" ></v-img>
                                  </v-avatar>
                                </v-col>
                                <v-col>
                                  {{user.full_name}}
                                </v-col>
                                <v-col cols="auto">
                                    <v-icon size="20" color="green" left>mdi-cash-plus</v-icon>
                                    {{formatNumber(user.presence_sum_bonus || 0.00)}}
                                </v-col>
                                <v-col cols="auto">
                                    <v-icon size="20" color="red" class="ml-2" left>mdi-cash-remove</v-icon>
                                    {{parseInt(user.presence_sum_writeoff || 0)}}
                                </v-col>
                            </v-row>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>

                              <v-expansion-panels>

                                <v-expansion-panel v-for="profile in user.profile_precense" :key="profile.id" class="blue-grey darken-4">
                                  
                                  <v-expansion-panel-header>

                                    <v-row dense >
                                        <v-col cols="auto" >
                                          <v-avatar color="grey" class="elevation-3" :size="30">
                                            <v-img :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img>
                                          </v-avatar>
                                        </v-col>

                                        <v-col>
                                            {{profile.name}} 
                                            <list-simple-icon icon="mdi-check-circle-outline" label="Asignado" color="green" :size="16" v-if="isAssigned( user.profile, profile)"></list-simple-icon>
                                            <list-simple-icon icon="mdi-alert-circle-outline" label="No asignado" color="amber" :size="16" v-else></list-simple-icon>
                                        </v-col>
                                        <v-col cols="auto">
                                            <v-icon size="20" color="green" left>mdi-cash-plus</v-icon>
                                            {{formatNumber(profile.sumBonus || 0.00)}}
                                        </v-col>
                                        <v-col cols="auto">
                                            <v-icon size="20" color="red" class="ml-2"  left>mdi-cash-remove</v-icon>
                                           {{ parseInt( profile.countWriteoff || 0)}}
                                        </v-col>
                                    </v-row>

                                  </v-expansion-panel-header>

                                  <v-expansion-panel-content>

                                        <v-expansion-panels> 

                                            <v-expansion-panel v-for="presence in profile.presence" :key="presence.id"> 

                                                <v-expansion-panel-header>            
                                                    <v-row>
                                                        <v-col>
                                                            {{UTCToLocalDate(presence.start_at)}} 
                                                        </v-col>
                                                        <v-col>
                                                            {{UTCToLocalDate(presence.end_at) || 'activo'}}
                                                        </v-col>
                                                        <v-col>
                                                            {{  formatNumber(presence.bonus || 0) }}
                                                        </v-col>
                                                        <v-col>
                                                            {{ parseInt(presence.writeoff || 0) }}
                                                        </v-col>
                                                    </v-row>
                                                </v-expansion-panel-header>  
                                                <v-expansion-panel-content>
                                              
                                                    <ComissionPresence :presence="presence"></ComissionPresence>

                                                </v-expansion-panel-content>
                                            
                                            </v-expansion-panel> 

                                        </v-expansion-panels> 

                                  </v-expansion-panel-content>

                                </v-expansion-panel>

                              </v-expansion-panels>

                            </v-expansion-panel-content>
                        </v-expansion-panel>
                      </v-expansion-panels>


                             
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>


        <v-overlay  :opacity="0.4" :value="loading">
        <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
      </v-overlay>
        
    </v-card-text> 


       
   </v-card>
        
       
               

</template>

<script>
import AppData from '@mixins/AppData';
import PresenceCalendar from './components/PresenceCalendar.vue'
import ComissionPresence from './components/ComissionPresence.vue'
export default {

    mixins:     [ AppData ],

    components: { 
        PresenceCalendar, 
        ComissionPresence
    },

    created(){
      this.getTable()
    },

    computed:{
      precense() {
        return (this.turn) ? this.users.filter( user => ((user.turn) ? user.turn.id : 0) == this.turn ) : this.users
      }
    },

    data: () => ({
        tables: [],
        users: [],
        table: null,
        agency:  null,
        start_at: new Date().toISOString().substr(0, 10),
        end_at:  new Date().toISOString().substr(0, 10),
        profile: null,
        filter:[],
        turns: [],
        turn: null

    }),

    methods:
    {
      getTable() {
        this.getResource(`table/list/user/${this.userId}`).then(data =>{
          this.tables = data
        })
      },

      list()
      {
        if(this.table){
            let filters = this.setFilters()
            this.getResource(`user/statistics/${this.table.id}${filters}`).then(data =>{
                this.users = data
            })
        }
      },
      
      setDay(days)
      {          
          if(Array.isArray(days))
          {
            this.start_at = days[0]
            this.end_at   = days[1]
          } else {
            this.start_at = days
            this.end_at   = days
          }

          this.list()
      },

      setFilters()
      {   
          this.filter['start_at']  = this.start_at 
          this.filter['end_at']    = this.end_at 
          return this.buildQuery(this.filter);
      },

      buildQuery(filter)
      {
          let query = '';

          for (const key in filter) {
              if(filter[key] != null) {
                  if( Array.isArray(filter[key]) ) {
                      for ( const value of filter[key] ) {
                          query += (query == '&') ?  `${key}[]=${value}` : `&${key}[]=${value}`
                      }
                  } else {
                      query += (query == '&') ?  `${key}=${filter[key]}` : `&${key}=${filter[key]}`
                  }
              }
          }
          return  ( query.includes('?') ) ? query : `?${query}`
      },

      totalBonusTable(users)
      {
        if(users.length < 1) return
        let bonus = 0.00
        for (const user of users) {
            for (const precense of user.presence) { 
               bonus += (precense.bonus) ? parseFloat(precense.bonus) : 0.00
            }  
        }
        return this.formatNumber(bonus)
      },

      totalWriteOffTable(users)
      {
       let writeoff = 0
        for (const user of users) {
            for (const precense of user.presence) { 
               writeoff += (parseFloat(precense.writeoff) > 0) ? 1 : 0
            }  
        }
        return writeoff
      },

      totalBonusProfile(profile, precenses)
      {
        let bonus = 0.00
        for (const precense of precenses) {
          if(precense.profile_id = profile.id)
          {
            bonus += (precense.bonus) ? parseFloat(precense.bonus) : 0.00
          }
        }
        return this.formatNumber(bonus)
      },

      totalWriteOffProfile(profile) 
      {
        let writeoff = 0
        for (const precense of profile.presence) {
          writeoff += (precense.writeoff)  ? 1 : 0
        }
        return writeoff
      },

      isAssigned( profilesAssigned, profile) {
        return profilesAssigned.some( (item)=>  item.id == profile.id)
      }
    }
}

//'comission?type=1&positive=true'
</script>

<style>
.comission-container {
    max-height: 74vh;
    overflow-y: auto;
}
</style>