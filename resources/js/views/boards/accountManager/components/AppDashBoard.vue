<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-title primary-title>
      DashBoard
    </v-card-title>
    <v-card-text>
    
      <v-row dense>
        <v-col>
          <v-card color="green" v-ripple @click="navigateToName('table')">
            <v-card-text>
              <v-row dense>
                <v-col>
                  <v-icon size="34">mdi-table-furniture</v-icon>
                </v-col>
                <v-col class="pt-4">Mesas</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col>
          <v-card color="amber" v-ripple @click="navigateToName('turn')">
            <v-card-text>
              <v-row dense>
                <v-col>
                  <v-icon size="34">mdi-clock</v-icon>
                </v-col>
                <v-col class="pt-4">Turno</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card color="brown" v-ripple @click="navigateToName('group')">
            <v-card-text>
              <v-row dense>
                <v-col>
                  <v-icon size="34">mdi-account-group</v-icon>
                </v-col>
                <v-col class="pt-4">Grupo</v-col>
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