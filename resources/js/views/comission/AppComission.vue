<template>

   <v-card color="transparent" flat dark min-height="93vh">
       <v-card-title >
           <v-row no-gutters>
               <v-col>Total: {{ formatNumber(commisions.total || 0 ) }}</v-col>
               <v-col>
                   <v-btn :loading="loading" icon color="blue" @click="goTo(commisions.first_page_url)"><v-icon>mdi-chevron-double-left</v-icon></v-btn>
                   <v-btn :loading="loading" icon color="blue" @click="goTo(commisions.prev_page_url)"><v-icon>mdi-chevron-left</v-icon></v-btn>
                   <v-chip small color="blue">{{commisions.current_page}} of {{commisions.last_page}} </v-chip>
                   <v-btn :loading="loading" icon color="blue" @click="goTo(commisions.next_page_url )"><v-icon>mdi-chevron-right</v-icon></v-btn>
                   <v-btn :loading="loading" icon color="blue" @click="goTo(commisions.last_page_url )"><v-icon>mdi-chevron-double-right</v-icon></v-btn>
               </v-col>
               <v-col>
                   <v-btn icon color="success" :loading="loading" @click="getdetail()"><v-icon>mdi-refresh</v-icon></v-btn>
               </v-col>
               <v-col>
                   <v-row no-gutters>
                       <v-col cols="auto">
                           <v-radio-group v-model="filterType" dense hide-details class="mt-n2 mr-2">
                                <v-radio
                                    v-for="type in types"
                                    :key="type"
                                    :label="type"
                                    :value="type"
                                    class="my-2n mb-0 caption"
                                ></v-radio>
                            </v-radio-group>
                       </v-col>
                       <v-col>
                           <v-select
                                v-model="filters"
                                item-text="name"
                                item-value="value"
                                :items="itemsFilters"
                                label="Filtro"
                                multiple
                                dense
                                hide-details
                                chips
                                deletable-chips
                                single-line
                                class="ma-0"
                                color="blue"
                                solo
                                rounded
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
                   </v-row>
                   
                   

               </v-col>
           </v-row>
           
       </v-card-title>
       <v-card-text>
           <v-row dense>
               <v-col cols="12" md="4" v-for="comission in commisions.data" :key="comission.id">
                    <ComisionCard :comission="comission" :services="services"></ComisionCard>
               </v-col>
           </v-row>
       </v-card-text>
       <v-overlay absolute :opacity="0.4" :value="loading">
        <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
      </v-overlay>
   </v-card>

</template>

<script>
import AppData from '@mixins/AppData';
import ComisionCard  from './components/ComisionCard';
export default {

    mixins:     [ AppData ],

    components: { 
        ComisionCard 
    },

    created(){
        this.list()
    },

    watch:{
        filterType()  {
            this.filters = []
        }
    },

    computed:{
        itemsFilters()
        {
            return this.services.filter(service => service.type == this.filterType )
        }
    },

    data: () => ({
        commisions: [],
        url: 'comission',
        filterType: 'bonus',
        types: [ 'bonus',  'writeoff'],
        filters:[],
        services: [
            {name: 'ONLINE_CHAT',         value: "dialogs.messages:intervals",       type: 'bonus',     color: 'blue', icon: 'mdi-cellphone-message'},
            {name: 'CHAT_MESSAGE',        value: "dialogs.messages:messages",        type: 'bonus',     color: 'blue', icon: 'mdi-message-bulleted'},
            {name: 'RECEIVED_EMAIL',      value: "dialogs.letters:send",             type: 'bonus',     color: 'blue', icon: 'mdi-email-receive-outline'},
            {name: 'SENT_EMAIL',          value: "dialogs.letters:read",             type: 'bonus',     color: 'blue', icon: 'mdi-email-send-outline'},
            {name: 'VIEWED_ATTACHMENT',   value: "dialogs.attachments",              type: 'bonus',     color: 'blue', icon: 'mdi-image-search'},
            {name: 'VIDEO_STREAM',        value: "videostream",                      type: 'bonus',     color: 'blue', icon: 'mdi-video-box'},
            {name: 'PROFILE_VIDEO',       value: "paidresource:video",               type: 'bonus',     color: 'blue', icon: 'mdi-message-video'},
            {name: 'PRESENT',             value: "present",                          type: 'bonus',     color: 'blue', icon: 'mdi-gift'},
            {name: 'MANUAL_BONUS',        value: "manualbonus",                      type: 'bonus',     color: 'blue', icon: 'mdi-trophy'},
            {name: 'GIFT',                value: "cheers",                           type: 'bonus',     color: 'blue', icon: 'mdi-wallet-giftcard'},
            {name: 'MISSED_INVITE',       value: "dialogs.interval.added:missed",    type: 'writeoff',  color: 'red', icon: 'mdi-account-cancel'},
            {name: 'MISSED_ANSWER',       value: "dialogs.interval.answer:missed",   type: 'writeoff',  color: 'red', icon: 'mdi-message-bulleted-off'},
            {name: 'MISSED_MESSAGE',      value: "",                                 type: 'writeoff',  color: 'red', icon: 'mdi-email-alert'},
            {name: 'UNANSWERED_EMAIL',    value: "dialogs.letter:missed",            type: 'writeoff',  color: 'red', icon: 'mdi-email-alert'},
            {name: 'MISSED_EMAIL',        value: "dialogs.letter:missed.hopelessly", type: 'writeoff',  color: 'red', icon: 'mdi-email-alert'},
            {name: 'MISSED_VIDEO_INVITE', value: "dialogs.media:missed",             type: 'writeoff',  color: 'red', icon: 'mdi-video-box-off'},
            {name: 'MISSED_PRESENT',      value: "present:missed",                   type: 'writeoff',  color: 'red', icon: 'mdi-gift-outline'},
            {name: 'MANUAL_WRITEOFF',     value: "manualwriteoff",                   type: 'writeoff',  color: 'red', icon: 'mdi-gavel'}   
        ]
    }),

    methods:
    {
        list() {
            this.getResource(this.url).then(data =>{
                this.commisions = data
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
            if(!url) return
            this.url = url
            this.list()
        },

 
    }
}

//'comission?type=1&positive=true'
</script>

<style>
</style>