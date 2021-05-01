<template>
  <v-row>
      <v-col >
        <v-carousel 
        class="rounded-lg" 
        height="55vh"
        hide-delimiters
          hide-delimiter-background
          show-arrows-on-hover
          cycle
        >
          <v-carousel-item
            v-for="(banner,i) in banners"
            :key="i"
            :src="banner.src" 
            reverse-transition="fade-transition"
            transition="fade-transition"
            
          >
          <v-row class="fill-height" justify="center" align="center">
            <v-col cols="12" class="text-center">
               <div class="d-block display-3 font-weight-bold text-image">Bienvenidos a Bingolin</div> 
               <div class="headline text-image">Telebingo en Linea</div>   
               <div class="headline text-image mt-1">
                  <v-btn icon link target="_blank" href="https://www.youtube.com/channel/UC3IjTAtJh4WWZelow8DzL8Q" class="mx-4">
                    <v-icon color="white" size="32">mdi-youtube</v-icon>
                  </v-btn>
                  <v-btn icon link target="_blank" href="https://www.instagram.com/p/CJtP6zZpvLh/" class="mx-4">
                    <v-icon color="white" size="32">mdi-instagram</v-icon>
                  </v-btn>
                  <v-btn icon link target="_blank" href="https://www.facebook.com/Bingolin-Telebingo-en-Linea-108161027651276" class="mx-4">
                    <v-icon color="white" size="32">mdi-facebook</v-icon>
                  </v-btn>
                  <v-btn icon link href="#" class="mx-4">
                    <v-icon color="white" size="32">mdi-twitter</v-icon>
                  </v-btn>
              </div> 
            </v-col>
          </v-row>
          </v-carousel-item>
        </v-carousel>
      </v-col>
    </v-row>
</template>

<script>
export default {

  created()
  {
    //this.banners = JSON.parse(window.images).filter( image => image.id_tipo_foto == 1 )
  },

  data: () => ({
      banners: [
           { id: 1, src: '/images/banner/banner1.jpg' },
           { id: 2, src: '/images/banner/banner2.jpg' },
           { id: 3, src: '/images/banner/banner3.jpg' },

      ],
  })
 
}
</script>

<style>

</style>