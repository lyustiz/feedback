<template>

   <v-card color="transparent" flat dark min-height="93vh">
    <v-card-text>
        <v-row dense>
            <v-col cols="auto">

                <v-card color="rgba(0,0,0,0.4)" width="20vw" class="pa-2">

                    <v-subheader>Comisiones</v-subheader>

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

                    <!-- <v-col cols="12">
                        <v-autocomplete
                            v-model="user"
                            label="Perfiles"
                            item-text="name"
                            no-data-text="No existen perfiles Disponibles"
                            :items="users"
                            :disabled="loading"
                            :loading="loading"
                            hide-details
                            outlined
                            filled
                            dense
                            clearable
                            return-object
                            @change="list()"
                        >
                            <template v-slot:item="{item}">
                            <v-row dense class="grey lighten-5 subtitle-1">
                                <v-col cols="auto">
                                    <v-avatar color="grey" class="elevation-3" :size="30">
                                    <v-img :src="`/storage/photo/operator/${item.photo || 'nophoto'}`" ></v-img>
                                    </v-avatar>
                                </v-col>
                                <v-col>
                                {{item.name}}
                                </v-col>
                                <v-col cols="auto">
                                    {{item.username}}
                                </v-col>
                            </v-row>
                            </template>
                        </v-autocomplete>
                    </v-col>
 -->
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
                                  {{user.name}}
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
                                            {{totalBonusProfile(profile)}}
                                        </v-col>
                                        <v-col cols="auto">
                                            <v-icon size="20" color="red" class="ml-2"  left>mdi-cash-remove</v-icon>
                                            {{totalWriteOffProfile(profile)}}
                                        </v-col>
                                    </v-row>

                                  </v-expansion-panel-header>

                                  <v-expansion-panel-content>

                                        <v-expansion-panels> 

                                            <v-expansion-panel v-for="presence in profile.presence_day" :key="presence.id"> 

                                                <v-expansion-panel-header>            
                                                    <v-row>
                                                        <v-col>
                                                            {{presence.start_at}}
                                                        </v-col>
                                                        <v-col>
                                                            {{presence.end_at || 'activo'}}
                                                        </v-col>
                                                        <v-col>
                                                            {{  presence.bonus }}
                                                        </v-col>
                                                        <v-col>
                                                            {{  presence.writeoff }}
                                                        </v-col>
                                                    </v-row>
                                                </v-expansion-panel-header>  
                                                <v-expansion-panel-content>
                                                    <v-row v-for="comission in presence.comission_day" :key="comission.id">
                                                        <v-col>
                                                            {{ comission.comission_at }}
                                                        </v-col>
                                                        <v-col>
                                                            {{ comission.points }}
                                                        </v-col>
                                                        <v-col>
                                                            {{  comission.service }}
                                                        </v-col>
                                                        <v-col>
                                                            {{  comission.user_id }}
                                                        </v-col>
                                                    </v-row>
                                                </v-expansion-panel-content>
                                            
                                            </v-expansion-panel> 

                                        </v-expansion-panels> 

                                  </v-expansion-panel-content>

                                </v-expansion-panel>

                              </v-expansion-panels>

                            </v-expansion-panel-content>
                        </v-expansion-panel>
                      </v-expansion-panels>


                               <!--  <v-card color="rgba(0,0,0,0.4)" class="ma-1 rounded-lg">
                                    <v-row dense>
                                        <v-col cols="5">
                                            <v-row no-gutters >
                                                <v-col cols="12" class="caption text-center">{{presence.client_id}}</v-col>
                                                <v-col cols="12" class="text-center">
                                                    <v-row no-gutters justify="center">
                                                        <v-col cols="auto">
                                                            <v-avatar color="blue" class="elevation-3" :size="30">
                                                                <v-img :src="`/storage/photo/client/${(presence.client) ? presence.client.photo || 'nophoto' : 'nophoto'}.jpg`" ></v-img>
                                                            </v-avatar>
                                                        </v-col>
                                                        <v-col cols="auto" v-if="presence.client">
                                                            <v-badge v-if="presence.client.crown > 0" offset-x="6" offset-y="12" color="rgba(0,0,0,0.15)" :content="presence.client.crown">  
                                                                <list-simple-icon icon="mdi-crown" :label="formatNumber(presence.client.points)" color="amber" :size="20"></list-simple-icon>
                                                            </v-badge> 
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                                <v-col cols="12" class="caption text-center">{{(presence.client) ? presence.client.name : '-'}}</v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col class="text-center">

                                            <v-row no-gutters>
                                                <v-col cols="12" class="text-detail" :class="(presence.positive = 1) ? 'white--text' : 'red--text' ">
                                                     {{ hourFromDateTime(presence.presence_at) }}
                                                </v-col>
                                                <v-col cols="12">
                                                    <list-simple-icon  
                                                        :size="32"
                                                        :icon="presence.has_service.icon" 
                                                        :label="presence.has_service.name"
                                                        :color="presence.has_service.color"
                                                        v-if="presence.has_service"
                                                    > </list-simple-icon>
                                                    <list-simple-icon  
                                                        :size="32"
                                                        icon="mdi-comment-question" 
                                                        :label="presence.service"
                                                        color="amber"
                                                        v-else
                                                    > </list-simple-icon>
                                                </v-col>
                                                <v-col cols="12" class="text-detail" :class="(presence.positive = 1) ? 'white--text' : 'red--text' ">
                                                    {{ formatNumber(presence.points) }}
                                                </v-col>
                                            </v-row>
                                            
                                        </v-col>
                                        <v-col cols="5">
                                            <v-row no-gutters>
                                                <v-col cols="12" class="caption text-center">{{presence.profile_id}}</v-col>
                                                <v-col cols="12" class="text-center">
                                                    <v-avatar color="grey" class="elevation-3" :size="30">
                                                        <v-img :src="`/storage/photo/profile/${(presence.profile) ? presence.profile.photo || 'nophoto' : 'no-photo'}.jpg`" ></v-img>
                                                    </v-avatar>
                                                    </v-col>
                                                <v-col cols="12" class="caption text-center">{{(presence.profile) ? presence.profile.name : ''}}</v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-card> -->
                            
                       
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
export default {

    mixins:     [ AppData ],

    components: { 
        ComissionCalendar
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
       let writeoff = 0.00
        for (const user of users) {
            for (const precense of user.presence_day) { 
               writeoff += (precense.writeoff) ? parseFloat(precense.writeoff) : 0.00
            }  
        }
        return this.formatNumber(writeoff)
      },

      totalBonusProfile(profile)
      {
        let bonus = 0.00
        for (const precense of profile.presence_day) {
          bonus += (precense.bonus) ? parseFloat(precense.bonus) : 0.00
        }
        return this.formatNumber(bonus)
      },

      totalWriteOffProfile(profile){
        let writeoff = 0.00
        for (const precense of profile.presence_day) {
          writeoff += (precense.writeoff) ? parseFloat(precense.writeoff) : 0.00
        }
        return this.formatNumber(writeoff)
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