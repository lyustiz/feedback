<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader class="title">
        <v-row>
            <v-col cols="auto">
                Perfiles
            </v-col>
            <v-col >
            </v-col>
            <v-col cols="auto">
                <v-btn :color="(active) ? 'error' : 'success'" @click="active=!active">
                  <v-icon dark> {{ (active) ? 'mdi-stop' : 'mdi-play'}}</v-icon>
                   {{ (active) ? 'pausar' : 'Iniciar' }} 
                </v-btn>
            </v-col>
        </v-row>
        

    </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 

        <v-list-item-group
          v-model="profile"
          color="green"
        >
        <v-list-item v-for="profile in profiles" :key="profile.id" :value="profile" > 
          <v-list-item-avatar color="blue" size="60">
            <v-img :src="`/images/profiles/${profile.photo || 'nophoto'}.80x80.thumb-fd`" ></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
              <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                  {{ profile.day || 0 }}  /  {{ profile.month || 0}}
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                  3000
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                  <v-progress-linear
                  :value="profile.day*100/profile.month || 50"
                  color="blue"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
              </v-row>
              
              </v-list-item-title>
              <v-list-item-subtitle class="pt-2">
                <v-row>
                  <v-col>{{profile.name}}</v-col>
                  <v-col cols="auto">
                    <v-icon :color="(active) ? 'green' : 'red'" size="14"> 
                      {{(active) ? 'mdi-checkbox-blank-circle' : 'mdi-checkbox-blank-circle-outline'}}
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
  },

  computed: {
    profile:
        {
            get() {
                return this.$store.getters['getProfile']
            },
            set(profile) {
                this.$store.commit('setProfile', profile)
            }
        },
  },

  data: () => ({
    profiles: [],
    profileSelected:null,
    active: false
  }),

  methods: {

    list() {
        this.getResource(`profile/user/${this.userId}`).then( data => {
          this.profiles = data
        })
    },

    setProfile(profile)
    {
      this.$store.commit('setProfile', profile)
    }
  }
}
</script>

<style>

</style>