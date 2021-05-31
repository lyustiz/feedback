<template>

<v-card class="main-color" dark flat>
  <v-subheader class="py-1">
    <v-row>
      <v-col class="title">Mesas</v-col>
      <v-col cols="auto">
        <v-btn v-if="$route.name != 'table-detail'" icon dark @click="$emit('closeDialog', false)"><v-icon>mdi-close</v-icon></v-btn>
      </v-col>
    </v-row>
  </v-subheader>
  <v-card-text class="custom-scroll">
    <v-row>
      <v-col v-for="table in tables" :key="table.id">
        <v-card color="rgba(0,0,0,0.4)" flat>
        <v-subheader>
          <v-row>
            <v-col>{{table.name}}</v-col>
            <v-col>{{table.coordinator.full_name}}</v-col>
            <v-col>{{table.turn.name}}</v-col>
          </v-row>
        </v-subheader>
        <v-card-text>
        <v-row v-for="operator in table.operator" :key="operator.id">
          <v-col cols="12">
            <v-row>
              <v-col>{{operator.name}}</v-col>
              <v-col>Perfiles {{operator.profile.length}}</v-col>
              <v-col>
                <v-row dense v-for="profile in operator.profile" :key="profile.id">
                  <v-col>
                    {{profile.name}}
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            
          </v-col>
        </v-row>
        </v-card-text>
        
        
          </v-card>
      </v-col>
    </v-row>
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

  data: () =>({
    tables: []
  }),

  methods:{
    list()
    {
      this.getResource('table/detail').then(data =>{
        this.tables = data;
      })
    }
  }
}
</script>

<style>

</style>