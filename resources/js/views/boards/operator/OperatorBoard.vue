<template>

    <v-container fluid>
        <v-row>
            <v-col>
                <Userboard></Userboard>
            </v-col>
            <v-col>
                <ListProfiles></ListProfiles>
            </v-col>
            <v-col>
                <ClientManager></ClientManager>
            </v-col>
        </v-row>
    </v-container>
  
</template>

<script>
import AppData from '@mixins/AppData' 
import Userboard from './components/UserBoard'
import ListProfiles from './components/ListProfiles'
import ClientManager from './components/ClientManager'
export default {

    name: 'operator-board',

    mixins:[ AppData],

    components:{
        Userboard,
        ListProfiles,
        ClientManager
    },


    data: () => ({
        
    })
}
</script>

<style>

</style>