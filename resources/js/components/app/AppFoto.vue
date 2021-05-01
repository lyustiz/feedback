<template>
  <v-avatar color="deep-orange" size="38">
    <v-file-input 
        dark
        accept="image/*" 
        :capture="capture" 
        v-model="imageUpload" 
        hide-input
        prepend-icon="mdi-image-plus" 
        class="pl-2 mt-n3"
        :loading="loading"
        :disabled="disabled"
        @change="setImage()">
        <template v-slot:selection></template>
    </v-file-input>
  </v-avatar>
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

        origen: {
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

    data () {
        return {
            imageUpload: null,
            rawImg:      null,
            loading:     false,
            image:       null,
        }
    },

    methods:
    {
        store()
        {
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
              this.store()
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