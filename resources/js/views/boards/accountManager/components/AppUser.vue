<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-text>
      <v-row>
        <v-col>
          <v-list-item> 
              <v-list-item-avatar size="70">
                  <v-icon color="grey" size="70">mdi-account-circle</v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                  <v-list-item-subtitle class="title-section"> {{user.name}}</v-list-item-subtitle>
                  <v-list-item-title>{{ role.name }}</v-list-item-title>
              </v-list-item-content>
              <v-list-item-icon>
                  <item-menu 
                    :menus="menus" 
                    iconColor="white" 
                    btnColor="transparent" 
                    :item="{id:1}"
                    @onItemMenu="onItemMenu($event)"
                  ></item-menu>
              </v-list-item-icon>
          </v-list-item>
        </v-col>
      </v-row>

    </v-card-text>

  

    

  </v-card> 
            
</template>

<script>
import AppData from '@mixins/AppData'
export default {

  mixins: [AppData],

  computed: 
  {
    user()
    {
      return this.$store.getters['getUser']
    },

    role()
    {
      return this.$store.getters['getRole']
    },

  },

  data: () => ({
    menus: [
      { action: 'updatePassword', icon: 'mdi-account-key', label: 'cambiar Contraseña', iconColor: 'info' },    
    ],
  }),

  methods:{
    updatePassword()
    {
      
    }
  }
}
</script>

<style>
.fill-total{
  display: block;
  width: 4.1rem;
}
</style>