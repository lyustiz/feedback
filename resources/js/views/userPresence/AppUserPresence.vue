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
                             <v-col>
                                <v-btn small icon color="success" :loading="loading" @click="getUsers()"> <v-icon>mdi-reload</v-icon></v-btn>
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
                          @change="getUsers()"
                          autofocus
                          :rules="[rules.required]"
                        ></v-select>
                    </v-col>

                    <v-col cols="12">
                        <ComissionCalendar @onUpdateDate="setDay($event)"></ComissionCalendar>
                    </v-col>

                </v-row>
                </v-card>

            </v-col>

            <v-col>
                <v-card color="rgba(0,0,0,0.4)" class="pa-2" max-height="92vh" mix-height="88vh">
                    <v-card-title class="pa-1">
                        <v-row no-gutters>
                          <v-col>{{(table) ? table.name : 'Seleccione Mesa' }}</v-col>
                          <v-col cols="auto" v-if="table">
                              <v-icon size="20" color="green" left>mdi-cash-plus</v-icon>
                              {{totalBonusTable(users)}}
                          </v-col>
                          <v-col cols="auto" v-if="table">
                              <v-icon size="20" color="red" class="ml-2" left>mdi-cash-remove</v-icon>
                              {{totalWriteOffTable(users)}}
                          </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="comission-container custom-scroll">
                        
                      <v-expansion-panels>
                          <v-expansion-panel v-for="user in users" :key="user.id">
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
                                    {{formatNumber(user.presence_day_sum_bonus || 0.00)}}
                                </v-col>
                                <v-col cols="auto">
                                    <v-icon size="20" color="red" class="ml-2" left>mdi-cash-remove</v-icon>
                                    {{formatNumber(user.presence_day_sum_writeoff || 0.00)}}
                                </v-col>
                            </v-row>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>

                              <v-expansion-panels>

                                <v-expansion-panel v-for="profile in user.profile" :key="profile.id" class="blue-grey darken-4">
                                  
                                  <v-expansion-panel-header>

                                    <v-row dense >
                                        <v-col cols="auto" >
                                          <v-avatar color="grey" class="elevation-3" :size="30">
                                            <v-img :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img>
                                          </v-avatar>
                                        </v-col>

                                        <v-col>
                                            {{profile.name}}
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
import ComissionCalendar from './components/ComissionCalendar'
import ComissionPresence from './components/ComissionPresence.vue'
export default {

    mixins:     [ AppData ],

    components: { 
        ComissionCalendar, 
        ComissionPresence
    },

    created(){
      this.getTable()
      this.getServices()
    },

    watch:{
        serviceType()  {
            this.serviceSelected = []
        }
    },

    computed:{
    },

    data: () => ({
        tables: [],
        users: [],
        table: null,
        user: null,
        presence:[],
        profiles: [],
        url: 'comission/list',
        types: [ 'bonus',  'writeoff'],
        serviceType: 'bonus',
        services: [ ],
        agency:  null,
        day:     new Date().toISOString().substr(0, 10),
        serviceSelected: [],
        profile: null,
        filter:[]
    }),

    methods:
    {
      getTable() {
        this.getResource(`table/list`).then(data =>{
          this.tables = data
        })
      },

      getUsers()
      {
        if(this.table){
          this.getResource(`user/statistics/${this.table.id}`).then(data =>{
              this.users = data
          })
        }
      },
      
      list() {

          if(this.agency)
          {
              let filters = this.setFilters()
              this.getResource(`${this.url}${filters}`).then(data =>{
                  this.presence = data
              })
          }
      },

      setDay(day)
      {
          this.day = day
          this.list()
      },

      setFilters()
      {   
          this.filter['agency']   = this.agency.amolatina_id 
          this.filter['day']      = this.day 
          this.filter['service']  = this.serviceSelected 
          this.filter['profile']  = (this.profile) ? this.profile.amolatina_id : null
          this.filter['positive'] = (this.serviceType == 'bonus') ? 1 : 0;
          return this.buildQuery(this.filter);
      },

      buildQuery(filter)
      {
          let query = this.url.includes('?') ? '&' : '';

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
          return  ( query.includes('?')  || this.url.includes('?')) ? query : `?${query}`
      },

      getProfiles() {
          this.getResource(`profile/list`).then(data =>{
              this.profiles = data
          })
      },

      getServices() {
          this.getResource(`service`).then(data =>{
              this.services = data
          })
      },

      getdetail(){
          this.getResource('comission/detail').then(data =>{
          })
      },

      remove(item)
      {
          this.filters = this.filters.filter( f => f != item.value) 
      },

      goTo(url)
      {
          console.log(url);
          if(!url) return
          if(this.agency)
          {
              let filters = this.setFilters()
              this.getResource(`${url}${filters}`).then(data =>{
                  this.presence = data
              })
          }
      },

      getService(selected)
      {
          return this.services.find( service => service.value == selected )
      },

      totalBonusTable(users)
      {
        let bonus = 0.00
        for (const user of users) {
            for (const precense of user.presence_day) { 
               bonus += (precense.bonus) ? parseFloat(precense.bonus) : 0.00
            }  
        }
        return this.formatNumber(bonus)
      },

      totalWriteOffTable(users)
      {
       let writeoff = 0
        for (const user of users) {
            for (const precense of user.presence_day) { 
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

      totalWriteOffProfile(profile){
        let writeoff = 0
        for (const precense of profile.presence_day) {
          writeoff += (precense.writeoff)  ? 1 : 0
        }
        return writeoff
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