<template>

    <v-container fluid>
        <v-row dense>
            <v-col cols="12" md="6" lg="4">
                <Userboard></Userboard>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <ListProfiles></ListProfiles>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <TableProfile></TableProfile>
            </v-col>
        </v-row>
    </v-container>
  
</template>

<script>
import AppData from '@mixins/AppData' 
import Userboard from './components/UserBoard'
import ListProfiles from './components/ListProfiles'
import TableProfile from './components/TableProfile'
export default {

    name: 'operator-board',

    mixins:[ AppData],

    components:{
        Userboard,
        ListProfiles,
        TableProfile
    },


    data: () => ({
        
    })
}
</script>

<style>

</style>