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
                    <v-col cols="5"  class="subtitle-2">Grupo</v-col>
                    <v-col cols="7" class="font-weight-light">{{user.group.name}}</v-col>
                    <v-col cols="5"  class="subtitle-2">Mesa</v-col>
                    <v-col cols="7" class="font-weight-light">{{(user.table) ? user.table.name : 'sin mesa'}}</v-col>
                    <v-col cols="5"  class="subtitle-2">Gerente</v-col>
                    <v-col cols="7" class="font-weight-light">{{( user.table.manager )? user.table.manager.full_name : 'Disponible'}}</v-col>
                  </v-row>
                </v-col>
            </v-row>

            <v-row no-gutters>
                <v-col class="text-center">
                    <v-subheader>Meta Dia</v-subheader>
                    <v-progress-circular
                        :rotate="-90"
                        :size="80"
                        :width="8"
                        :value="user.presence_day_sum_bonus * 100 / user.goal_day "
                        color="blue">
                            <v-row no-gutters>
                                <v-col cols="12" class="caption">{{ formatNumber(user.presence_day_sum_bonus) }}</v-col>
                                <v-col cols="12" class="title">200</v-col>
                            </v-row>
                    </v-progress-circular>
                </v-col>  
                <v-col class="text-center">
                    <v-subheader>
                        <v-row>
                            <v-col>Perdidas</v-col>
                        </v-row>
                    </v-subheader>
                    <v-progress-circular
                        :rotate="-90"
                        :size="80"
                        :width="8"
                        :value=" (user.presence_month_sum_writeoff)"
                        color="red">
                        <v-row no-gutters>
                            <v-col cols="12" class="caption">
                                <v-tooltip bottom color="red">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-on="on" v-bind="attrs">{{ parseInt(user.presence_day_sum_writeoff || 0) }}</span>
                                    </template>
                                    <span>Perdidas Dia</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="12" class="title">
                                <v-tooltip bottom color="red">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-on="on" v-bind="attrs">{{ parseInt(user.presence_month_sum_writeoff || 0) }}</span>
                                    </template>
                                    <span>Perdidas Mes</span>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                    </v-progress-circular>
                </v-col>
                <v-col class="text-center">
                    <v-subheader>
                        <v-row>
                            <v-col>Meta Mes</v-col>
                        </v-row>
                    </v-subheader>
                    <v-progress-circular
                        :rotate="-90"
                        :size="80"
                        :width="8"
                        :value="user.presence_month_sum_profit * 100 / user.goal_month "
                        color="green">
                        <v-row no-gutters>
                            <v-col cols="12" class="caption">{{ formatNumber(user.presence_month_sum_profit) }}</v-col>
                            <v-col cols="12" class="title">900</v-col>
                        </v-row>
                    </v-progress-circular>
                </v-col>    
            </v-row>

        

        </v-card-text>
    </v-card>
    
  
</template>

<script>
import AppData from '@mixins/AppData' 
export default {
 mixins:[ AppData],
    
    created()
    {
        this.list()
       /*  this.reload() */
    },

    data: () => ({
        user: null,
        isReload: null   
    }),

    methods:
    {
        list()
        {
            this.getResource(`user/${this.userId}?with[]=profile&with[]=table&with[]=group&with[]=presenceDay`).then( data => {
                this.user = data;
            })
        },

        reload()
        {
            this.isReload = setInterval( () => {
                this.list();
            }, 30000 )
        },

        estimatePresence()
        {
           this.getResource(`userPresence/estimate`).then( data => {
               console.log(data)
            }) 
        }
    }

}
</script>

<style>

</style>