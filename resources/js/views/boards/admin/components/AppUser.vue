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
                    :menus="itemsMenu" 
                    iconColor="white" 
                    btnColor="transparent" 
                    :item="agency"
                    @onItemMenu="onItemMenu($event)"
                  ></item-menu>
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
        ></v-select>
      </v-col>
    </v-row>

    <v-subheader>
      <v-row>
        <v-col>Ganancias</v-col>
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
      </v-row>

    </v-card-text>

    <v-dialog v-model="tableDetailDialog" scrollable  width="98vw">
      <TableDetail v-if="tableDetailDialog" @closeDialog="closeDialog($event)" />
    </v-dialog> 

    
  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
import TableDetail from '@views/table/TableDetail'
export default {

  mixins: [AppData],

  components:{
    TableDetail
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
    itemsMenu: [
      { action: 'importProfile', icon: 'mdi-account-multiple-plus', label: 'Importar Nuevos Perfiles', iconColor: 'green' },
      { action: 'importProfilePhoto', icon: 'mdi-camera-account', label: 'Importar Fotos Perfiles', iconColor: 'green' },
      { action: 'showTablesDetail', icon: 'mdi-sitemap', label: 'Organigrama', iconColor: 'blue' },

      
    ],
  }),

  methods:{
    getdata()
    {
      this.getResource('comission/detail').then( data => {
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

      this.$set(this.progress, key, { id: agency.id, name: agency.name, token: agency.token, amolatina_id: agency.amolatina_id , day: {points: 0}, month: {points: 0} })
      
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
      return ( value * 100 / goal > 100) ? 100 :  value * 100 / goal
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

    closeDialog(reload)
    {

      this.tableDetailDialog   = false

    },

    
  }
}
</script>

<style>

</style>