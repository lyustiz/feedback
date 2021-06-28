<template>
 <v-card class="rounded-lg px-1 py-2" color="rgba(0,0,0,0.4)" dark>
  <v-row v-for="progres in progress" :key="progres.id" no-gutters>
        <v-col class="sm-text">
          {{progres.name}}
        </v-col>
       <v-col>
         <v-tooltip bottom color="blue">
            <template v-slot:activator="{ on, attrs }">
              <v-progress-linear height="15" class="caption" :value="getPercent(progres.day.points, progres.goal_day)" :indeterminate="loading"  v-on="on"  v-bind="attrs">
                {{ formatNumber(progres.day.points) || 0}}
              </v-progress-linear>
            </template>
              <span class="font-weight-bold">Meta Dia {{progres.goal_day}}</span>
          </v-tooltip>
        </v-col>
        <v-col>

        <v-tooltip bottom color="green">
            <template v-slot:activator="{ on, attrs }">  
          <v-progress-linear color="green" height="15" class="caption" :value="getPercent(progres.month.points, progres.goal_month)" :indeterminate="loading" v-on="on"  v-bind="attrs"> 
            {{ formatNumber(progres.month.points) || 0}}
          </v-progress-linear>
          </template>
              <span class="font-weight-bold">Meta Mes {{progres.goal_month}}</span>
          </v-tooltip>

        </v-col>
        <v-col cols="auto" class="pa-0">
          <div class="fill-agency-total"></div>
        </v-col>
      </v-row>

      <v-row  no-gutters>
        <v-col class="caption pt-1">
         Total
        </v-col>
       <v-col class="pt-1">
          <v-progress-linear height="15" color="blue darken-1" class="caption" :value="getPercent(totals.day.points, 2000)" :indeterminate="loading">
            {{ formatNumber(totals.day.points) || 0}}
          </v-progress-linear>
        </v-col>
        <v-col class="pt-1">
          <v-progress-linear color="green darken-1" class="caption" height="15" :value="getPercent(totals.month.points, 60000)" :indeterminate="loading">
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
                :size="13" 
                :color="goal.color" 
                class="pa-0 ma-0" 
                width="4">
                <v-icon color="success" v-if="getPercent(totals.month.points, goal.amount) >= 100">mdi-check-circle-outline</v-icon>
              </v-progress-circular>
            </template>
              <span class="indigo--text font-weight-bold">{{goal.name}} {{formatNumber(totals.month.points)}} / {{formatNumber(goal.amount)}} ({{formatNumber(getPercent(totals.month.points, goal.amount))}}%)</span>
          </v-tooltip>

        </v-col>
      </v-row>
    </v-card>
</template>

<script>
import AppData from '@mixins/AppData'
export default {

  mixins: [AppData],

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
      return this.$store.getters['getAgency']
    },

    goalType()
    {
      return this.$store.getters['getGoalType']
    },

    totals()
    {
      let totals = { day:{ points: 0 }, month: { points: 0 } }

      if(this.progress.length < 1) return totals

      this.progress.forEach(progres => {
        totals.day.points   += (progres.day.points) ? progres.day.points : 0
        totals.month.points += (progres.month.points) ? progres.month.points : 0
      });
      return totals
    },
  },

  data: () => ({
    progress: [],
  }),

  methods:{

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
  }
 
}
</script>

<style>
.fill-agency-total{
  display: block;
  width: 2.42rem;
}
.sm-text{
  font-size: .70rem!important;
  letter-spacing: .0333333333em!important;
  line-height: 1.25rem;
}
</style>