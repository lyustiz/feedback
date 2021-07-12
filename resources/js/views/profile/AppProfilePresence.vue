<template>

<v-card dark color="transparent">
  <v-card-title class="py-0">
    <v-row no-gutters>
      <v-col></v-col>
      <v-col cols="auto">
        <v-btn small icon color="success" @click="list()"><v-icon>mdi-reload</v-icon></v-btn>
      </v-col>
    </v-row>
  </v-card-title>
  <v-card-text>
    <v-row dense>
      <v-col v-for="profile in profiles" :key="profile.id" cols="12" lg="3" md="4" sd="6">
        <v-card class="card-background">
          <v-card-title class="subtitle-1">
            <v-avatar size="80">
                <v-img :src="`/storage/photo/profile/${profile.photo || 'nophoto'}.jpg`" ></v-img>
            </v-avatar>
          </v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-card-text>
</v-card>
  
</template>

<script>
import AppData from '@mixins/AppData';
export default {

  mixins: [ AppData ],

  created()
  {
    this.list()
  },

  data: () => ({
    profiles: []
  }),

  methods: {
    list()
    {
      this.getResource(`profile/all`).then(data =>{
          this.profiles = data
      })
    }
  }
}
</script>

<style>

</style>