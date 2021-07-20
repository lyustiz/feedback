<template>

<v-card dark color="transparent">
  <v-card-title class="py-0">
    <v-row no-gutters>
      <v-col>
        <span >Online: {{ totalEvents.online }} / {{profiles.length}}</span><span > - Pendiente: Cartas {{ totalEvents.letter }}</span><span > - Mensajes {{ totalEvents.introductory }}</span>
      </v-col>
      <v-col cols="auto">
        <v-btn small icon color="success" :loading="loading" @click="list()"><v-icon>mdi-reload</v-icon></v-btn>
        <v-btn small icon color="red" :loading="loading" @click="profileEvents()"><v-icon>mdi-reload</v-icon></v-btn>
      </v-col>
    </v-row>
  </v-card-title>
  <v-card-text class="pt-2">
    <v-row dense>
      <v-col v-for="profile in profiles" :key="profile.id" cols="12" lg="3" md="4" sm="6">
        <v-card color="rgba(0,0,0,0.4)" min-height="7.9rem">
          <v-card-text >
            <v-tooltip bottom color="rgba(0,0,0,0.8)">
              <template v-slot:activator="{ on, attrs }">
                <v-btn x-small v-on="on" v-bind="attrs" fab color="rgba(0,0,0,0.4)" class="mt-4 ml-n4" absolute top left>{{profile.agency.name.substr(0,2)}}</v-btn>
              </template>
                    <span>{{profile.agency.name}}</span>
              </v-tooltip>
            <v-row dense> 
              <v-col cols="auto">
                <v-col cols="12" class="pa-0 ma-0 text-center">{{profile.name}}</v-col> 
                <v-badge offset-x="9" offset-y="7" overlap :color="(profile.events.online == 1) ? 'green' : 'red'" :value="true" dot> 
                <v-avatar size="80">
                  <v-img :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img>
                </v-avatar>
                </v-badge>
                <v-col cols="12" class="pa-0 ma-0 caption">{{profile.amolatina_id}}</v-col> 
              </v-col>
              <v-col>
                <v-row no-gutters>
                    <v-col cols="6" >
                      <v-tooltip bottom color="blue">
                        <template v-slot:activator="{ on, attrs }">
                          <v-progress-linear v-on="on" v-bind="attrs"
                          :value="profile.presence_day_sum_bonus*100/400 || 0"
                          color="blue"
                          height="14"
                          class="mb-2 mt-1"
                          >
                            <span>{{formatNumber(profile.presence_day_sum_bonus)}}</span>
                          </v-progress-linear>
                        </template>
                        <span>DIA</span>
                      </v-tooltip>
                    </v-col>
                    <v-col cols="6">
                      <v-tooltip bottom color="green">
                        <template v-slot:activator="{ on, attrs }">
                          <v-progress-linear v-on="on" v-bind="attrs"
                          :value="profile.presence_month_sum_bonus*100/2000 || 0"
                          color="green"
                          height="14"
                          class="mb-2 mt-1"
                          >
                            <span>{{formatNumber(profile.presence_month_sum_bonus)}}</span>
                          </v-progress-linear>
                        </template>
                        <span>MES</span>
                      </v-tooltip>
                    </v-col>
                    <v-col cols="6">
                      <v-tooltip bottom color="amber darken-2">
                        <template v-slot:activator="{ on, attrs }">
                          <v-progress-linear v-on="on" v-bind="attrs"
                          :value="profile.presence_day_sum_writeoff || 0"
                          color="amber darken-2"
                          height="14"
                          class="mb-2 mt-1"
                          >
                            <span>{{formatNumber(profile.presence_day_sum_writeoff)}}</span>
                          </v-progress-linear>
                        </template>
                        <span>DIA</span>
                      </v-tooltip>
                    </v-col>
                    <v-col cols="6">
                      <v-tooltip bottom color="red">
                        <template v-slot:activator="{ on, attrs }">
                          <v-progress-linear v-on="on" v-bind="attrs"
                          :value="profile.presence_month_sum_writeoff || 0"
                          color="red"
                          height="14"
                          class="mb-2 mt-1"
                          >
                            <span>{{parseInt(profile.presence_month_sum_writeoff||0)}}</span>
                          </v-progress-linear>
                        </template>
                        <span>MES</span>
                      </v-tooltip>
                    </v-col>
                </v-row>
                <v-row>
                  <v-col> 
                    <v-tooltip bottom color="rgba(0,0,0,0.6)" v-for="user in profile.user_has_presence_day" :key="user.id">
                      <template v-slot:activator="{ on, attrs }">
                        <v-badge offset-x="9" offset-y="7" overlap :color="colorAssignedPresence(profile, user.id)" :value="isUserPresence(profile, user.id)" dot>
                          <v-avatar v-on="on" v-bind="attrs" size="40" color="rgba(0,0,0,0.4)" class="mx-1" >
                            <v-img :src="`/storage/photo/operator/${user.photo || 'nophoto.jpg'}`" ></v-img>
                          </v-avatar>
                        </v-badge>
                      </template>
                      <v-col>
                        {{user.full_name}} 
                        <v-badge v-if="user.turn" offset-x="15" offset-y="12" color="rgba(0,0,0,0.15)" :content="user.work_time"> 
                          <list-simple-icon  :icon="user.turn.icon" :label="` ${user.turn.name} ${user.work_time} H`" :color="user.turn.color"></list-simple-icon>
                        </v-badge>
                        <v-badge v-if="user.table" offset-x="10" offset-y="12" color="rgba(0,0,0,0.15)" :content="user.table.value">  
                          <list-simple-icon icon="mdi-table-furniture" :label="user.table.name" color="amber"></list-simple-icon>
                        </v-badge> 
                      </v-col>
                    </v-tooltip>

                    <v-avatar v-if="profile.user_has_presence_day<1" size="30" color="transparent" class="mx-1" >
                      <v-img :src="`/storage/photo/operator/nophoto.jpg'}`" ></v-img>
                    </v-avatar>
                  </v-col>
                </v-row>
                <v-row class="mt-1">
                  <v-spacer></v-spacer>
                  <v-col cols="6" class="pa-0"> 
                    <v-row no-gutters>
                      <v-col>
                        <v-badge color="red" overlap offset-x="-3" left :value="profile.events.introductory > 0" :content="profile.events.introductory">
                          <list-simple-icon label="Chat" icon="mdi-comment-text-outline" color="orange" :size="18"></list-simple-icon>
                        </v-badge>
                      </v-col>
                      <v-col>
                        <v-badge color="red" overlap offset-x="-3" left :value="profile.events.letter > 0" :content="profile.events.letter">
                          <list-simple-icon label="Carta" icon="mdi-email-outline" color="amber" :size="18"></list-simple-icon>
                        </v-badge>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-card-text>
