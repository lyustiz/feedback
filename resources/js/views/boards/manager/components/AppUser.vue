<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)" v-if="user">
        <v-card-title class="subtitle-2">
            <v-row dense>
                <v-col>{{user.name}} ({{user.username}}) <v-btn icon :loading="loading" small @click="list()"><v-icon>mdi-refresh</v-icon></v-btn></v-col>
                <v-col cols="auto"><v-btn icon color="success"><v-icon>mdi-dots-vertical</v-icon></v-btn></v-col>
            </v-row>
        </v-card-title>
        <v-card-text>

            <v-row>
                <v-col cols="auto">
                    <v-avatar color="blue" size="70" class="elevation-2">
                        <v-img :src="`/storage/photo/operator/${user.photo || 'nophoto.png'}`" ></v-img>
                    </v-avatar>
                </v-col>
                <v-col>
                  <v-row no-gutters>
                     <v-col cols="5" class="subtitle-2">Rol</v-col>
                    <v-col cols="7" class="font-weight-light">{{user.role.name}}</v-col>
                    <v-col cols="5"  class="subtitle-2">Turno</v-col>
                    <v-col cols="7" class="font-weight-light">{{user.turn.name}}</v-col>
                  </v-row>
                </v-col>
            </v-row>

          
    <v-subheader>
      <v-row>
        <v-col>Ganancias</v-col>
       <v-col cols="auto"><v-icon  small @click="updateTotalsCommision()" :disabled="progress.length<1">mdi-reload</v-icon></v-col>
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

    

  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
import TableDetail from '@views/table/TableDetail'

export default {

  mixins: [AppData],

  components:{
    TableDetail,
    
  },

  mounted()
  {
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
    reportPayDialog: false,
    gralMenu: [
      { action: 'showPayReport', icon: 'mdi-clipboard-text-outline', label: 'Reporte Pago', iconColor: 'info' },
      { action: 'showTablesDetail', icon: 'mdi-sitemap', label: 'Organigrama', iconColor: 'blue' },
    ]
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


    showTablesDetail()
    {
      this.tableDetailDialog = true
    },

    closeDialog(reload)
    {
      this.tableDetailDialog     = false
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