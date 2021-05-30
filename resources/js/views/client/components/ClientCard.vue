<template>

  <v-list-item :value="client.id" > 
    
    <v-list-item-avatar color="blue" size="55">
      <v-img :src="`/storage/photo/client/${client.photo || 'nophoto'}.jpg`" ></v-img> 
    </v-list-item-avatar>

    <v-list-item-content>

      <v-list-item-title>
        <v-row no-gutters>
            <v-col class="caption">{{client.name}}</v-col>
            <v-col cols="auto" class="caption">{{client.amolatina_id}}</v-col>
        </v-row>
      </v-list-item-title>

      <v-list-item-subtitle class="pt-2">
        <v-row>
          <v-col cols="auto"><v-icon color="yellow darken-1">mdi-crown</v-icon>{{client.crown}}</v-col>
          <v-col cols="auto"><list-icon :data="sexIcons" :value="client.gender"></list-icon></v-col>  
          <v-col class="text-left">{{ formatNumber(client.points)}}</v-col>
        </v-row>
        </v-list-item-subtitle>
      </v-list-item-content>

      <v-list-item-icon v-if="hasMenu">
          <v-icon class="mt-6">mdi-dots-vertical</v-icon>
      </v-list-item-icon>

  </v-list-item>
</template>

<script>
import AppFormat from '@mixins/AppFormat'
export default {

  mixins: [AppFormat],

  props:{
      client :{
          type: Object,
          default: () => {}
      },
      hasMenu :{
          type: Boolean,
          default: false
      }
  }
}
</script>

<style>

</style>