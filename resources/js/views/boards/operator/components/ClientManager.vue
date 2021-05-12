<template>

    <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)" min-height="91vh">
        <v-card-title >

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

            <v-col cols="12">

    
               <ProfileCard></ProfileCard>
               <!--  <v-col cols="auto">
                  <v-checkbox color="blue" label="All" :value="allSelected" hide-details class="shrink mr-2 mt-0" @change="selectAll($event)"></v-checkbox>
                </v-col> -->
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
import ProfileCard from './ProfileCard'
import ClientCard from './ClientCard'
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
        ProfileCard,
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

        getData()
        {
            this.clients = [
            {
                "birthday": {
                "age":   21, "birth-date": "2000-04-09T00:00:00Z",  "upcoming": false, "zodiac": "ari"
                },
                "description": {
                "eye": "bro","hair": "black","marital-status": "nev"
                },
                "name": "laura","gender": "fem","id": "77244554331","location": {
                "city": "Bogotá","country": "CO"
                },"status": 2,"thumbnail": "118247a8ffaff1f7","thumbnails-recommended": {
                "new": [],"top": [
                    {
                    "thumbnail": "118247a8ffaff1f7","rate": 100
                    }
                ]
                },"about": "I tease,I attract and I get. Yeah! The acquaintance with me is going to be mad! Dreamy and happy! Yes,I am actually a miracle,a shy miracle,of course.But it is a secret! I easily get from life everything I want.Woman with intent never to stop exploration and experience of the tastiest and the most pleasant moments of life is who I am. Honestly,I don’t even remember the day when I wanted nothing. The further I go,the more interesting things happen. Am I too passionate? Yes! The passion to life tries to go out inside me,so I am insatiable. New day is new activity,new emotion. I love when dreams come true and when people around me are happy. The whole world of feelings will come directly to my man. I think it’s high time! The main thing is to handle with the power of desires...but I’ll help!\n\n","photos": [
                "296b242aee58695d","118247a8ffaff1f7","81efe0884565ef37","bdccd7e98e24a451"
                ],"devices": [
                "cam"
                ],"rank": 100,"tags": [
                "presence.exists","dialogs.messages.promoter","presence.webapp","dialogs.automation.production.introductory.exists",
                "presence.cam"
                ]
          },
          {
            "birthday": {
              "age": 46,"birth-date": "1974-06-12T00:00:00Z","upcoming": false,"zodiac": "gem"
            },"description": {
              "eye": "haz","hair": "brown","marital-status": "div"
            },"name": "Claudy","gender": "fem","id": "119104124","location": {
              "city": "Cali","country": "CO"
            },"status": 1,"thumbnail": "3f39dfa936a0708a","thumbnails-recommended": {
              "new": [
                {
                  "thumbnail": "3f39dfa936a0708a","rate": 100
                }
              ],"top": [
                {
                  "thumbnail": "3f39dfa936a0708a","rate": 100
                }
              ]
            },"about": "Hello I'm Claudy Maecha. A spiritual woman dedicated sincere kind passionate reasonable intelligent and honest. I identify myself as a safe and patient woman with a heart Young woman full of illusions very stable and firm with my decisions responsible with my actions direct in my words and loyal I have a dreamy potential with my feet on the ground and Thoughts to heaven I believe in love I believe in life I believe in the good wife that someday I can be I am always smiling waiting for the blessings for my life. I can describe my interests as a way to feel alive: sing write art sigh believe love eat lol sport learn teach nature and more ... If you are interested in me please write me no I am a woman of games and I am old enough to know if we can create something real ... What about you ?","devices": [
              "cam"
            ],"rank": 100,"tags": [
              "presence.webapp","dialogs.automation.production.invitation.exists","presence.mobileapp","dialogs.automation.production.introductory.exists","presence.cam","dialogs.messages.promoter","presence.exists"
            ]
          }, 
          {
            "birthday": {
              "age": 29,"birth-date": "1992-01-05T00:00:00Z","upcoming": false,"zodiac": "cap"
            },"description": {
              "eye": "gre","hair": "black","marital-status": "div"
            },"name": "julieht","gender": "fem","id": "81742636931","location": {
              "city": "Bogotá","country": "CO"
            },"status": 1,"thumbnail": "72c58208d73eb884","thumbnails-recommended": {
              "new": [
                {
                  "thumbnail": "72c58208d73eb884","rate": 100
                }
              ],"top": [
                {
                  "thumbnail": "72c58208d73eb884","rate": 100
                }
              ]
            },"about": "My character is sugar with glass. I am sincere honest and fair. Hot-tempered and fiery. At the same time affectionate and tender. A bit old-fashioned manners but at the same time modern. And unique of courseI value loyalty and always stay true to my time. My life is filled with difficulties that I can always overcome and you know what? I will be there and we will surely do it believe me?\n","devices": [
              "cam"
            ],"rank": 100,"tags": [
              "dialogs.automation.production.introductory.exists","dialogs.automation.production.invitation.exists","dialogs.messages.promoter","presence.cam","presence.exists","presence.mobileapp","presence.webapp"
            ]
          }
          ]
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

          return 

          let tag = this.getTag();

          let payload = JSON.parse(`{"tag":${tag},"text":"hi","cover":"1f6656","subject":"test","attachments":[]}`)

          


           

          try {
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
          } 


        },


        async searhClient(params) {

          this.searchMenu = false

          if(!params) return

          this.criteria = `${params.country.name} -  ${params.sex.name} - ${params.ageFrom}|${params.ageTo} `

          this.clients = []

          let url = '/users/79602433731/search/params'

          try {
              let {token} = await this.getDataAmolatina(url)

              url = `users/79602433731/gateway?country=${params.country.code}&gender=${params.sex.to}&maxage=${params.ageTo}&minage=${params.ageFrom}&omit=0&preferences.gender=${params.sex.from}&search-token=${token}&select=15&sort=7`
              


              this.getDataAmolatina(url).then(data =>{
                  console.log(data)
                  this.clients = data
                  this.getOfflineClient(data)
              })

          } catch (error) {
              this.showEror(error)
          } 
          /*  this.getDataAmolatina(url).then(data => {
               
           }) */
/* 
           https://api.amolatina.com/users/79602433731/search/params

           https://api.amolatina.com/users?country=CO&filter=photos&gender=fem&omit=0&preferences.gender=mal&q=1&search-token=5f0fa684e06e214fd04daf2fe07ca6a9&select=15&sort=7

            country: CO
            filter: photos
            gender: fem
            omit: 0
            preferences.gender: mal
            q: 1
            search-token: 5f0fa684e06e214fd04daf2fe07ca6a9
            select: 15
            sort: 7 */
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