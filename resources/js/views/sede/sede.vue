<template>

    <list-container :title="title" :head-color="$App.theme.headList" @onMenu="onMenu($event)">

        <template slot="HeadTools">
            <add-button @insItem="insertForm()"></add-button>
        </template>

            <v-col cols="12" md="6">
                <v-text-field
                    v-model="search"
                    append-icon="search"
                    label="Buscar"
                    hide-details
                    clearable
                    dense
                ></v-text-field>
            </v-col>

            <v-data-table
                :headers="headers"
                :items  ="items"
                :search ="search"
                item-key="id"
                :loading="loading"
                sort-by=""
            >

                <template v-slot:item="{ item }">
                    <tr>
                        <td class="text-xs-left">{{ item.nb_sede }}</td>
						<td class="text-xs-left">{{ item.tx_ubicacion }}</td>
						<td class="text-xs-left">{{ item.tx_mapa }}</td>
						<td class="text-xs-left">{{ item.tx_transmision }}</td>
						<td class="text-xs-left">{{ item.tx_icono }}</td>
						<td class="text-xs-left">{{ item.tx_telefono }}</td>
						<td class="text-xs-left">{{ item.tx_whatsapp }}</td>
						<td class="text-xs-left">{{ item.tx_observaciones }}</td>
						<td class="text-xs-left">
                            <status-switch 
                                :loading="loading" 
                                :resource="resource" 
                                :item="item" 
                                @onChangeStatus="changeStatus($event)">
                            </status-switch>
                        </td>
                        
                        <td class="text-xs-left">
                            <list-buttons 
                                @update="updateForm(item)" 
                                @delete="deleteForm(item)" >
                            </list-buttons>
                        </td>
                    </tr>
                </template>

            </v-data-table>

            <app-modal
                :modal="modal"
                @closeModal="closeModal()"
                :head-color="$App.theme.headModal"
                :title="title"
            >
                <sede-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></sede-form>

            </app-modal>

            <form-delete
                :dialog="dialog"
                :loading="loading"
                message="Desea eliminar el Registro Seleccionado?"
                @deleteItem="deleteItem()"
                @deleteCancel="deleteCancel()"
            ></form-delete>
            
            <pre v-if="$App.debug">{{ $data }}</pre>

    </list-container>

</template>

<script>
import listHelper from '@mixins/Applist';
import sedeForm  from './sedeForm';
export default {
    mixins:     [ listHelper],
    components: { 'sede-form': sedeForm },
    data () {
    return {
        title:    'Sede',
        resource: 'sede',
        headers: [
            { text: 'Sede',   value: 'nb_sede' },
			{ text: 'Ubicacion',   value: 'tx_ubicacion' },
			{ text: 'Mapa',   value: 'tx_mapa' },
			{ text: 'Transmision',   value: 'tx_transmision' },
			{ text: 'Icono',   value: 'tx_icono' },
			{ text: 'Telefono',   value: 'tx_telefono' },
			{ text: 'Whatsapp',   value: 'tx_whatsapp' },
			{ text: 'Observaciones',   value: 'tx_observaciones' },
			{ text: 'Status',   value: 'id_status' },
            { text: 'Acciones', value: 'actions', sortable: false, filterable: false },
        ],
    }
    },
    methods:
    {
   
    }
}
</script>

<style>
</style>