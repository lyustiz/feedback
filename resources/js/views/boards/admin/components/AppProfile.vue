<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader class="title">
      <v-row no-gutters>
       <v-col>Perfiles</v-col>
       <v-col>
         <v-select
          v-model="agency"
          label="Agencias"
          item-text="name"
          item-value="id"
          :items="agencies"
          :loading="loading"
          hide-details
          filled
          outlined
          dense
          clearable
          ></v-select>
       </v-col>
       <v-col cols="auto">
         <v-btn icon color="success" @click="list()" :loading="loading"><v-icon>mdi-reload</v-icon></v-btn>
         <v-btn icon color="red" @click="getProgress()" :loading="loading"><v-icon>mdi-reload</v-icon></v-btn>
         </v-col>
      </v-row> 
      
    </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 
        <v-list-item v-for="profile in showProfiles" :key="profile.id" > 
          <v-list-item-avatar color="blue" size="60">
            <v-tooltip bottom color="blue">
              <template v-slot:activator="{ on, attrs }">
                <v-img v-on="on" v-bind="attrs" :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img>
              </template>
              <span>{{profile.amolatina_id}}</span>
            </v-tooltip>
          </v-list-item-avatar>
          <v-list-item-content>
              <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                    <v-tooltip bottom color="blue">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ (profile.profile_progress) ? formatNumber(profile.profile_progress.points_day) : 0 }}  /  {{ profile.month || 600}}</span>
                    </template>
                    <span>Meta Dia</span>
                    </v-tooltip>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                    <v-tooltip bottom color="green">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ (profile.profile_progress) ? formatNumber(profile.profile_progress.points_month) : 0 }}  /  {{ profile.month || 2000}}</span>
                    </template>
                    <span>Meta Mes</span>
                    </v-tooltip>
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                    <v-progress-linear
                    :value="( (profile.profile_progress) ? profile.profile_progress.points_day*100/900 : 0 ) "
                    color="blue"
                    height="8"
                    class="mb-2 mt-1"
                    ></v-progress-linear>
                </v-col>
                <v-col>
                    <v-progress-linear
                    :value="( (profile.profile_progress) ? profile.profile_progress.points_month*100/2000 : 0 )"
                    color="green"
                    height="8"
                    class="mb-2 mt-1"
                    ></v-progress-linear>
                </v-col>
              </v-row>
              
              </v-list-item-title>
              <v-list-item-subtitle class="pt-2">
              <v-row>
                  <v-col>{{profile.name}}</v-col>
                  <v-col>
                    <v-tooltip bottom color="orange">
                    <template v-slot:activator="{ on, attrs }">
                      <v-progress-linear
                        v-on="on" v-bind="attrs"
                        :value="( (profile.profile_progress) ? profile.profile_progress.writeoff_day * (-1) : 0)"
                        color="orange"
                        height="8"
                        class="mb-2 mt-1"
                      ></v-progress-linear>
                    </template>
                    <span>writeoff dia {{ (profile.profile_progress) ? profile.profile_progress.writeoff_day : 0}}</span>
                    </v-tooltip>
                  </v-col>
                  <v-col>
                    <v-tooltip bottom color="red">
                    <template v-slot:activator="{ on, attrs }">
                      <v-progress-linear
                        v-on="on" v-bind="attrs"
                        :value="( (profile.profile_progress) ? profile.profile_progress.writeoff_month * (-1) : 0)"
                        color="red"
                        height="8"
                        class="mb-2 mt-1"
                      ></v-progress-linear>
                    </template>
                    <span>writeoff mes {{(profile.profile_progress) ? profile.profile_progress.writeoff_month : 0}}</span>
                    </v-tooltip>
                  </v-col>
              </v-row>
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon>
                <v-icon class="mt-6">mdi-dots-vertical</v-icon>
            </v-list-item-icon>
        </v-list-item>
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
    agencies()
    {
      return this.$store.getters['getAgencyManage']
    },
    showProfiles()
    {
      return (this.agency ) ? this.profiles.filter(profile => profile.agency_id == this.agency) : this.profiles 
    },
  },

  data: () => ({
    agency: null,
    profiles: []
  }),

  methods: {

    list() {
      this.getResource('profile').then( data => {
        this.profiles = data
      })
    },

    getProgress()
    {
      this.getResource('profileProgress/fill').then( data => {
        console.log(data)
      })
    },

  }
}
</script>

<style>

</style>