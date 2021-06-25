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
        <v-col cols="auto"><v-icon  small @click="updateCommision($event)">mdi-home-search-outline</v-icon></v-col>
        
<!--         <v-col cols="auto"><v-icon  small @click="getCuratorsCommision($event)">mdi-home-search-outline</v-icon></v-col>
 -->        <v-col cols="auto"><v-icon  small @click="updateTotalsCommision()" :disabled="progress.length<1">mdi-reload</v-icon></v-col>
      </v-row>
    </v-subheader>
    

      <v-row v-for="progres in progress" :key="progres.id" dense>
        <v-col class="caption">
          {{progres.name}}
        </v-col>
       <v-col>
         <v-tooltip bottom color="blue">
            <template v-slot:activator="{ on, attrs }">
              <v-progress-linear height="15" :value="getPercent(progres.day.points, progres.goal_day)" :indeterminate="loading"  v-on="on"  v-bind="attrs">
                {{ formatNumber(progres.day.points) || 0}}
              </v-progress-linear>
            </template>
              <span class="font-weight-bold">Meta Dia {{progres.goal_day}}</span>
          </v-tooltip>
        </v-col>
        <v-col>

        <v-tooltip bottom color="green">
            <template v-slot:activator="{ on, attrs }">  
          <v-progress-linear color="green" height="15" :value="getPercent(progres.month.points, progres.goal_month)" :indeterminate="loading" v-on="on"  v-bind="attrs"> 
            {{ formatNumber(progres.month.points) || 0}}
          </v-progress-linear>
          </template>
              <span class="font-weight-bold">Meta Mes {{progres.goal_month}}</span>
          </v-tooltip>

        </v-col>
        <v-col cols="auto" class="pa-0">
          <div class="fill-total"></div>
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
          
            <v-tooltip bottom :color="goal.color" v-for="goal in goalType" :key="goal.id">
            <template v-slot:activator="{ on, attrs }">
              <v-progress-circular 
                v-on="on"
                v-bind="attrs"
                :value="getPercent(totals.month.points, goal.amount)" 
                :size="18" 
                :color="goal.color" 
                class="ml-1 pa-0" 
                width="6">
                <v-icon color="success" v-if="getPercent(totals.month.points, goal.amount) >= 100">mdi-check-circle-outline</v-icon>
              </v-progress-circular>
            </template>
              <span class="indigo--text font-weight-bold">{{goal.name}} {{formatNumber(totals.month.points)}} / {{formatNumber(goal.amount)}} ({{formatNumber(getPercent(totals.month.points, goal.amount))}}%)</span>
          </v-tooltip>

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

    <v-dialog v-model="agenciesGoalDialog" scrollable persistent width="400">
      <AppGoalType v-if="agenciesGoalDialog" @closeDialog="closeDialog($event)" />
    </v-dialog> 

    

  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
import TableDetail from '@views/table/TableDetail'
import Rebuilpresence from '@views/userPresence/components/RebuildPresence.vue'
import AgencyGoal from '@views/agency/AgencyGoal.vue'
import AppGoalType from '@views/goalType/AppGoalType.vue'
export default {

  mixins: [AppData],

  components:{
    TableDetail,
    Rebuilpresence,
    AgencyGoal,
    AppGoalType
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

    goalType()
    {
      return this.$store.getters['getGoalType']
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
    agenciesGoalDialog: false,
    agencyMenu: [
      { action: 'showAgencyGoal', icon: 'mdi-flag', label: 'Metas Agencia', iconColor: 'amber' },
      { action: 'showAgenciesGoal', icon: 'mdi-flag-checkered', label: 'Metas Agencias', iconColor: 'orange' },
      { action: 'importProfile', icon: 'mdi-account-multiple-plus', label: 'Importar Nuevos Perfiles', iconColor: 'green' },
      { action: 'importProfilePhoto', icon: 'mdi-camera-account', label: 'Importar Fotos Perfiles', iconColor: 'green' },
    ],
    gralMenu: [
      { action: 'showTablesDetail', icon: 'mdi-sitemap', label: 'Organigrama', iconColor: 'blue' },
      { action: 'rebuildPrecense', icon: 'mdi-calendar-sync', label: 'Recalcular Progreso', iconColor: 'amber' },
    ],
  }),

  methods:{
    updateCommision()
    {
      if(confirm('forzar actualizacion de facturacion'))
      {
        this.getResource('comission/detail').then( data => {
          this.showMessage('Facturacion actualizada');
        })
      }
    },

    rebuilMonth()
    {
      
      if(confirm('desea reconstruir la facturacion del Mes Actual (esto podria tomar hasta 10 min) '))
      {
        this.getResource('comission/month').then( data => {
          this.showMessage('Facturacion del mes reconstruida, favor recalcule a los operadores');
        })
      }
  
    },

    getCuratorsCommision()
    {
      this.curatorDialog = true
    },

    getTotalsCommisions(agency){
       
      let key = this.progress.length

      if(key > this.agencies.length) return

      this.$set(this.progress, key, { 
                                     key: key,
                                     id: agency.id, 
                                     name: agency.name, 
                                     token: agency.token, 
                                     amolatina_id: agency.amolatina_id,
                                     goal_day: agency.goal_day,
                                     goal_month: agency.goal_month,
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

    showAgenciesGoal()
    {
      this.agenciesGoalDialog = true
    },

    rebuildPrecense(){
      this.rebuildPresenceDialog = true
    },

    closeDialog(reload)
    {
      this.tableDetailDialog     = false
      this.rebuildPresenceDialog = false
      this.agencyGoalDialog      = false
      this.agenciesGoalDialog    = false
      this.agency = this.agencies[0]
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