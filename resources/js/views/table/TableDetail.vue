<template>

<v-card class="main-color" dark flat>
  <v-subheader class="py-0" >
    <v-row no-gutters>
      <v-col class="title">Mesas</v-col>
      <v-col cols="auto">
        <v-btn v-if="$route.name != 'table-detail'" icon dark @click="$emit('closeDialog', false)"><v-icon>mdi-close</v-icon></v-btn>
      </v-col>
    </v-row>
  </v-subheader>
  <v-card-text class="custom-scroll">
    <v-row dense>
      <v-col v-for="table in tables" :key="table.id">
        <v-card color="rgba(0,0,0,0.4)" flat>
        <v-subheader class="py-1">
          {{table.name}}
        </v-subheader>
        <v-card-text class="py-0 px-2">
          <v-card v-for="tableTurn in table.table_turn" :key="tableTurn.id" color="rgba(0,0,0,0.4)" class="mb-1">
            
             <v-subheader class="tablename">
               <v-row>
                 <v-col>{{tableTurn.turn.name}}</v-col>
                 <v-col><v-icon small left color="green">mdi-shield-account</v-icon> {{ (tableTurn.coordinator) ? tableTurn.coordinator.full_name : 'Disponible'}}</v-col>
               </v-row>
             </v-subheader>

              <v-col cols="12" v-for="operator in tableTurn.operator" :key="operator.id">
                <v-row dense>
                  <v-col cols="6"> <v-icon small left color="amber">mdi-account</v-icon>   {{operator.full_name}}</v-col>
                  <v-col cols="6">Perfiles {{operator.profile.length}}</v-col>
                  <v-col cols="auto" v-for="profile in operator.profile" :key="profile.id" :class="(active) ? 'green': ''">
                      <draggable class="list-group move" group="people" @change="log" @start="enableLanding" @end="disableLanding">        
                        <v-chip color="primary" x-small >
                          <v-avatar>
                            <v-icon size="18">mdi-account-outline</v-icon>
                          </v-avatar>
                          {{profile.name}}
                        </v-chip>  
                      </draggable> 
                  </v-col>
                </v-row>
              </v-col>

          </v-card>

        </v-card-text>
        
        
          </v-card>
      </v-col>
    </v-row>
  </v-card-text>
</v-card>

  
</template>

<script>
import draggable from 'vuedraggable'
import AppData from '@mixins/AppData';

export default {

  mixins: [AppData],

  components: {
    draggable,
  },

  created() {
    this.list()
  },

  data: () =>({
    tables: [],
    active: false
  }),

  methods:{
    list()
    {
      this.getResource('table/detail').then(data =>{
        this.tables = data;
      })
    },

    enableLanding()
    {
      this.active = true
      console.log('active')
    },

    disableLanding()
    {
      this.active = false
      console.log('inactive')
    },
     add: function() {
      this.list.push({ name: "Juan" });
    },
    replace: function() {
      this.list = [{ name: "Edgard" }];
    },
    clone: function(el) {
      return {
        name: el.name + " cloned"
      };
    },
    log: function(evt) {
      window.console.log(evt);
    }
  }
}
</script>

<style>
.tablename{
  background-color: rgba(0,0,0,0.2)
}
</style>