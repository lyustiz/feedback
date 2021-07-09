<template>
  <v-card dark class="rounded-lg main-color" >
    <v-subheader class="subtitle-1">
        <v-row>
            <v-col cols="auto">
                Asignar Agencias
            </v-col>
            <v-col>
                Usuario: {{ user.full_name }}
            </v-col>
            <v-col cols="auto">
                <v-btn icon x-small @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn>
            </v-col>
        </v-row>
        </v-subheader>
    <v-divider></v-divider>
    <v-card-text class="pt-2 accounts-container custom-scroll">

      <v-autocomplete
        v-model="agency"
        label="Agencias"
        item-text="name"
        no-data-text="No existen agencias Disponibles"
        :items="agencies"
        :disabled="loading"
        :loading="loading"
        hide-details
        outlined
        filled
        dense
        clearable
        open-on-clear
        return-object
        @change="assing($event)"
      >
        <template v-slot:item="{item}">
          <v-row dense class="grey lighten-5 subtitle-1">
            <v-col>
              {{item.name}}
            </v-col>
            <v-col cols="auto">
                <list-simple-icon icon="mdi-plus-circle" label="Agregar" color="success"></list-simple-icon>
            </v-col>
          </v-row>
        </template>
      </v-autocomplete>

      <v-list dense color="rgba(0,0,0,0.4)" class="rounded-lg mt-1"> 
          <v-list-item v-for="userAgency in userAgencies" :key="userAgency.id" > 
            <v-list-item-avatar color="amber" size="30">
              <v-icon>mdi-home-circle-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>
                  <v-row>
                    <v-col>
                      {{userAgency.name}}
                    </v-col>
                  </v-row>
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-row>
                  <v-col>
                    <v-btn icon small @click="remove(userAgency)" :loading="loading"><v-icon color="red">mdi-delete</v-icon></v-btn>
                  </v-col>
                </v-row>
              </v-list-item-action>
          </v-list-item>
        </v-list> 

    </v-card-text>
  </v-card>
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins: [AppData],

  props:{
    user: {
      type: Object,
      default: () => {}
    },
  },

  created() {
    this.list()
  },

  data: () => ({
    agency: null,
    agencies: [],
    userAgencies: []
  }),

  methods: {

    list() {
        this.getResource(`userAgency/assing/${this.user.id}/${this.user.agency_id}`).then( data => {
          this.agencies = data.agency
          this.userAgencies = data.userAgency
        })
    },

    assing(agency)
    {
      let form = {
        agency_id : agency.id,
        user_id   : this.user.id,
        user_id_ed: this.userId,
        status_id : 1
      }

      this.storeResource(`userAgency`, form).then( data => {
        this.agency = null;
        this.showMessage(data.msj)
        this.agencies = this.agencies.filter( (item) => item.id != agency.id)
        data.userAgency.name = agency.name
        this.userAgencies.push(data.userAgency)
        this.$emit('onUpdateData')
      })
    },

    remove(userAgency)
    {
      this.deleteResource(`userAgency/${userAgency.id}`).then( data => {
        this.showMessage(data.msj)
        this.userAgencies = this.userAgencies.filter( (item) => item.id != userAgency.id)
        //userAgency.id = userAgency.profile_id
        this.agencies.push(userAgency)
        this.$emit('onUpdateData')
      })
    },

  }
}
</script>

<style>

</style>