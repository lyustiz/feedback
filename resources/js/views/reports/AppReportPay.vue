<template>

    <v-card :loading="loading" flat class="main-color" dark>

        <v-card-title  class="subtitle-2">
            <v-row>
                <v-col>Reporte de Pago</v-col>
                <v-col cols="auto"><v-btn icon x-small dark @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn></v-col>
            </v-row>
        </v-card-title>

        <v-card-text>
       
         <v-form ref="form" v-model="valid" lazy-validation class="row mt-1">
            <!-- <v-row> -->
                <v-col cols="12" md="6">
                    <v-select
                        dense
                        outlined
                        filled
                        label="Tipo Reporte"
                        v-model="form.reportType"    
                        :items="reports"
                        :rules="[rules.required]"
                        hide-details
                        return-object
                    ></v-select>
                </v-col>

                <v-col cols="auto" md="4">
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="form.date"
                        transition="scale-transition"
                        offset-y
                        width="180px"
                        height="100px"
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="form.date"
                                label="Mes"
                                prepend-icon="mdi-calendar"
                                :rules="[rules.required]"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                dense
                                outlined
                                filled
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="form.date"
                            type="month"
                            no-title
                            scrollable
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            small
                            color="primary"
                            @click="menu = false"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            text
                            small
                            color="primary"
                            @click="$refs.menu.save(form.date)"
                        >
                            OK
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="auto" md="2">
                    <v-btn color="info" @click="getReport()"><v-icon left>mdi-clipboard-text-outline</v-icon> Ver</v-btn>
                </v-col>
            </v-form>

               <v-data-table
                v-if="items.length > 0"
                :headers="headers"
                :items  ="items"
                :search ="search"
                item-key="id"
                :loading="loading"
                sort-by=""
                width="100%"
            >

                <template v-slot:item="{ item }">
                    <tr>
                        <td class="text-xs-left">{{ item.nombre }}</td>
						<td class="text-xs-left">{{ item.apellido }}</td>
						<td class="text-xs-left">{{ item.mesa }}</td>
						<td class="text-xs-left">{{ item.turno }}</td>
						<td class="text-right">{{ item.puntos_mes }}</td>
						<td class="text-right">{{ item.total_bonus_puntos }}</td>
						<td class="text-right">{{ item.bonus_agencia }}</td>
						<td class="text-right">{{ item.bonus_in_house }}</td>
                        <td class="text-right">{{ item.penalty }}</td>
                        <td class="text-right">{{ item.bonus_total }}</td>
                    </tr>
                </template>

            </v-data-table>
        
        </v-card-text>

        <pre v-if="$App.debug">{{ $data }}</pre>

    </v-card>
    
  
</template>

<script>
import AppData from '@mixins/AppData'
export default {

    mixins: [AppData],

    data() {
        return {
            menu: false,
            form: {
                reportType: null,
                date:       null,
                isDdetail:  null
            },
            reports: [
                { value: 'operator', text: 'Reporte Operadores',  url: 'user/pay/operator/'  },
                { value: 'coordinator', text: 'Reporte Coordinador',  url: 'user/pay/coordinator/' }
            ],
            headers: [
                { text: 'Nombre',     value: 'nombre' },
                { text: 'Apellido',   value: 'apellido' },
                { text: 'Mesa',       value: 'mesa' },
                { text: 'Turno',      value: 'turno' },
                { text: 'Puntos',     value: 'puntos_mes' },
                { text: 'B. Puntos',  value: 'total_bonus_puntos' },
                { text: 'B. Agencia', value: 'bonus_agencia' },
                { text: 'B. InHouse', value: 'bonus_in_house' },
                { text: 'Penalty',    value: 'penalty' },
                { text: 'Total',      value: 'bonus_total' },
            ],
        }
    },

    methods:
    {
      getReport()
      {
        if (!this.$refs.form.validate())  return 
        this.getResource(`${this.form.reportType.url}${this.form.date}`).then( data => {
            this.items = data
        })
      }

      
    }
}
</script>

<style>

</style>