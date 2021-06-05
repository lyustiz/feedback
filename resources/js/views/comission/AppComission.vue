<template>

   <v-card color="transparent" flat dark min-height="93vh">
    <v-card-text>
        <v-row dense>
            <v-col cols="auto">

                <v-card color="rgba(0,0,0,0.4)" width="20vw" class="pa-2">

                    <v-subheader>Comisiones</v-subheader>

                <v-row dense>
                    <v-col>
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
                            @change="list()"
                            autofocus
                            :rules="[rules.required]"
                            ></v-select>
                    </v-col>

                    <v-col cols="12">
                        <ComissionCalendar @onUpdateDate="setDay($event)"></ComissionCalendar>
                    </v-col>
                    <v-col cols="12">
                        <v-radio-group v-model="serviceType" dense hide-details class="" row color="primary" @change="list()">
                            <v-radio
                                v-for="type in types"
                                :key="type"
                                :label="type"
                                :value="type"
                                class="mb-0 caption"
                            ></v-radio>
                        </v-radio-group>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            v-model="serviceSelected"
                            item-text="name"
                            item-value="value"
                            :items="itemsService"
                            label="Servicio"
                            multiple
                            outlined
                            filled
                            dense
                            chips
                            deletable-chips
                            single-line
                            class="ma-0"
                            color="blue"
                            @change="list()"
                        >
                            <template v-slot:selection="{ item }">
                                <v-tooltip bottom color="amber">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-chip outlined v-on="on" v-bind="attrs" small class="caption" close :color="item.color" @click:close="remove(item)">
                                            <v-icon dark v-text="item.icon"></v-icon> 
                                        </v-chip>
                                    </template>
                                    <span class="caption">{{item.name}}</span>  
                                </v-tooltip>
                            </template>
                            
                        </v-select>
                    </v-col>

                    <v-col cols="12">
                        <v-autocomplete
                            v-model="profile"
                            label="Perfiles"
                            item-text="name"
                            no-data-text="No existen perfiles Disponibles"
                            :items="profilesAgency"
                            :disabled="loading"
                            :loading="loading"
                            hide-details
                            outlined
                            filled
                            dense
                            clearable
                            return-object
                            @change="list()"
                        >
                            <template v-slot:item="{item}">
                            <v-row dense class="grey lighten-5 subtitle-1">
                                <v-col cols="auto">
                                    <v-avatar color="grey" class="elevation-3" :size="30">
                                    <v-img :src="`/storage/photo/profile/${item.photo || 'nophoto'}.jpg`" ></v-img>
                                    </v-avatar>
                                </v-col>
                                <v-col>
                                {{item.name}}
                                </v-col>
                                <v-col cols="auto">
                                    <list-icon :data="sexIcons" :value="item.gender"></list-icon>
                                </v-col>
                            </v-row>
                            </template>
                        </v-autocomplete>
                    </v-col>

                </v-row>
                </v-card>

            </v-col>

            <v-col>
                <v-card color="rgba(0,0,0,0.4)" class="pa-2" max-height="92vh" mix-height="88vh">
                    <v-card-title class="pa-1">
                        <v-row no-gutters>
                                <v-col cols="auto">Registros</v-col>
                                <v-col></v-col>
                                <v-col cols="auto">                  
                                    <v-btn v-if="comissions.prev_page_url" :loading="loading" icon color="blue" @click="goTo(comissions.prev_page_url)"><v-icon>mdi-arrow-left-drop-circle-outline</v-icon></v-btn>
                                    <v-btn v-if="comissions.next_page_url" :loading="loading" icon color="blue" @click="goTo(comissions.next_page_url)"><v-icon>mdi-arrow-right-drop-circle-outline</v-icon></v-btn>
                                </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="comission-container custom-scroll">
                        <v-row dense>
                            <v-col cols="4" v-for="comission in comissions.data" :key="comission.id">
                                <v-card color="rgba(0,0,0,0.4)" class="ma-1 rounded-lg">
                                    <v-row dense>
                                        <v-col cols="5">
                                            <v-row no-gutters >
                                                <v-col cols="12" class="caption text-center">{{comission.client_id}}</v-col>
                                                <v-col cols="12" class="text-center">
                                                    <v-row no-gutters justify="center">
                                                        <v-col cols="auto">
                                                            <v-avatar color="blue" class="elevation-3" :size="30">
                                                                <v-img :src="`/storage/photo/client/${(comission.client) ? comission.client.photo || 'nophoto' : 'nophoto'}.jpg`" ></v-img>
                                                            </v-avatar>
                                                        </v-col>
                                                        <v-col cols="auto" v-if="comission.client">
                                                            <v-badge v-if="comission.client.crown > 0" offset-x="6" offset-y="12" color="rgba(0,0,0,0.15)" :content="comission.client.crown">  
                                                                <list-simple-icon icon="mdi-crown" :label="formatNumber(comission.client.points)" color="amber" :size="20"></list-simple-icon>
                                                            </v-badge> 
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                                <v-col cols="12" class="caption text-center">{{(comission.client) ? comission.client.name : '-'}}</v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col class="text-center">

                                            <v-row no-gutters>
                                                <v-col cols="12" class="text-detail" :class="(comission.positive = 1) ? 'white--text' : 'red--text' ">
                                                     {{ hourFromDateTime(comission.comission_at) }}
                                                </v-col>
                                                <v-col cols="12">
                                                    <list-simple-icon  
                                                        :size="32"
                                                        :icon="comission.has_service.icon" 
                                                        :label="comission.has_service.name"
                                                        :color="comission.has_service.color"
                                                        v-if="comission.has_service"
                                                    > </list-simple-icon>
                                                    <list-simple-icon  
                                                        :size="32"
                                                        icon="mdi-comment-question" 
                                                        :label="comission.service"
                                                        color="amber"
                                                        v-else
                                                    > </list-simple-icon>
                                                </v-col>
                                                <v-col cols="12" class="text-detail" :class="(comission.positive = 1) ? 'white--text' : 'red--text' ">
                                                    {{ formatNumber(comission.points) }}
                                                </v-col>
                                            </v-row>
                                            
                                        </v-col>
                                        <v-col cols="5">
                                            <v-row no-gutters>
                                                <v-col cols="12" class="caption text-center">{{comission.profile_id}}</v-col>
                                                <v-col cols="12" class="text-center">
                                                    <v-avatar color="grey" class="elevation-3" :size="30">
                                                        <v-img :src="`/storage/photo/profile/${(comission.profile) ? comission.profile.photo || 'nophoto' : 'no-photo'}.jpg`" ></v-img>
                                                    </v-avatar>
                                                    </v-col>
                                                <v-col cols="12" class="caption text-center">{{(comission.profile) ? comission.profile.name : ''}}</v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>


        <v-overlay  :opacity="0.4" :value="loading">
        <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
      </v-overlay>
        
    </v-card-text> 


       
   </v-card>
        
       
               

