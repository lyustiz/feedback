<template>
   <v-card>
       <v-card-title class="grey lighten-4">
           <v-row>
             <v-col>
               <h3 class="headline mb-0">Ganadores</h3>
             </v-col>
             <v-col cols="auto">
                <AdminFoto :tipo-foto="5" @storeImage="list()"></AdminFoto>
             </v-col>
           </v-row>
       </v-card-title>
       <v-card-text>
       <v-container> 
        <v-row>
          <v-col cols="12" md="6" v-for="foto in fotos" :key="foto.id" class="text-center">
            <v-col cols="12 color deep-orange white--text text-center headline elevation-6 text-capitalize rounded-lg">{{foto.sede.nb_sede}}</v-col>
            <v-img  :src="foto.full_url" width="100%" class="my-4 elevation-6 rounded-lg mx-auto">
              <v-row
                class="fill-height"
                align="center"
                justify="center"
              >
                <v-btn icon dark large class="elevation-10" @click="deletePicture(foto.id)">
                  <v-icon
                    color="white"
                    size="80"
                    v-text="'mdi-close-circle-outline'"
                  ></v-icon>
                </v-btn>
              </v-row>
            </v-img>
          </v-col>
        </v-row>
       </v-container>  
       </v-card-text>

        <v-overlay :opacity="0.3" :value="loading">
            <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
        </v-overlay>

   </v-card>
</template>

<script>
import AppData        from '@mixins/AppData';
import AdminFoto      from './AdminFoto'

export default {

  mixins: [AppData],

  components:{
    AdminFoto
  },

  created()
  {
      this.list()
  },

  data: () => ({
      tab:         2,
      fotos:       []
  }),

  methods:
  {
    list() {
      this.getResource(`foto/tipoFoto/5`).then( data => {
          this.fotos        = data
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