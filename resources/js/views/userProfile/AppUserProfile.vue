<template>
  <v-card dark class="rounded-lg main-color" >
    <v-subheader class="title">
        <v-row>
            <v-col cols="auto">
                Asignar Perfiles
            </v-col>
            <v-col>
                Operador: {{ user.full_name }}
            </v-col>
            <v-col cols="auto">
                <v-btn icon x-small @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn>
            </v-col>
        </v-row>
        </v-subheader>
    <v-divider></v-divider>
    <v-card-text class="pt-2 accounts-container custom-scroll">

      <v-autocomplete
        v-model="profile"
        label="Perfiles"
        item-text="name"
        no-data-text="No existen perfiles Disponibles"
        :items="profiles"
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
            <v-col cols="auto">
                <v-avatar color="grey" class="elevation-3" :size="30">
                  <v-img :src="`/images/profiles/${item.photo || 'nophoto'}.80x80.thumb-fd`" ></v-img>
                </v-avatar>
              </v-col>
            <v-col>
                {{item.name}}
              </v-col>
            <v-col cols="auto">
                <list-icon :data="sexIcons" :value="item.gender"></list-icon>
            </v-col>
            <v-col cols="auto">
                <list-simple-icon icon="mdi-plus-circle" label="Agregar" color="success"></list-simple-icon>
            </v-col>
          </v-row>
        </template>
      </v-autocomplete>

      <v-list dense color="rgba(0,0,0,0.4)" class="rounded-lg mt-1"> 
          <v-list-item v-for="userProfile in userProfiles" :key="userProfile.id" > 
            <v-list-item-avatar color="blue" size="30">
              <v-img :src="`/images/profiles/${userProfile.photo || 'nophoto'}.80x80.thumb-fd`" ></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>
                {{userProfile.name}}
                </v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-btn icon small @click="remove(userProfile)"><v-icon color="red">mdi-delete </v-icon></v-btn>
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
    profile: null,
    profiles: [],
    userProfiles: []
  }),

  methods: {

    list() {
        this.getResource(`userProfile/assing/${this.user.id}/${this.user.agency_id}`).then( data => {
          this.profiles = data.profiles
          this.userProfiles = data.userProfiles
        })
    },

    assing(profile)
    {
      let form = {
        profile_id: profile.id,
        user_id   : this.user.id,
        agency_id : this.user.agency_id,
        user_id_ed: this.userId,
        status_id : 1
      }

      this.storeResource(`userProfile`, form).then( data => {
        this.profile = null;
        this.showMessage(data.msj)
        this.profiles = this.profiles.filter( (item) => item.id != profile.id)
        this.userProfiles.push(data.userProfile)
        this.$emit('onUpdateData')
      })
    },

    remove(userProfile)
    {
      this.deleteResource(`userProfile/${userProfile.id}`).then( data => {
        this.showMessage(data.msj)
        this.userProfiles = this.userProfiles.filter( (item) => item.id != userProfile.id)
        userProfile.id = userProfile.profile_id
        this.profiles.push(userProfile)
        this.$emit('onUpdateData')
      })
    }
  }
}
</script>

<style>

</style>