<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-text>
      <v-row>
        <v-col>
          <v-list-item> 
              <v-list-item-avatar size="70">
                  <v-icon color="grey" size="70">mdi-account-circle</v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                  <v-list-item-subtitle class="title-section"> {{user.name}}</v-list-item-subtitle>
                  <v-list-item-title>{{ role.name }}</v-list-item-title>
              </v-list-item-content>
              <v-list-item-icon>
                  <item-menu 
                    :menus="gralMenu" 
                    iconColor="white" 
                    btnColor="transparent" 
                    :item="agency"
                    @onItemMenu="onItemMenu($event)"
                  ></item-menu>
              </v-list-item-icon>
          </v-list-item>
        </v-col>
      </v-row>

    <v-row dense> 
      <v-col >
        <v-select
          v-model="agency"
          label="Agencias"
          item-text="name"
          :items="agencies"
          :loading="loading"
          hide-details
          outlined
          filled
          dense
          return-object
        ></v-select>
      </v-col>
      <v-col cols="auto">
        <item-menu 
          :menus="agencyMenu" 
          iconColor="white" 
          btnColor="transparent" 
          :item="agency"
          @onItemMenu="onItemMenu($event)"
          icon-color="primary"
        ></item-menu>
      </v-col>
    </v-row>

    <v-subheader>
      <v-row>
        <v-col>Ganancias</v-col>
        <v-col cols="auto"><v-icon color="red" small @click="rebuilMonth($event)">mdi-calendar-refresh</v-icon></v-col>
        <v-col cols="auto"><v-icon  small @click="getdata($event)">mdi-home-search-outline</v-icon></v-col>
        
<!--         <v-col cols="auto"><v-icon  small @click="getCuratorsCommision($event)">mdi-home-search-outline</v-icon></v-col>
 -->        <v-col cols="auto"><v-icon  small @click="updateTotalsCommision()" :disabled="progress.length<1">mdi-reload</v-icon></v-col>
      </v-row>
    </v-subheader>
    

      <v-row v-for="progres in progress" :key="progres.id" dense>
        <v-col class="caption">
          {{progres.name}}
        </v-col>
       <v-col>
          <v-progress-linear height="15" :value="getPercent(progres.day.points, 1000)" :indeterminate="loading">
            {{ formatNumber(progres.day.points) || 0}}
          </v-progress-linear>
        </v-col>
        <v-col>
          <v-progress-linear color="green" height="15" :value="getPercent(progres.month.points, 30000)" :indeterminate="loading">
            {{ formatNumber(progres.month.points) || 0}}
          </v-progress-linear>
        </v-col>
        <v-col cols="auto" class="pa-0">

          <v-tooltip bottom :color="goal.goal_type.color" v-for="goal in progres.agency_goal" :key="goal.id">
            <template v-slot:activator="{ on, attrs }">
              <v-progress-circular 
                v-on="on"
                v-bind="attrs"
                :value="getPercent(progres.month.points, goal.value)" 
                :size="18" 
                :color="goal.goal_type.color" 
                class="ml-1 pa-0" 
                width="6">
                <v-icon color="success" v-if="getPercent(progres.month.points, goal.value) >= 100">mdi-check-circle-outline</v-icon>
              </v-progress-circular>
            </template>
              <span class="indigo--text font-weight-bold">{{goal.goal_type.name}} {{formatNumber(progres.month.points)}} / {{formatNumber(goal.value)}} ({{formatNumber(getPercent(progres.month.points, goal.value))}}%)</span>
          </v-tooltip>
        </v-col>
      </v-row>

      <v-row dense>
        <v-col class="caption">
         Total
        </v-col>
       <v-col>
          <v-progress-linear height="15" color="blue darken-1" :value="getPercent(totals.day.points, 2000)" :indeterminate="loading">
            {{ formatNumber(totals.day.points) || 0}}
          </v-progress-linear>
        </v-col>
        <v-col>
          <v-progress-linear color="green darken-1" height="15" :value="getPercent(totals.month.points, 60000)" :indeterminate="loading">
            {{ formatNumber(totals.month.points) || 0}}
          </v-progress-linear>
        </v-col>

        <v-col cols="auto" class="pa-0">
          <div class="fill-total"></div>
        </v-col>
        
      </v-row>

    </v-card-text>

    <v-dialog v-model="tableDetailDialog" scrollable  width="98vw">
      <TableDetail v-if="tableDetailDialog" @closeDialog="closeDialog($event)" />
    </v-dialog> 

    <v-dialog v-model="rebuildPresenceDialog" scrollable persistent width="280">
      <Rebuilpresence v-if="rebuildPresenceDialog" @closeDialog="closeDialog($event)" />
    </v-dialog> 

    <v-dialog v-model="agencyGoalDialog" scrollable persistent width="400">
      <AgencyGoal v-if="agencyGoalDialog" :agency="agency" @closeDialog="closeDialog($event)" />
    </v-dialog> 

  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
