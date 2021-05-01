<template>
  <v-card dark class="rounded-lg" color="rgba(0,0,0,0.4)">
    <v-card-title primary-title>
      DashBoard
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col>
          <v-card color="blue" v-ripple>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-icon size="34">mdi-gift</v-icon>
                </v-col>
                <v-col class="pt-4">Bonus</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card color="green" v-ripple>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-icon size="34">mdi-sack</v-icon>
                </v-col>
                <v-col class="pt-4">Ganancias</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-card color="amber" v-ripple>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-icon size="34">mdi-chart-areaspline</v-icon>
                </v-col>
                <v-col class="pt-4">Progresos</v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card color="red" v-ripple>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-icon size="34">mdi-gavel</v-icon>
                </v-col>
                <v-col class="pt-4">Faltas</v-col>
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