<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-title class="subtitle-1 py-1">
      DashBoard
    </v-card-title>
    <v-card-text>
      <v-row dense>
        <v-col>
          <v-card color="blue" v-ripple @click="navigateToName('client')">
            <v-card-text>
              <v-row dense>
                <v-col cols="auto">
                  <v-icon size="18">mdi-account-cash</v-icon>
                </v-col>
                <v-col class="caption" >Clientes</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card color="green" v-ripple @click="navigateToName('comission')">
            <v-card-text>
              <v-row dense>
                <v-col cols="auto">
                  <v-icon size="18">mdi-sack</v-icon>
                </v-col>
                <v-col class="caption">Bonus</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card color="red" v-ripple @click="navigateToName('user-presence')">
            <v-card-text>
              <v-row dense>
                <v-col cols="auto">
                  <v-icon size="18">mdi-face-agent</v-icon>
                </v-col>
                <v-col class="caption" >Progreso</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    
    </v-card-text>
  </v-card>
</template>

<script>
export default {
 
}
</script>

<style>

</style>