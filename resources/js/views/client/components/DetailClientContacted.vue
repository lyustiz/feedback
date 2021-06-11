<template>
<v-card flat dark class="main" height="90vh">
  <v-card-title class="px-3 py-1 subtitle-1">
    <v-row dense>
      <v-col>Nuevos Clientes ({{ type }}) </v-col>
      <v-col cols="auto">
        <v-btn icon x-small dark @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn>
      </v-col>
    </v-row>
  </v-card-title>
  <v-card-text >

    <v-row dense>
      <v-col>
        <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            hide-details
            clearable
            dense
        ></v-text-field>
      </v-col>
    </v-row>

    <v-data-table
                :headers="headers"
                :items  ="items"
                :search ="search"
                item-key="id"
                :loading="loading"
                sort-by=""
                dense
            >

                <template v-slot:item="{ item }">
                    <tr>
                        <td>
                           <v-row no-gutters justify="center" align="center">
                            <v-col cols="auto">
                              <v-badge offset-x="20" offset-y="20" overlap color="amber" :value="item.crown > 0" icon="mdi-crown">
                                <v-avatar color="blue" :size="30" class="mr-3">
                                  <v-img :src="`/storage/photo/client/${item.photo || 'nophoto'}.jpg`" ></v-img> 
                                </v-avatar>
                              </v-badge>
                            </v-col>
                            <v-col>
                              <v-row no-gutters>
                                <v-col cols="12" class="caption">{{ item.name }} {{ (item.age) ? `(${item.age})` : null }} </v-col>
                                <v-col  cols="12" class="caption">{{ item.amolatina_id }} </v-col>
                              </v-row>
                            </v-col>
                          </v-row>
                        </td>
                        <td>
                          <v-avatar color="blue" class="elevation-3" :size="30">
                            <v-img :src="`/storage/photo/profile/${(item.comission_contacted.profile) ? item.comission_contacted.profile.photo : 'nophoto' || 'nophoto'}.jpg`" ></v-img> 
                          </v-avatar>
                          {{ ( item.comission_contacted.profile ) ? item.comission_contacted.profile.name : null }}
                        </td>
                        <td>
                          <list-simple-icon  
                            :size="24"
                            :icon="item.comission_contacted.has_service.icon" 
                            :label="item.comission_contacted.has_service.name"
                            :color="item.comission_contacted.has_service.color"
                            v-if="item.comission_contacted.has_service"
                          ></list-simple-icon>
                          <list-simple-icon  
                            :size="24"
                            icon="mdi-comment-question" 
                            :label="comission.service"
                            color="amber"
                            v-else
                          ></list-simple-icon>
                        </td>
                        <td>{{ formatNumber(item.points) }}</td>
                        <td>{{ formatDateString(item.contacted_at) }}</td>
                    </tr>
                </template>

            </v-data-table>

  </v-card-text>
</v-card>
</template>

<script>
import Applist from '@mixins/Applist';
export default {

  mixins:[Applist],

  props: 
  {
    agency: {
        type: Object,
        default: () => {}
    },

    type: {
        type: String,
        default: 'day'
    }
  },

  data: () => ({
    clients:  [],
    headers: [
      { text: 'Cliente', value: 'amolatina_id' },
      { text: 'Perfil',  value: 'comission_contacted.profile.name' },
      { text: 'Service', value: 'comission_contacted.profile.name' },
      { text: 'Points',  value: 'points' },
      { text: 'Fecha',   value: 'contacted_at' },
    ],
  }),

  methods:
  {
    /* list()
    {
      this.getResource(`client/contacted/agency/${this.agency.id}?type=${this.type}`).then( data => {
        this.items = data;
      })
    } */

    listUrl()
    {
      return this.apiUrl + `client/contacted/agency/${this.agency.id}?type=${this.type}`
    },
  }



}
</script>

<style>

</style>