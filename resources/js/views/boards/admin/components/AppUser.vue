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
          <v-col cols="12"> Total: {{progress.day.points || 0}} |  Profit: {{progress.day.profit || 0}}</v-col>
          <v-col cols="12">
            <v-progress-linear height="10" :value="getPercent(progress.day.points, 2000)" :indeterminate="loading"></v-progress-linear>
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
          <v-col cols="12"> Total: {{progress.month.points || 0}} | Profit: {{progress.month.profit || 0}}</v-col>
          <v-col cols="12">
            <v-progress-linear height="10" :value="getPercent(progress.month.points, 30000)" :indeterminate="loading"></v-progress-linear>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    </v-card-text>

    <v-dialog v-model="tableDetailDialog" scrollable  width="80vw">
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
    curatorDialog: false,
    tableDetailDialog: false,
    itemsMenu: [
      { action: 'importProfile', icon: 'mdi-account-multiple-plus', label: 'Importar Nuevos Perfiles', iconColor: 'green' },
      { action: 'importProfilePhoto', icon: 'mdi-camera-account', label: 'Importar Fotos Perfiles', iconColor: 'green' },
      { action: 'showTablesDetail', icon: 'mdi-view-dashboard-outline', label: 'Organigrama', iconColor: 'blue' },

      
    ],
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