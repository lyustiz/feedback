<template>


    <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)" min-height="91vh" v-if="user">
        <v-card-title primary-title>
            <v-row dense>
                <v-col>{{user.full_name}} ({{user.username}})</v-col>
                <v-col cols="auto"><v-btn icon color="success" @click="list()"><v-icon>mdi-dots-vertical</v-icon></v-btn></v-col>
            </v-row>
        </v-card-title>
        <v-card-text>

            <v-row>
                <v-col cols="auto">
                    <v-avatar color="blue" size="100" class="elevation-2">
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
                        <v-col cols="7" class="font-weight-light">{{user.table.name}}</v-col>
                        <v-col cols="5"  class="subtitle-2">Gerente</v-col>
                        <v-col cols="7" class="font-weight-light">{{user.table.manager.name}}</v-col>
                        <v-col cols="5"  class="subtitle-2">Coordinador</v-col>
                        <v-col cols="7" class="font-weight-light">{{user.table.coordinator.name}}</v-col>
                    </v-row>
                </v-col>
            </v-row>

            <v-row>
                <v-col class="text-center">
                    <v-subheader>Meta Dia</v-subheader>
                    <v-progress-circular
                        :rotate="-90"
                        :size="80"
                        :width="8"
                        :value="user.presence_day_sum_profit * 100 / 200 "
                        color="blue">
                            <v-row no-gutters>
                                <v-col cols="12" class="caption">{{ formatNumber(user.presence_day_sum_profit) }}</v-col>
                                <v-col cols="12" class="title">200</v-col>
                            </v-row>
                    </v-progress-circular>
                </v-col>  
                <v-col class="text-center">
                    <v-subheader>Meta Mes</v-subheader>
                    <v-progress-circular
                        :rotate="-90"
                        :size="80"
                        :width="8"
                        :value="user.presence_month_sum_profit * 100 / 900 "
                        color="amber">
                        <v-row no-gutters>
                                <v-col cols="12" class="caption">{{ formatNumber(user.presence_month_sum_profit) }}</v-col>
                                <v-col cols="12" class="title">900</v-col>
                            </v-row>
                    </v-progress-circular>
                </v-col>  
            </v-row>

            <v-row>
                <v-col cols="3">
                    <v-subheader>Sanciones</v-subheader>
                </v-col>
                <v-col>
                    <v-rating
                      full-icon="mdi-circle-off-outline"
                      :value="null || 2"
                      :length="null || 2"
                      color="red"
                      background-color="grey lighten-1"
                      readonly
                  ></v-rating>
                </v-col>
            </v-row>
            <v-row>
                 <v-col cols="3">
                    <v-subheader>Permisos</v-subheader>
                </v-col>
                <v-col>
                    <v-rating
                      full-icon="mdi-exit-run"
                      :value="null || 1"
                      :length="null || 1"
                      color="success"
                      background-color="grey lighten-1"
                      readonly
                  ></v-rating>
                </v-col>
            </v-row>

            <v-row>
                 <v-col cols="3">
                    <v-subheader>Bonos</v-subheader>
                </v-col>
                <v-col>
                    <v-rating
                      full-icon="mdi-star"
                      :value="null || 4"
                      :length="null || 4"
                      color="amber"
                      background-color="grey lighten-1"
                      readonly
                  ></v-rating>
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
    },

    data: () => ({
        user: null    
    }),

    methods:
    {
        list()
        {
            this.getResource(`user/${this.userId}?with[]=profile&with[]=table&with[]=group&with[]=presenceDay`).then( data => {
                this.user = data;
            })
        }
    }

}
</script>

<style>

</style>