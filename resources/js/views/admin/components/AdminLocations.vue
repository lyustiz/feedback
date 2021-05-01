<template>
  <v-card>

    <v-card-title class="grey lighten-4">
      <v-row>
        <v-col>
          <h3 class="headline mb-0">Sedes</h3>
        </v-col>
        <v-col cols="auto">
          <v-btn icon x-small fab @click="addSede()" color="deep-orange"><v-icon size="36" color="deep-orange">mdi-plus-circle-outline</v-icon></v-btn>
        </v-col>
      </v-row>
    </v-card-title>
    
    <v-card-text>
      <v-container>

          <v-row>
              <v-col cols="12" md="6" lg="4"  v-for="sede in items" :key="sede.id">
                  <v-card>
                    <v-img :src=" (sede.foto) ?  sede.foto.full_url : '/storage/foto/sede/colombia.jpg'" height="200px">
                      <v-row>
                        <v-col>
                            <status-switch 
                                class="pt-3 ml-2"
                                :loading="loading" 
                                :resource="resource" 
                                :item="sede" 
                                @onChangeStatus="list()">
                            </status-switch>
                        </v-col>
                        <v-col cols="auto">
                          <AppFoto :tipo-foto="2" :origen="sede.id" @storeImage="list()" class="mt-1 mr-1"></AppFoto>
                        </v-col>
                      </v-row>
                    </v-img>
                      
                      <v-card-text>

                        <v-row>

                          <v-col cols="12" >
                            <div class="headline d-block deep-orange--text text-capitalize">{{sede.nb_sede}}</div>
                            <div class="caption d-block">{{(sede.tx_ubicacion) ? sede.tx_ubicacion : 'Ubicacion no Indicada!'  }}</div>
                          </v-col>
  
                          <v-col cols="12" >
                            <v-row dense>
                              <v-col class="text-center">
                                <v-tooltip bottom color="red">
                                  <template v-slot:activator="{ on }">
                                    <v-icon color="red" v-on="on" size="30">mdi-television-play</v-icon>
                                  </template>
                                  <span>{{sede.tx_transmision}}</span>
                                </v-tooltip>
                              </v-col>
                              <v-col class="text-center">
                                <v-tooltip bottom>
                                  <template v-slot:activator="{ on }">
                                    <v-icon color="yellow" v-on="on" size="30">mdi-map-marker-radius-outline</v-icon>
                                  </template>
                                  <span>{{sede.tx_mapa}}</span>
                                </v-tooltip>
                              </v-col>
                              <v-col class="text-center">
                                <v-tooltip bottom color="blue">
                                  <template v-slot:activator="{ on }">
                                    <v-icon color="blue" v-on="on" size="30">mdi-phone</v-icon>
                                  </template>
                                  <span>{{sede.tx_telefono}}</span>
                                </v-tooltip>
                              </v-col>
                              <v-col class="text-center">
                                <v-tooltip bottom color="green">
                                  <template v-slot:activator="{ on }">
                                    <v-icon color="green" v-on="on" size="30">mdi-whatsapp</v-icon>
                                  </template>
                                  <span>{{sede.tx_whatsapp}}</span>
                                </v-tooltip>
                              </v-col>
                            </v-row>
                            </v-col>
                          </v-row>
                      </v-card-text>
                      <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn fab x-small color="error" class="mx-1" @click=" deleteForm(sede)"><v-icon>mdi-delete</v-icon></v-btn>
                          <v-btn fab dark small color="amber" class="mx-1" @click="updateForm(sede)"><v-icon>mdi-pencil</v-icon></v-btn>
                      </v-card-actions>
                  </v-card>
              </v-col>

          </v-row>
  
      </v-container>
    </v-card-text>

     <v-dialog
        v-model="modal"
        @closeModal="closeModal()"
        width="50rem"
      >
        <sede-form
            :action="action"
            :item="item"
            @closeModal="closeModal()"
        ></sede-form>
    </v-dialog>

    <v-dialog
        v-model="newSede"
        @closeModal="closeModal()"
        width="30rem"
      >
        <v-card>
          <v-card-text>
            <v-row class="pt-6">
              <v-col>
                <v-text-field
                  v-model="form.nb_sede"
                  label="Sede"
                  placeholder="Nombre Sede"
                  prepend-icon="mdi-store"
                  color="deep-orange"
                  dense
                  solo
                ></v-text-field>
              </v-col>
              <v-col cols="auto">
                <v-btn x-small fab @click="store()" color="success" :loading="loading"><v-icon>mdi-plus</v-icon></v-btn>
                <v-btn x-small fab @click="newSede=false" color="error" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
    </v-dialog>

    <form-delete
        :dialog="dialog"
        :loading="loading"
        :message="`Desea eliminar ${item.nb_sede} ? `"
        @deleteItem="deleteItem()"
        @deleteCancel="deleteCancel()"
    ></form-delete>

    <v-overlay :opacity="0.3" :value="loading">
        <v-icon size="50" class="mdi-spin">mdi-loading</v-icon>
    </v-overlay>

  </v-card>
</template>

<script>

import listHelper from '@mixins/Applist';
import sedeForm  from './AdminLocationsForm';
export default {

    mixins:     [ listHelper],

    components: { 
      'sede-form': sedeForm 
    },

    data () {
      return {
        title:    'Sede',
        resource: 'sede',
        newSede:  false,
        form: {
          nb_sede: '',
          id_status: 2,
          id_usuario: 1
        }
      }
    },

    methods:
    {
      addSede()
      {
        this.form.nb_sede = null
        this.newSede = true
      },

      store()
      {
        axios.post(this.fullUrl, this.form)
        .then(response => 
        {
          this.list()
          this.newSede = false
        })
        .catch(error => 
        {
            this.showError(error);
        })
      }
    }
}
</script>

<style>

</style>