</template>

<script>
import AppData from '@mixins/AppData';
import ComisionCard  from './components/ComisionCard';
import ComissionCalendar from './components/ComissionCalendar'
export default {

    mixins:     [ AppData ],

    components: { 
        ComisionCard,
        ComissionCalendar
    },

    created(){
       this.getProfiles()
       this.getServices()
    },

    watch:{
        serviceType()  {
            this.serviceSelected = []
        }
    },

    computed:{
        itemsService()
        {
            return this.services.filter(service => service.type == this.serviceType )
        },

        agencies()
        {
            return this.$store.getters['getAgencyManage']
        },

        profilesAgency()
        {
            return  (this.agency) ?  this.profiles.filter( profile => profile.agency_id == this.agency.id) : this.profiles
        },
    },

    data: () => ({
        comissions: [],
        profiles: [],
        url: 'comission/list',
        types: [ 'bonus',  'writeoff'],
        serviceType: 'bonus',
        services: [ ],
        agency:  null,
        day:     new Date().toISOString().substr(0, 10),
        serviceSelected: [],
        profile: null,
        filter:[]
    }),

    methods:
    {
        list() {

            if(this.agency)
            {
                let filters = this.setFilters()
                this.getResource(`${this.url}${filters}`).then(data =>{
                    this.comissions = data
                })
            }
        },

        setDay(day)
        {
            this.day = day
            this.list()
        },

        setFilters()
        {   
            this.filter['agency']   = this.agency.amolatina_id 
            this.filter['day']      = this.day 
            this.filter['service']  = this.serviceSelected 
            this.filter['profile']  = (this.profile) ? this.profile.amolatina_id : null
            this.filter['positive'] = (this.serviceType == 'bonus') ? 1 : 0;
            return this.buildQuery(this.filter);
        },

        buildQuery(filter)
        {
           let query = this.url.includes('?') ? '&' : '';

           for (const key in filter) {
               if(filter[key] != null) {
                    if( Array.isArray(filter[key]) ) {
                        for ( const value of filter[key] ) {
                            query += (query == '&') ?  `${key}[]=${value}` : `&${key}[]=${value}`
                        }
                    } else {
                        query += (query == '&') ?  `${key}=${filter[key]}` : `&${key}=${filter[key]}`
                    }
               }
           }
           return  ( query.includes('?')  || this.url.includes('?')) ? query : `?${query}`
        },

        getProfiles() {
            this.getResource(`profile/list`).then(data =>{
                this.profiles = data
            })
        },

        getServices() {
            this.getResource(`service`).then(data =>{
                this.services = data
            })
        },

        getdetail(){
            this.getResource('comission/detail').then(data =>{
            })
        },

        remove(item)
        {
            this.filters = this.filters.filter( f => f != item.value) 
        },

        goTo(url)
        {
            console.log(url);
            if(!url) return
            if(this.agency)
            {
                let filters = this.setFilters()
                this.getResource(`${url}${filters}`).then(data =>{
                    this.comissions = data
                })
            }
        },

        getService(selected)
        {
            return this.services.find( service => service.value == selected )
        }
    }
}

//'comission?type=1&positive=true'
</script>

<style>
.comission-container {
    max-height: 74vh;
    overflow-y: auto;
}
</style>