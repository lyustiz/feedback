<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>
        <v-row class="title">
            <v-col cols="auto" >
              <v-icon left>mdi-account-multiple-outline</v-icon>  Perfiles
            </v-col>
            <v-col cols="auto" > <v-btn icon :loading="loading"><v-icon  small @click="list()">mdi-reload</v-icon> </v-btn></v-col>
            <v-col > </v-col>
            <v-col cols="auto">
                <v-btn small :color="(myProfilesStarted.length > 0) ? 'error' : 'success'" @click="setPresence()" :loading="loading">
                  <v-icon dark> {{ (myProfilesStarted.length > 0) ? 'mdi-stop' : 'mdi-play'}}</v-icon>
                   {{ (myProfilesStarted.length > 0) ? 'pausar' : 'Iniciar' }} 
                </v-btn>
            </v-col>
        </v-row>
        

    </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 

        <v-list-item-group
          v-model="profile"
          color=""
          multiple

        >
        <v-list-item v-for="profile in profiles" :key="profile.id" :value="profile" :color="myProfilesStarted.includes(profile.id) ? 'green':'blue'" > <!-- :disabled="!myProfilesStarted.includes(profile.id)" -->
          <v-list-item-avatar color="blue" size="60">
            <v-img :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img> 
          </v-list-item-avatar>
          <v-list-item-content>
              <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                    <v-tooltip bottom color="blue">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ profile.presence_day_sum_profit || 0 }}  /  {{ 200 }}</span>
                    </template>
                    <span>Ganacias Dia</span>
                    </v-tooltip>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                    <v-tooltip bottom color="red">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{profile.presence_day_sum_writeoff}}</span>
                    </template>
                    <span>Perdidas Dia</span>
                    </v-tooltip>
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                  <v-progress-linear
                  :value="profile.presence_day_sum_profit*100/200 || 0"
                  color="blue"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
               <v-col>
                  <v-progress-linear
                  :value="profile.presence_day_sum_writeoff*(-1) || 0"
                  color="red"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
              </v-row>
              
              </v-list-item-title>
              <v-list-item-subtitle class="pt-2">
                <v-row>
                  <v-col>{{profile.name}}</v-col>
                  <v-col cols="auto" v-if="profile.presence">
                    <v-icon :color="( myProfilesStarted.includes(profile.id) ) ? 'yellow' : 'red'" size="20"> 
                      {{(myProfilesStarted.includes(profile.id)) ? 'mdi-account-star' : 'mdi-lock'  }}
                    </v-icon> 
                  </v-col>
                  <v-col cols="auto">
                    <v-icon :color="(profile.presence) ? 'green' : 'red'" size="20"> 
                      {{(profile.presence) ? 'mdi-checkbox-blank-circle' : 'mdi-checkbox-blank-circle-outline'}}
                    </v-icon> 
                  </v-col>
                </v-row>
              
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon>
                <v-icon class="mt-6">mdi-dots-vertical</v-icon>
            </v-list-item-icon>
        </v-list-item>
        </v-list-item-group>
      </v-list>
      
    </v-card-text>
  </v-card>
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins: [AppData],

  created() {
    this.list()
    this.form.token = this.token 
    this.reload()
  },

  computed: {
    profile()
    {
      return this.$store.getters['getProfile']
    },
    token()
    {
      return this.$store.getters['getAmolatinaToken']
    },
    started()
    {
      return this.myProfilesStarted.length > 0
    }
  },

  data: () => ({
    profiles: [],
    profilesStarted:   [],
    profilesAvailable: [],
    myProfilesStarted: [],
    active: false,
    form: {
      id: 	      null,
      user_id: 	  null,
      profiles_id: [],
      token: null
    },
    isReload: null,
  }),

  methods: {

    list() {
        this.getResource(`profile/user/${this.userId}`).then( data => {
          this.profiles = data
          this.setActives()
        })
    },

    reload()
    {
      clearInterval(this.isReload)
      this.isReload = setInterval( () => {
          this.list();
      }, 30000 )
    },

    setProfile(profile)
    {
      this.$store.commit('setProfile', profile)
    },

    setPresence()
    {
      if(this.myProfilesStarted.length > 0)
      {
        this.stopPresence();
      } else  {
        this.startPresence();
      } 

    },

    startPresence()
    {
      if(this.profilesAvailable.length < 1 )
      {
        this.showError('No existen perfiles Disponibles')
        this.list()
        return
      }
      this.form.profiles_id = this.profilesAvailable 
      this.storeResource('userPresence', this.form)
      .then(data => {
        this.showMessage(data.msj)
      })
      .finally( () => 
      {
        this.list()
      });
    },

    stopPresence()
    {
      if(this.myProfilesStarted.length < 1 )
      {
        this.showError('No posees perfiles iniciados')
        this.list()
        return
      }
      this.updateResource('userPresence/stop', this.form)
      .then(data => {
        this.showMessage(data.msj)
      })
      .finally( () => 
      {
        this.list()
      });
    },

    setActives()
    {
      this.profilesStarted   = []
      this.profilesAvailable = []
      this.myProfilesStarted = []
      
      this.profiles.forEach(profile => {
        if(profile.presence){
          this.profilesStarted.push(profile.id)
          if(profile.presence.user.id == this.userId)
          {
            this.myProfilesStarted.push(profile.id)
          }
        }else{
          this.profilesAvailable.push(profile.id)
        }
      }, this);
    }
  }
}
</script>

<style>

</style>