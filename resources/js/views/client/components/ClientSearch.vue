<template>

    <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)" min-height="91vh">
        <v-card-title class="py-1 px-3 ">

          <v-row dense>
            <v-col cols="auto">
              <v-menu offset-y :close-on-content-click="false" max-width="300px" v-model="searchMenu">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn small icon color="primary" dark v-bind="attrs" v-on="on">
                    <v-icon>mdi-account-search</v-icon>
                  </v-btn>
                </template>
                <SearchBox @onSearch="searhClient($event)"></SearchBox>
              </v-menu>
            </v-col>
            <v-col  class="subtitle-2 pt-3" @click="searchMenu=true">
              {{criteria}}
            </v-col>
            <v-col cols="auto">
               <item-menu 
                  :menus="itemsMenu" 
                  iconColor="white" 
                  btnColor="transparent" 
                  :item="{}"
                  @onItemMenu="onItemMenu($event)"
              ></item-menu>
            </v-col>
          </v-row>

          
        </v-card-title>
        <v-card-text class="pt-0 clients-container custom-scroll">
            <v-list subheader dense color="rgba(0,0,0,0.4)" class="rounded-lg">
              <v-list-item-group
                v-model="clientsSelected"
                multiple
                color="green"
              >
                <ClientCard v-for="client in clients" :key="client.id" :client="client"></ClientCard>
              </v-list-item-group> 
              
            </v-list>
            <v-overlay color="rounded" absolute :opacity="0.4" :value="loading">
                <v-icon dark size="40" class="mdi-spin">mdi-loading</v-icon>
            </v-overlay>
        </v-card-text>
    </v-card>
  
</template>

<script>
import AppData from '@mixins/AppData' 
import AppDataAmolatina from '@mixins/AppDataAmolatina' 
import ClientCard from './ClientCardSearch'
import SearchBox from './SearchBox'

export default {
 
    mixins:[ AppDataAmolatina, AppData],

    computed:
    {
      allSelected()
      {
        return (this.clients.length == this.clientsSelected.length )
      },
    },

    components:{
        ClientCard,
        SearchBox,
    },

    data: () => ({
        criteria: 'Buscar Clientes',
        clients:   [],
        clientsSelected: [],
        searchMenu: false,
        itemsMenu: [
          { action: 'getTag',    icon: 'mdi-time', label: 'tag', iconColor: 'amber' },
          { action: 'clear',     icon: 'mdi-reload', label: 'Limpiar', iconColor: 'amber' },
          { action: 'getData',   icon: 'mdi-plus', label: 'Data Prueba', iconColor: 'green' },
          { action: 'sendCard',  icon: 'mdi-mail', label: 'Enviar Carta', iconColor: 'info' },
        ],
    }),

    methods: {

       getTag() {
          let tag =  (performance.now() + performance.timeOrigin).toString().replace(".", "");
          console.log(tag)
          return tag;
        },

        selectAll(active)
        {
          if(this.clients.length < 1) return
          if(active)
          {
            this.clientsSelected = this.clients.map( client => client.id )
          } else {
             this.clientsSelected = []
          }
          
        },

        getCountries(){
            this.getResource('country').then(data =>{
                this.countries = data
            })
        },

        clear()
        {
            this.clients =  []
        },

        async sendCard()
        {
         
         this.getResource('data/card').then(data =>{
           console.log(data)
         })
         
         /*  https://api.amolatina.com/datetime

          {
          "value": "2021-05-11T18:52:58.5247349Z"
          } */
          
       

          // chat  let url = `dialogs/messages/${clientID}:${profileID}`;

           
/* 
          let tag = this.getTag();

          let payload = JSON.parse(`{"tag":${tag},"text":"hi","cover":"1f6656","subject":"test","attachments":[]}`)
 */
          


           

         /*  try {
            let url = 'datetime'
            let {value} = await this.getDataAmolatina(url)


            let clientID  = 6741397642
            let profileID = 81833668531

            url = `dialogs/letters/${clientID}/${profileID}`;
              
            this.sendMessageAmolatina(url,payload ).then(resp =>{
            console.log(resp)
          })

          } catch (error) {
              this.showEror(error)
          }  */


        },


        async searhClient(params) {

          
          this.searchMenu = false

          if(!params) return

          this.criteria = `${(params.country.code).toUpperCase()} -  ${params.sex.name} - ${params.ageFrom}|${params.ageTo} `

          this.clients = []

          let results = params.results

          let url = '/users/79602433731/search/params'

          try {
              let {token} = await this.getDataAmolatina(url)

              url = `users/79602433731/gateway?country=${params.country.code}&gender=${params.sex.to}&maxage=${params.ageTo}&minage=${params.ageFrom}&omit=0&preferences.gender=${params.sex.from}&search-token=${token}&select=${results}&sort=7`

              this.getDataAmolatina(url).then(data =>{
                  console.log(data)
                  this.clients = data
                  this.getOfflineClient(data)
              })

          } catch (error) {
              this.showEror(error)
          } 

        },

        getOfflineClient(clients)
        {
          this.offlineClients = clients.filter( client => client.status == 1)
        }

    }
}
</script>

<style>
.clients-container{
  height: 74vh;
  overflow-y: auto;
}
</style>