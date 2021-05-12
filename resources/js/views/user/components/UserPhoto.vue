<template>

  <v-avatar  :width="width" :height="height" tile color="blue" class="ml-1 rounded-circle" >
                
    <v-img :src="src">
      <v-file-input 
          accept="image/*" 
          :capture="capture" 
          v-model="imageUpload" 
          color="indigo"
          prepend-icon="mdi-image-search" 
          class="ml-10 mt-5"
          :loading="loading"
          :disabled="disabled"
          @change="setImage($event)"
          hide-details
          hide-input
      ></v-file-input>
    </v-img>

    <!-- Cropper Tool -->
    <v-dialog
      v-model="crop"
      width="95vw" 
      height="95vh"
      persistent 
      transition="dialog-transition"
    >
      <v-card class="col-10 mx-auto">
        <cropper 
          v-if="crop"
          classname="cropper"
          :src="rawImg"
          :stencil-props="{ aspectRatio: aspectRatio }"
          ref="cropper"
          width="95vw" 
          height="95vh"
        ></cropper>
        <v-btn fab top right absolute @click="cropImage" color="success" class="mt-12" :loading="loading">
            <v-icon>mdi-crop</v-icon>
        </v-btn>
        <v-btn fab top left absolute @click="crop=false" color="error" class="mt-12" :loading="loading">
            <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card>
    </v-dialog>   

  </v-avatar>
</template>

<script>
import AppData from '@mixins/AppData';
import { Cropper } from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css';

export default {

    components: {
		Cropper
    },
    
    mixins:     [ AppData],

    props:
    {
        origenId: {
            type:       Number,
            default:    1
        },

        tipoFoto: {
            type:       Number,
            default:    1
        },

        foto: {
            type:       Object,
            default:    null
        },

        height: {
            type:       Number,
            default:    100
        },

        width: {
            type:       Number,
            default:    100
        },

        aspectRatio: {
            type:       Number,
            default:    100/100
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
        this.src          = (this.foto) ? this.foto.full_url: null
        this.image        = (this.foto) ? this.foto: null
        this.validateForm = false
    },

    watch:
    {
        origenId()
        {
            if(this.origenId)
            {
                this.src     = (this.foto) ? this.foto.full_url: null
                this.image   = (this.foto) ? this.foto: null
            }
        },
    },

    data () {
        return {
            resource:     `foto/tipoFoto/${this.tipoFoto}/origen/${this.origenId}`,
            src:          null,
            imageUpload:  null,
            image:        null,
            rawImg:       null,
            crop:         false,
            loading:      true,
            image:        null,
            delDialog: false,
        }
    },
    methods:
    {
        store(imgSource)
        {
            this.image = {
                tx_src      : imgSource,
                id_tipo_foto: this.tipoFoto,
                id_origen   : this.origenId,
                id_usuario  : this.idUser,
            }
        },
        
        deleteDialog()
        {
            this.loading = false
            this.delDialog = true
        },

        deleteCancel()
        {
            this.delDialog = false
            this.$emit('close', this.image)
        },

        cropImage() 
        {
            const { canvas } = this.$refs.cropper.getResult()

            let imgSource = canvas.toDataURL('image/jpeg', 0.92)

            this.src = imgSource

            this.crop = false

            this.$emit('onSetPhoto', imgSource)
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

        setImage(file)
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

                    this.crop        = true

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
.cropper {
	max-height: 95vh;
	background: #DDD;
}
.image-input{
    width: 15px !important;
}
</style>