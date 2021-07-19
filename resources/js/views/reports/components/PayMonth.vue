<template>
 <v-card :loading="loading" flat class="main-color" dark>

        <v-card-title  class="subtitle-2">
            <v-row>
                <v-col>Reporte de Pago</v-col>
                <v-col cols="auto"><v-btn icon x-small dark @click="$emit('closeDialog')"><v-icon>mdi-close-circle</v-icon></v-btn></v-col>
            </v-row>
        </v-card-title>

        <v-card-text>
            
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
						<td class="text-xs-left">{{ item.mesa }} {{ (item.is_alternate == 1) ? '*': null}}</td>
						<td class="text-xs-left">{{ item.turno }}({{item.work_time}}H)</td>
                        <td class="text-xs-left">{{ item.salary_fortnight }}</td>
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
export default {
 
}
</script>

<style>

</style>