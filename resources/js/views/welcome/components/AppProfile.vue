<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>Perfiles</v-subheader>
    <v-card-text class="pt-0">
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 
        <v-list-item v-for="cliente in clientes" :key="cliente.id" > 
          <v-list-item-avatar color="blue" size="81">
              <v-icon color="" size="75">mdi-account</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
              <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                  {{ cliente.day }}  /  {{ cliente.month}}
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                  3000
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                  <v-progress-linear
                  :value="cliente.day*100/cliente.month"
                  color="blue"
                  height="8"
                  class="mb-2 mt-1"
                  ></v-progress-linear>
              </v-col>
              </v-row>
              
              </v-list-item-title>
              <v-list-item-subtitle class="pt-2">
              <v-row>
                  <v-col>{{cliente.name}}</v-col>
                  <v-col>
                  <v-rating
                      full-icon="mdi-circle-off-outline"
                      :value="cliente.fault"
                      :length="cliente.fault"
                      color="red"
                      background-color="grey lighten-1"
                      small
                      readonly
                  ></v-rating>
                  </v-col>
              </v-row>
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon>
                <v-icon class="mt-6">mdi-dots-vertical</v-icon>
            </v-list-item-icon>
        </v-list-item>
      </v-list>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
 data: () => ({
    clientes:[
       { id: 1, name: 'Luis Jose', month: 330, day: 30, fault: 2},
       { id: 2, name: 'Roberto Marques', month: 530, day: 21, fault: 4} ,
       { id: 3, name: 'Raul Garcia', month: 830, day: 100, fault: 1} ,
       { id: 4, name: 'Laura Miranda', month: 230, day: 15, fault: 0} 
    ]
  }),
}
</script>

<style>

</style>