<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-title primary-title>
      DashBoard
    </v-card-title>
    <v-card-text>
      <v-row dense>
        <v-col>
          <v-card color="blue" v-ripple @click="navigateToName('client')">
            <v-card-text>
              <v-row dense>
                <v-col cols="auto">
                  <v-icon size="34">mdi-account-cash</v-icon>
                </v-col>
                <v-col >Clientes</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card color="green" v-ripple @click="navigateToName('comission')">
            <v-card-text>
              <v-row dense>
                <v-col cols="auto">
                  <v-icon size="34">mdi-sack</v-icon>
                </v-col>
                <v-col>Bonus</v-col>
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