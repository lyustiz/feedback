<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>
        <v-row class="title">
            <v-col cols="auto" >
              <v-icon left>mdi-table-furniture</v-icon>  Mesa
            </v-col>
            <v-col cols="auto" > <v-btn icon :loading="loading"><v-icon  small @click="list()">mdi-reload</v-icon> </v-btn></v-col>
            <v-spacer></v-spacer>
        </v-row>

    </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 

        <v-list-item-group
          :value="profiles"
          multiple
        >
        <v-list-item v-for="profile in profiles" :key="profile.id" :value="profile" inactive >
          <v-list-item-avatar color="blue" size="60">
            <v-img :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img> 
          </v-list-item-avatar>
          <v-list-item-content>
              <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                    <v-tooltip bottom color="blue">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ (profile.presence) ? formatNumber(profile.presence.bonus) || 0 : 0 }} </span>
                    </template>
                    <span>Ganacias Sesion</span>
                    </v-tooltip>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                    <v-tooltip bottom color="red">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ (profile.presence) ? parseInt(profile.presence.writeoff || 0) : 0 }}</span>
                    </template>
                    <span>Perdidas Sesion</span>
                    </v-tooltip>
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                  <v-progress-linear
                  :value="(profile.presence) ? formatNumber(profile.presence.bonus) || 0 : 0 "
                  color="blue"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
               <v-col>
                  <v-progress-linear
                  :value="(profile.presence) ? parseInt(profile.presence.writeoff || 0) : 0"
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
            <v-list-item-icon class="pt-4">
              
              <v-btn x-small fab color="red" @click="stopPresence(profile)" v-if="profile.presence && (myProfilesStarted.includes(profile.id))" :loading="loading">
                <v-icon>mdi-stop</v-icon>
              </v-btn>

              <v-tooltip bottom color="red" v-else-if="profile.presence && (!myProfilesStarted.includes(profile.id))">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="no-drop" icon >
                    <v-icon  v-on="on" v-bind="attrs" color="red" size="32">mdi-lock</v-icon>
                  </v-btn>
                </template>
                <span><v-icon size="16" left>mdi-account</v-icon>   {{profile.presence.user.full_name}}</span>
              </v-tooltip>

              <v-btn x-small fab color="success" @click="startPresence(profile)" v-else  :loading="loading">
                <v-icon>mdi-play</v-icon>
              </v-btn>

            </v-list-item-icon>
        </v-list-item>
        </v-list-item-group>
      </v-list>
      
    </v-card-text>

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

    user(){
      return this.$store.getters['getUser']
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
      user_presence_id: null,
      token: null
    },
    isReload: null,
    dialogDetail: false,
    profile: null
  }),

  methods: {

    list() {
        this.getResource(`profile/table/${this.user.table_id}`).then( data => {
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

    startPresence(profile)
    {
      this.form.profiles_id = [profile] 

      this.storeResource('userPresence', this.form)
      .then(data => {
        this.showMessage(data.msj)
      })
      .finally( () => 
      {
        this.list()
      });
    },

    stopPresence(profile)
    {
      if(this.myProfilesStarted.length < 1 )
      {
        this.showError('No posees perfiles iniciados')
        this.list()
        return
      }

      this.form.user_presence_id = profile.presence.id
      this.updateResource('userPresence/stop/unique', this.form)
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