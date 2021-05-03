<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>
      <v-row no-gutters>
        <v-col class="ml-2 title">
          Operadores
        </v-col>
        <v-col cols="auto">
          <v-icon size="33">mdi-account-plus</v-icon>
          <v-icon size="32">mdi-file-restore</v-icon>
          <v-icon size="32">mdi-lock-open-check</v-icon>
        </v-col>
      </v-row>
      </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 
        <v-list-item v-for="cliente in operatos" :key="cliente.id" > 
          <v-list-item-avatar color="blue" size="60" class="elevation-2">
              <v-img :src="`/images/users/${cliente.photo || 'nophoto.png'}`" ></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                  {{ cliente.day || 0 }}  /  {{ cliente.month || 0 }}
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                  3000
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                  <v-progress-linear
                  :value="cliente.day*100/cliente.month || 60"
                  color="blue"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
              </v-row>
              
            </v-list-item-title>
            <v-list-item-subtitle class="pt-2">
              <v-row no-gutters>
                  <v-col>{{cliente.name}} {{cliente.surname}}</v-col>
                  <v-col>
                  <v-rating
                      full-icon="mdi-circle-off-outline"
                      :value="cliente.fault || 1"
                      :length="cliente.fault || 1"
                      color="red"
                      background-color="grey lighten-1"
                      small
                      dense
                      readonly
                  ></v-rating>
                  </v-col>
              </v-row>
            </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon>
              <item-menu 
                  :menus="itemsMenu" 
                  iconColor="white" 
                  btnColor="transparent" 
                  :item="item"
                  @onItemMenu="onItemMenu($event)"
              ></item-menu>
            </v-list-item-icon>
        </v-list-item>
      </v-list>
    </v-card-text>
  </v-card>
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins: [AppData],

  created() {
    this.list()
  },

  data: () => ({
    operatos: [],
    itemsMenu: [
      { action: 'addFine',     icon: 'mdi-account-alert', label: 'Agregar Multa', iconColor: 'red' },
      { action: 'removeFine',  icon: 'mdi-account-check', label: 'Eliminar Multa', iconColor: 'red' },
      { action: 'delOperator', icon: 'mdi-account-off',   label: 'Eliminar Operador', iconColor: 'red', class: 'red' },
    ]
  }),

  methods: {

    list() {
        this.getResource('user/list').then( data => {
          this.operatos = data
        })
    },

    
  }

}

</script>

<style>
.accounts-container{
  height: 83vh;
  overflow-y: auto;
}
</style>