</v-card>
  
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins: [ AppData ],

  created()
  {
    this.list()
  },

  data: () => ({
    profiles: [],
    totalEvents: { introductory: 0, online: 0, letter: 0 }
  }),

  methods: {
    list()
    {
      this.getResource(`profile/all`).then(data =>{
          this.profiles = data
          this.profileEvents()
      })
    },

    profileEvents()
    {
      this.getResource(`profile/events`).then(data =>{
          this.totalEvents = data.totalEvents
          this.setEventProfiles(data.profileEvents)
      })
    },

    setEventProfiles(profileEvents){
      for (const [idx, profile] of this.profiles.entries()) {
        let profileId = profile.amolatina_id
        if(profileEvents[profileId])
        {
          this.profiles[idx]['events']['introductory'] =  (profileEvents[profileId].introductory) ? profileEvents[profileId].introductory.fresh : 0
          this.profiles[idx]['events']['letter'] =  (profileEvents[profileId].letter) ? profileEvents[profileId].letter.fresh : 0
          this.profiles[idx]['events']['online'] =  profileEvents[profileId].online
        } 
      }
    },

    isUserPresence(profile, userId)
    {
      return  userId == ((profile.presence ) ? profile.presence.user_id : 0) 
    },

    colorAssignedPresence(profile, userId)
    {
      let assigned = profile.users_profile_assigned.some( (item) => item.user_id = userId)
      
      return  (assigned) ? 'green' : 'amber'
    }
  }
}
</script>

<style>

</style>