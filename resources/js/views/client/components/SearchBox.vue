<template>
    <v-card>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-card-text>
             <v-row dense>
                <v-col cols="12">
                    <v-autocomplete
                      v-model="country"
                      :items="countries"
                      :rules="[ rules.select ]"
                      item-value="code"
                      item-text="name"
                      label="Country"
                      return-object
                      hide-details
                      outlined
                      filled
                      dense
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="12">
                  <v-select
                        :items="sexOptions"
                        v-model="sex"
                        label="Sex"
                        item-text="name"
                        hide-details
                        :rules="[ rules.select ]"
                        return-object
                        outlined
                        filled
                        dense
                  >
                    <template v-slot:item="{item}">
                        <v-row dense class="grey lighten-5 subtitle-1">
                        <v-col>
                            {{item.name}}
                        </v-col>
                        <v-col cols="auto">
                            <v-icon :color="item.color">{{item.icon}}</v-icon>
                        </v-col>
                        <v-col cols="auto">
                            <v-icon :color="item.color_alt">{{item.icon_alt}}</v-icon>
                        </v-col>
                        </v-row>
                    </template>
                  
                  </v-select>
                </v-col>

                <v-col class="mt-1 ml-1 title">
                  Edad:
                </v-col>

                <v-col cols="4">
                    <v-select 
                      v-model="ageFrom"
                      :items="agesFrom"
                      :rules="[ rules.select ]"
                      hide-details
                      outlined
                      filled
                      dense
                    >
                    </v-select>
                </v-col>

                <v-col cols="auto" class="mt-2">
                  -
                </v-col>

                <v-col cols="4">
                    <v-select 
                      v-model="ageTo"
                      :items="agesTo"
                      :rules="[ rules.select ]"
                      hide-details
                      outlined
                      filled
                      dense
                    >
                    </v-select>
                </v-col>

                <v-col cols="12">
                  <v-select
                        :items="resultsSel"
                        v-model="results"
                        label="Resultados"
                        hide-details
                        :rules="[ rules.select ]"
                        outlined
                        filled
                        dense
                  ></v-select>
                </v-col>

                <v-col cols="12">
                  <v-btn depressed block dark color="blue darken-4" @click="searchPeople()">Buscar Clientes</v-btn>
                </v-col>
            </v-row> 
          

        </v-card-text>
      </v-form>
    </v-card>
</template>

<script>
import AppData from '@mixins/AppData' 
export default {

    created()
    {
      this.getCountries()
    },

    mixins:[AppData],

    data: ()=>({

      country: null,
      ageFrom: null,
      ageTo:   null,
      agesFrom:   [18,20,25,30,35,40,45,50,55,60,65,70,75],
      agesTo:     [20,25,30,35,40,45,50,55,60,65,70,75,80],
      resultsSel: [20,50,100,150,200],
      countries:  [],
      sex: null,
      sexFrom: null,
      sexTo:   null,
      results: 20,
      sexOptions: [
          { name: 'Hombre -> Mujer',  from: 'mal', to: 'fem', icon: 'mdi-human-male', icon_alt: 'mdi-human-female', color: 'blue', color_alt: 'pink' },
          { name: 'Mujer  -> Hombre', from: 'fem', to: 'mal', icon: 'mdi-human-female', icon_alt: 'mdi-human-male', color: 'pink', color_alt: 'blue' },
          { name: 'Hombre -> Hombre', from: 'mal', to: 'mal', icon: 'mdi-human-male', icon_alt: 'mdi-human-male', color: 'blue', color_alt: 'blue' },
          { name: 'Mujer  -> Mujer',  from: 'fem', to: 'fem', icon: 'mdi-human-female', icon_alt: 'mdi-human-female', color: 'pink', color_alt: 'pink' },
      ]
    }),

    methods:{
      getCountries(){
          this.getResource('country').then(data =>{
              this.countries = data
          })
      },

      searchPeople()
      {
        if (!this.$refs.form.validate())  return 

        let ageFrom  = (this.ageFrom > this.ageTo ) ? this.ageTo   : this.ageFrom
        let ageTo    = (this.ageTo < this.ageFrom ) ? this.ageFrom : this.ageTo
        this.$emit('onSearch', { country: this.country, ageFrom: ageFrom, ageTo: ageTo, sex: this.sex, results: this.results })
      }
    }
  
}
</script>

<style>

</style>