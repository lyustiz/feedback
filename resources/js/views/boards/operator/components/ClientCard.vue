<template>
    <v-list-item :value="client.id">
          <v-list-item-avatar color="blue" size="60">
            <v-img :src="`https://api3.amolatina.com/users/${client.id}/photos/${client.thumbnail || 'nophoto'}.215x180.thumb-fd`" ></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
              <v-list-item-title>
                  <v-row dense>
                    <v-col cols="auto" class="text-capitalize">
                        {{client.name}}, <span class="font-weight-black">{{client.birthday.age}}</span>
                    </v-col>
                    <v-col> 
                        <v-icon :color="(client.status == 1) ? 'green' : 'red'" size="14"> 
                            {{(client.status == 1) ? 'mdi-checkbox-blank-circle' : 'mdi-checkbox-blank-circle-outline'}}
                        </v-icon> 
                    </v-col>
                    <v-col cols="auto" class="caption">
                       {{client.id}} <v-icon @click="copyText(client.id, 'ID')" size="16" dark color="amber">mdi-content-copy</v-icon>
                    </v-col>
                 </v-row>
              </v-list-item-title>
              <v-list-item-subtitle class="pt-2">
                <v-row dense>
                    <v-col>
                        {{client.location.city}} ({{client.location.country}})
                    </v-col>
                </v-row>
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon>
                <v-icon class="mt-6">mdi-dots-vertical</v-icon>
            </v-list-item-icon>
        </v-list-item>
</template>

<script>
import AppData from '@mixins/AppData'
export default {

    mixins:[AppData],

    props:
    {
        client: {
            type:       Object,
            default:   () => {}
        },
    },

    data: () => ({

    }) ,

    methods: {
        copyText(text, label = 'Texto') {
            navigator.clipboard.writeText(text).then(() => {
                this.showMessage(`${label} copiado`)
            }, function(err) {
                this.showError(`${label} No se pudo Copiar`+err)
                console.error('Async: Could not copy text: ', err);
            });
        }
    }

}
</script>

<style>

</style>