import TableDetail from '@views/table/TableDetail'
import Rebuilpresence from '@views/userPresence/components/RebuildPresence.vue'
import AgencyGoal from '@views/agency/AgencyGoal.vue'
export default {

  mixins: [AppData],

  components:{
    TableDetail,
    Rebuilpresence,
    AgencyGoal
  },

  mounted()
  {
    this.agency = this.agencies[0]

    for (const agency of this.agencies) {
      this.getTotalsCommisions(agency)
    }
    
  },

  computed: 
  {
    agencies()
    {
      return this.$store.getters['getAgencyManage']
    },

    user()
    {
      return this.$store.getters['getUser']
    },

    role()
    {
      return this.$store.getters['getRole']
    },

    totals()
    {
      let totals = { day:{ points: 0 }, month: { points: 0 } }
      this.progress.forEach(progres => {
        totals.day.points += (progres.day.points) ? progres.day.points : 0
        totals.month.points += (progres.month.points) ? progres.month.points : 0
      });
      return totals
    }

  },

  data: () => ({
    agency: null,
    progress: [],
    curatorDialog: false,
    tableDetailDialog: false,
    rebuildPresenceDialog: false,
    agencyGoalDialog: false,
    agencyMenu: [
      { action: 'showAgencyGoal', icon: 'mdi-flag-checkered', label: 'Metas Agencias', iconColor: 'amber' },
      { action: 'importProfile', icon: 'mdi-account-multiple-plus', label: 'Importar Nuevos Perfiles', iconColor: 'green' },
      { action: 'importProfilePhoto', icon: 'mdi-camera-account', label: 'Importar Fotos Perfiles', iconColor: 'green' },
    ],
    gralMenu: [
      { action: 'showTablesDetail', icon: 'mdi-sitemap', label: 'Organigrama', iconColor: 'blue' },
      { action: 'rebuildPrecense', icon: 'mdi-calendar-sync', label: 'Recalcular Progreso', iconColor: 'amber' },
    ],
  }),

  methods:{
    getdata()
    {
      this.getResource('comission/detail').then( data => {
        console.log(data)
      })

    },

    rebuilMonth()
    {
      this.getResource('comission/month').then( data => {
        console.log(data)
      })
    },

    getCuratorsCommision()
    {
      this.curatorDialog = true
    },

    getTotalsCommisions(agency){

      if(key > this.agencies.length) return
       
      let key = this.progress.length

      this.$set(this.progress, key, { 
                                     id: agency.id, 
                                     name: agency.name, 
                                     token: agency.token, 
                                     amolatina_id: agency.amolatina_id,
                                     agency_goal: agency.agency_goal,
                                     day: {points: 0}, 
                                     month: {points: 0} })
      
      this.getResource(`agency/totals?type=day&token=${agency.token}&amolatina_id=${agency.amolatina_id}`).then( response => {
        this.progress[key].day = response.data
      })

      this.getResource(`agency/totals?type=month&token=${agency.token}&amolatina_id=${agency.amolatina_id}`).then( response => {
        this.progress[key].month = response.data
      })
    },

    updateTotalsCommision()
    {
      for (const [key, progres] of this.progress.entries()) {
        this.getResource(`agency/totals?type=day&token=${progres.token}&amolatina_id=${progres.amolatina_id}`).then( response => {
          this.progress[key].day = response.data
        })

        this.getResource(`agency/totals?type=month&token=${progres.token}&amolatina_id=${progres.amolatina_id}`).then( response => {
          this.progress[key].month = response.data
        })
      }
    },

    getPercent(value, goal)
    {
      if(!goal)  return 0
      if(!value) return 0
      return ( ((value * 100) / goal) > 100) ? 100 :  (value * 100) / goal
    },

    importProfile(agency)
    {
      if(!agency) return
      this.getResource(`profile/import/agency/${agency.id}`).then(data =>{
        this.showMessage(data.msj);
      })
    },

    importProfilePhoto()
    {
      this.getResource(`profile/import/photo`).then(data =>{
        this.showMessage(data.msj);
      })
    },

    showTablesDetail()
    {
      this.tableDetailDialog = true
    },

    showAgencyGoal()
    {
      this.agencyGoalDialog = true
    },

    rebuildPrecense(){
      this.rebuildPresenceDialog = true
    },

    closeDialog(reload)
    {
      this.tableDetailDialog     = false
      this.rebuildPresenceDialog = false
      this.agencyGoalDialog      = false
    },

    
  }
}
</script>

<style>
.fill-total{
  display: block;
  width: 4.1rem;
}
</style>