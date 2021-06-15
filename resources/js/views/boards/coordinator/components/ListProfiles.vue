<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>
        <v-row class="title">
            <v-col>
               Perfiles
            </v-col>
            <v-col cols="auto" > <v-btn icon :loading="loading"><v-icon  small @click="list()">mdi-reload</v-icon> </v-btn></v-col>
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
                      <span v-on="on" v-bind="attrs">{{ formatNumber(profile.presence_day_sum_bonus) || 0 }}  /  {{ profile.user_profile_assigned.goal_day || 0 }}</span>
                    </template>
                    <span>Ganacias Dia</span>
                    </v-tooltip>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                    <v-tooltip bottom color="red">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ parseInt(profile.presence_day_sum_writeoff || 0)}}</span>
                    </template>
                    <span>Perdidas Dia</span>
                    </v-tooltip>
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                  <v-progress-linear
                  :value="profile.presence_day_sum_bonus*100/(profile.user_profile_assigned.goal_day) ? profile.user_profile_assigned.goal_day : 1  || 0"
                  color="blue"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
               <v-col>
                  <v-progress-linear
                  :value="profile.presence_day_count_writeoff || 0"
                  color="red"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
              </v-row>
              
              </v-list-item-title>
              <v-list-item-subtitle class="pt-2">
                <v-row dense>

                  <v-col>{{profile.name}}</v-col>

                  <v-col cols="auto" v-if="profile.presence && !myProfilesStarted.includes(profile.id)" @click="confirmStop(profile)">
                    <list-simple-icon icon="mdi-lock-open-variant" label="Liberar Perfil" color="amber darken-3" :size="22"></list-simple-icon>
                  </v-col>

                  <v-col cols="auto" v-if="myProfilesStarted.includes(profile.id)" @click="showDetails(profile)">
                    <list-simple-icon icon="mdi-magnify" label="Detalles Puntos" color="blue darken-3" :size="22"></list-simple-icon>
                  </v-col>


                  <v-col cols="auto">
                    <v-icon :color="(profile.presence) ? 'green' : 'red'" size="20"> 
                      {{(profile.presence) ? 'mdi-checkbox-blank-circle' : 'mdi-checkbox-blank-circle-outline'}}
                    </v-icon> 
                  </v-col>

                </v-row>
              
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon class="pt-3">

              <v-tooltip bottom color="green" v-if="profile.presence && (myProfilesStarted.includes(profile.id))">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn v-on="on" v-bind="attrs" x-small fab color="green"  :loading="loading">
                    <v-icon>mdi-check</v-icon>
                  </v-btn>
                </template>
                <span>Iniciado</span>
              </v-tooltip>

              <v-tooltip bottom color="red" v-else-if="profile.presence && (!myProfilesStarted.includes(profile.id))">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="no-drop" icon >
                    <v-icon  v-on="on" v-bind="attrs" color="red" size="32">mdi-lock</v-icon>
                  </v-btn>
                </template>
                <span><v-icon size="16" left>mdi-account</v-icon>   {{profile.presence.user.full_name}}</span>
              </v-tooltip>

             <v-tooltip bottom color="blue" v-else>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn v-on="on" v-bind="attrs" x-small icon color="blue" :loading="loading">
                    <v-icon size="34">mdi-progress-clock</v-icon>
                  </v-btn>
                </template>
                <span>Pendiente</span>
              </v-tooltip>

            </v-list-item-icon>
            
        </v-list-item>
      </v-list>
      
    </v-card-text>
    
    <app-confirm :confirm="confirm" :title="title" :message="message" @closeConfirm="confirmation($event)"></app-confirm>
    
    <v-dialog v-model="dialogDetail" scrollable width="90vw">
       <UserPrecenseList :profile="profile" v-if="dialogDetail" @closeDialog="closeDialog()"></UserPrecenseList>
    </v-dialog>

  </v-card>
</template>

<script>
import AppData from '@mixins/AppData';
import UserPrecenseList from '@views/userPresence/components/UserPrecenseList.vue'
export default {

  mixins: [AppData],

  components:{
    UserPrecenseList
  },

  created() {
    this.list()
    this.form.token = this.token 
    this.reload()
  },

  computed: {

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
    title: null,
    confirm: false,
    message: null,
    dialogDetail: false,
    profile: null
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
    },

    confirmStop(profile)
    {
      this.title   = 'Confirmacion'
      this.message = `Desea liberar el perfil ${profile.name}`
      this.confirm = true
      this.profile = profile
    },

    confirmation(confirm){
      if(confirm){
        this.form.user_presence_id = this.profile.presence.id
        this.updateResource('userPresence/stop/unique', this.form)
        .then(data => {
          this.showMessage(data.msj)
        })
        .finally( () => 
        {
          this.list()
        });
      } 
      this.confirm = false
      this.profile = null
    },

    showDetails(profile)
    {
      this.profile = profile
      this.dialogDetail = true
    },

    closeDialog()
    {
      this.profile = null
      this.dialogDetail = false
    }
  }
}
</script>

<style>

</style>