<template>
    
    <v-list dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 
        <v-list-item v-if="profile" class="my-n2 py-0"> 
            <v-list-item-avatar color="blue" size="40">
             <v-img :src="`/images/profiles/${profile.photo || 'nophoto'}.80x80.thumb-fd`" ></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>
                {{profile.name}}             
                </v-list-item-title>
            </v-list-item-content>
            <v-list-item-icon>
                <v-icon class="mt-4" color="red" @click="removeProfile()">mdi-close</v-icon>
            </v-list-item-icon>
        </v-list-item>

        <v-list-item v-else class="my-n2 py-0"> 
            <v-list-item-avatar color="blue" size="40">
              <v-icon>mdi-account-switch-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>
                  Seleccione Perfil          
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
    </v-list>
  
</template>

<script>
export default {

    computed:
    {
        profile()
        {
            return this.$store.getters['getProfile']
        }
    },

    methods: {
        removeProfile()
        {
            this.$store.commit('setProfile', null)
        }
    }

    
 
    
}
</script>

<style>

</style>