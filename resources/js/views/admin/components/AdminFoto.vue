<template>
<div>
  
  <v-btn fab small dark @click="showFormImage()" color="deep-orange"><v-icon>mdi-image-plus</v-icon></v-btn>

  <v-dialog
    v-model="formImage"
    @change="resetData()"
    width="50rem"
    content-class="rounded-lg" >
    <v-card>
      <v-card-text>
        <v-container>
        <v-row>
            
            <v-file-input 
              class="d-none"
              ref="fileInput"
              accept="image/*" 
              :capture="capture" 
              v-model="imageUpload" 
              @change="setImage()">
            </v-file-input>
            
          <v-col cols="12" class="text-center">
             <v-img :src="rawImg" height="12rem" width="14rem" class="grey lighten-3 rounded-lg mx-auto">
               <v-row
                class="fill-height"
                align="center"
                justify="center"
              >
                <v-btn icon dark x-large @click="$refs.fileInput.$refs.input.click()">
                  <v-icon
                    color="grey"
                    class="mt-4"
                    size="90"
                    v-text="'mdi-image-plus'"
                  ></v-icon>
                </v-btn>
              </v-row>
             </v-img>
          </v-col>
          <v-col cols="12" class="text-center" >

            <v-select
              :items="sedes"
              item-text="nb_sede"
              item-value="id"
              v-model="origen"
              :rules="[rules.select]"
              label="Sede"
              :loading="loading"
              dense
            ></v-select>

          </v-col>

          <v-col cols="12" class="text-center">
            
            <v-btn fab color="error" class="mx-2" @click="formImage=false"><v-icon>mdi-window-close</v-icon></v-btn>
            <v-btn fab color="success" class="mx-2" @click="store()"><v-icon>mdi-plus</v-icon></v-btn>
          </v-col>
        </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</div>

</template>

<script>
import AppData from '@mixins/AppData';

export default {
    
    mixins:     [ AppData],

    props:
    {
        tipoFoto: {
            type:       Number,
            default:    1
        },

        capture: {
            type:       Boolean,
            default:    false
        },

        disabled: {
            type:       Boolean,
            default:    false
        },

    },

  created()
  {
    this.sedes = JSON.parse(window.locations)
  },

  watch:
  {
    formImage()
    {
      this.resetData()
    }
  },

  data () {
    return {
        formImage:   false,
        origen:      null,
        imageUpload: null,
        rawImg:      null,
        loading:     false,
        image:       null,
        sedes:       []
    }
  },

  methods:
  {
      resetData()
      {
        this.rawImg = null
        this.origen = null
      },
      
      showFormImage()
      {
          this.formImage = true
      },
      
      store()
      {
          if( this.rawImg === null )
          {
            alert('seleccione una imagen')
            return
          }

          if( this.origen === null )
          {
            alert('seleccione una sede')
            return
          }
          
          this.image = {
              tx_src      : this.rawImg,
              id_tipo_foto: this.tipoFoto,
              id_origen   : this.origen,
              id_usuario  : this.idUser,
          }

          this.storeResource('foto', this.image).then( (data) =>  
          {
            this.showMessage(data.msj)
            this.rawImg = null
            this.$emit('storeImage' , true)
            this.formImage = false
          })
      },
      
      validImage(image)
      {
          let size = image.size / 1024  ; //kilobites
          let type = image.type.split('/');
          let imageType = ['jpeg', 'png', 'bmp'];

          const fileTypes = [
              "image/apng",
              "image/bmp",
              "image/gif",
              "image/jpeg",
              "image/pjpeg",
              "image/png",
              "image/svg+xml",
              "image/tiff",
              "image/webp",
              "image/x-icon"
              ];

          if(size > 0)
          {
              if(size > 2048)
              {
                  let msj = 'archivo debe ser menor de 2 MB. (Actual: '+ (size / 1024).toFixed(2) +' MB)';
                  this.showError(msj)
                  return false;
              }
          }

          if( (type[0] != 'image') || ( !imageType.includes(type[1]) ) )
          {
              let msj = 'solo se permiten imagenes con los formatos: ' + imageType;
              this.showError(msj)
              return false;
          }

          return true;
      },

      setImage()
      {
        if(this.imageUpload)
        {                
          if(!this.validSize()) return

          this.loading  = true

          let reader    = new FileReader();

          reader.readAsDataURL(this.imageUpload);

          reader.onload = () => 
          {
            this.rawImg      = reader.result
            this.imageUpload = null
            this.loading     = false
          };

          reader.onerror = () => 
          {
            this.showError({ msj: 'error al intentar cargar la foto'})
          };
        }
      },

      validSize()
      {
          if(this.imageUpload.size/1048576 > 10)
          {
              this.showError('Tamaño de Foto excede los 5 MB ('+ file.size/5120 + ')MB')

              this.imageUpload = null

              return false
          }
          return true
      },
  }
}
</script>

<style>

</style>