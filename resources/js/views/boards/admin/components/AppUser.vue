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
                  <v-icon>mdi-dots-vertical</v-icon>
              </v-list-item-icon>
          </v-list-item>
        </v-col>
      </v-row>

    <v-row>
      <v-col cols="12">
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
          @change="getTotalsCommisions($event)"
        ></v-select>
      </v-col>
    </v-row>

    <v-subheader>
      <v-row>
        <v-col>Ganancias</v-col>
<!--         <v-col cols="auto"><v-icon  small @click="getCuratorsCommision($event)">mdi-home-search-outline</v-icon></v-col>
 -->        <v-col cols="auto"><v-icon  small @click="getTotalsCommisions($event)">mdi-reload</v-icon></v-col>
      </v-row>
    </v-subheader>
    

     <v-row >
      <v-col cols="2" class="mt-3">
        Dia
      </v-col>
      <v-col>
        <v-row no-gutters v-if="progress.day"> 
          <v-col cols="12"> {{progress.day.profit || 0}} / 800</v-col>
          <v-col cols="12">
            <v-progress-linear height="10" :value="getPercent(progress.day.profit, 800)" :indeterminate="loading"></v-progress-linear>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row >
      <v-col cols="2" class="mt-3">
        Mes
      </v-col>
      <v-col>
        <v-row no-gutters v-if="progress.day"> 
          <v-col cols="12"> {{progress.month.profit || 0}} / 15000</v-col>
          <v-col cols="12">
            <v-progress-linear height="10" :value="getPercent(progress.month.profit, 15000)" :indeterminate="loading"></v-progress-linear>
          </v-col>
        </v-row>
      </v-col>
    </v-row>



        <!-- <v-col class="text-center">
          <v-subheader>citas</v-subheader>
          <v-progress-circular
              :rotate="-90"
              :size="80"
              :width="8"
              :value="35"
              color="blue">
              35
          </v-progress-circular>
        </v-col>  
        <v-col class="text-center">
          <v-subheader>citas</v-subheader>
          <v-progress-circular
              :rotate="-90"
              :size="80"
              :width="8"
              :value="12"
              color="green">
              12
          </v-progress-circular>
        </v-col>  
        <v-col class="text-center">
          <v-subheader>citas</v-subheader>
          <v-progress-circular
              :rotate="-90"
              :size="80"
              :width="8"
              :value="10"
              color="red">
              10
          </v-progress-circular>
        </v-col>  --> 
    </v-card-text>
  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
export default {

  mixins: [AppData],

  mounted()
  {
    this.agency = this.agencies[0]
    this.getTotalsCommisions()
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
    }
  },

  data: () => ({
    agency: null,
    progress: {
      day:   null,
      month: null,
    },
    curatorDialog: false
  }),

  methods:{
    getdata()
    {
      this.getResource('data').then( data => {
        console.log(data)
      })

    },

    getCuratorsCommision()
    {
      this.curatorDialog = true
    },

    getTotalsCommisions(){


      this.progress.day =  {
          "value":  0,
          "points": 0,
          "profit": 0,
          "share":  0
      }

      this.progress.month =  {
          "value":  0,
          "points": 0,
          "profit": 0,
          "share":  0
      }

        this.getResource(`agency/totals?type=day&token=${this.agency.token}&amolatina_id=${this.agency.amolatina_id}`).then( response => {
          this.progress.day = response.data
        })

        this.getResource(`agency/totals?type=month&token=${this.agency.token}&amolatina_id=${this.agency.amolatina_id}`).then( response => {
          this.progress.month = response.data
        })
    },

     getPercent(value, goal)
      {
        if(!goal)  return 0
        if(!value) return 0
        return ( value * 100 / goal > 100) ? 100 :  value * 100 / goal
      }
  }
}
</script>

<style>

</style>