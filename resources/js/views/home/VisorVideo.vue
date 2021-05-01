<template>

    <div>
        <v-card dark>
            <v-row no-gutters justify="center">

                <v-window v-model="dialogVideo" continuous show-arrows class="windows-container2 rounded-lg"> 
                    <v-window-item
                        v-for="video in videos"
                        :key="video.id"
                        class="windows-container2"
                        eager
                    >
                    
                    <div class="youtube-container2">
                        <iframe  v-if="video.id == dialogVideo"
                            class="rounded-lg responsive-iframe2" 
                            @load="loading = false" 
                            :src="`${video.src}?&enablejsapi=1&loop=1&rel=0&showinfo=0`"  
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    </v-window-item>
                    </v-window>
                    
               
            </v-row>
        </v-card>
    </div>

</template>

<script>

export default {
//autoplay=1&mute=1
    data: () => ({
        length:    2,
        dialogVideo: 0,
        videos:[
           { id: 0, src: 'https://www.youtube.com/embed/IH7hpclqfxc' },
           { id: 1, src: 'https://www.youtube.com/embed/wVofL_caczs' }
        ]
    })
}
</script>

<style>
.windows-container2
{
  width: 100%;
  height: 55vh; 
}


.youtube-container2
{
   position: relative;
  overflow: hidden;
  width: 100%;
  height: 100%;
}

.responsive-iframe2 {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
}
</style>