<template>
    <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
        <v-card-text>
            <v-row no-gutters>
                <v-col class="text-center">

                    <v-row no-gutters>
                        <v-col  cols="12" class="text-center">
                             <v-rating
                                empty-icon="mdi-crown-outline"
                                full-icon="mdi-crown"
                                :value="3"
                                :length="3"
                                color="yellow accent-4"
                                background-color="grey lighten-1"
                                small
                                dense
                                readonly
                                ></v-rating>
                        </v-col  >
                        <v-col cols="12" class="text-center">
                            <v-avatar color="white" size="80" class="my-0">
                                <v-icon color="blue" size="100">mdi-account-circle</v-icon>
                            </v-avatar>
                        </v-col>
                        <v-col  cols="12" class="text-center">
                            <h3 class="text-center subtitle-2 pt-2">{{ comission.cllient_id }}</h3>
                        </v-col>
                    </v-row>
                   
                    
                    
                </v-col>
                <v-col class="text-center pt-7">
                    <list-simple-icon 
                        :size="82"
                        :icon="getService(comission.service).icon" 
                        :label="getService(comission.service).name"
                        :color="getService(comission.service).color"
                        >
                    </list-simple-icon>
                </v-col>
                <v-col class="">
                    <v-row no-gutters>
                        <v-col cols="12" class="text-center">
<v-rating
                      empty-icon="mdi-heart-outline"
                      full-icon="mdi-heart"
                      :value="4"
                      :length="4"
                      color="red"
                      background-color="grey lighten-1"
                      small
                      dense
                      readonly
                    ></v-rating>
                        </v-col>
                        <v-col cols="12" class="text-center">
                        <v-list-item-avatar color="blue" size="80" class="my-0 mx-auto">
                            <v-img :src="`/images/profiles/${comission.profile.photo || 'nophoto'}.80x80.thumb-fd`" ></v-img>
                        </v-list-item-avatar>
                        </v-col>
                        <v-col cols="12" class="text-center">
<h3 class="mx-auto text-center subtitle-2 pt-2">{{ comission.profile.name }}</h3>
                        </v-col>
                    </v-row>
                    
                   
                    
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
export default {

    props:
    {
        comission: {
            type:    Object,
            default: () => {}
        },

        services: {
            type:    Array,
            default: () => []
        },
    },

    data: ()=>({

    }),

    methods:
    {
        getService(selected)
        {
            return this.services.find( service => service.value == selected )
        }
    }
 
}
</script>

<style>

</style>