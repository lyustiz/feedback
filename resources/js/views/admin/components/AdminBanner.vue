<template>
  <v-card>

    <v-card-title class="grey lighten-4">
      <v-row>
        <v-col>
          <h3 class="headline mb-0">Banner</h3>
        </v-col>
        <v-col cols="auto">
          <AppFoto :tipo-foto="1" @storeImage="list()"></AppFoto>
        </v-col>
      </v-row>
    </v-card-title>
    
    <v-card-text>
      <v-container>
        <v-img v-for="foto in fotos" :key="foto.id" :src="foto.full_url" :aspect-ratio="16/9" max-height="12rem" class="my-4 elevation-4 rounded-lg">
          <v-row
            class="fill-height"
            align="center"
            justify="center"
          >
            <v-btn icon dark large class="elevation-10" @click="deletePicture(foto.id)">
              <v-icon
                color="white"
                size="50"
                v-text="'mdi-close-circle-outline'"
              ></v-icon>
            </v-btn>
          </v-row>
        </v-img>
      </v-container>
    </v-card-text>

    <v-overlay :opacity="0.3" :value="loading">
        <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
    </v-overlay>

  </v-card>
</template>

<script>
import AppData        from '@mixins/AppData';

export default {

  mixins: [AppData],

  created()
  {
      this.list()
  },

  data: () => ({
      tab:         0,
      fotos:       []
  }),

  methods:
  {
    list() {
      this.getResource(`foto/tipoFoto/1`).then( data => {
        this.fotos   = data
      });
    },

    addPicture(){
      this.pictureForm =  true
    },

    deletePicture(fotoId)
    {
      this.deleteResource(`foto/${fotoId}`).then( data => {
        this.fotos = this.fotos.filter( (foto) => foto.id != fotoId)
      }); 
    }
  }
}
</script>

<style>

</style>