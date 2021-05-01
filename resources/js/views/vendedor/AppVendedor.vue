<template>

<v-card >

    <v-card-title class="pa-0">
            <app-simple-toolbar dense :title="title" background-color="deep-orange" @closeModal="$emit('closeModal')"></app-simple-toolbar>
        </v-card-title>

        <v-card-text>

            <v-row class="my-2">
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

                <v-spacer></v-spacer>

                <v-col cols="auto">
                    <add-button @insItem="insertForm()"></add-button>
                </v-col>
            </v-row>

            <v-data-table
                :headers="headers"
                :items  ="items"
                :search ="search"
                item-key="id"
                :loading="loading"
                sort-by=""
                :items-per-page="20"
            >

                <template v-slot:item="{ item }">
                    <tr>
                        <td class="text-xs-left">
                            <v-row no-gutters>
                                <v-col>{{ item.nb_vendedor }}</v-col>
                                <v-col cols="auto">
                                    <list-simple-icon 
                                        v-if="item.tx_observaciones"
                                        :size="20" class="mx-2"
                                        :label="(item.tx_observaciones) ? item.tx_observaciones : '-'" 
                                        icon="mdi-alert-circle" color="red">
                                    </list-simple-icon>
                                </v-col>
                            </v-row>
                        </td>
						<td class="text-xs-left">{{ item.tx_documento }}</td>
						<td class="text-xs-left">{{ item.tx_telefono }}</td>
						<td class="text-xs-left">{{ item.tx_telefono2 }}</td>
						<td class="text-xs-left">{{ item.tx_direccion }}</td>
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
                <vendedor-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                    v-if="modal"
                ></vendedor-form>

            </app-modal>

            <form-delete
                :dialog="dialog"
                :loading="loading"
                message="Desea eliminar el Registro Seleccionado?"
                @deleteItem="deleteItem()"
                @deleteCancel="deleteCancel()"
            ></form-delete>
            
            <pre v-if="$App.debug">{{ $data }}</pre>

        </v-card-text>
        
    </v-card>

</template>

<script>
import listHelper from '@mixins/Applist';
import vendedorForm  from './vendedorForm';
export default {
    mixins:     [ listHelper],
    components: { 'vendedor-form': vendedorForm },
    data () {
    return {
        title:    'Vendedor',
        resource: 'vendedor',
        headers: [
            { text: 'Vendedor',   value: 'nb_vendedor' },
			{ text: 'Documento',   value: 'tx_documento' },
			{ text: 'Telefono',   value: 'tx_telefono' },
			{ text: 'Telefono2',   value: 'tx_telefono2' },
			{ text: 'Direccion',   value: 'tx_direccion' },
			{ text: 'Observaciones',   value: 'tx_observaciones' },
			{ text: 'Status',   value: 'id_status' },
            { text: 'Acciones', value: 'actions', sortable: false, filterable: false },
        ],
    }
    },
    methods:
    {
         postResponse(action)
        {
            if(action == 'delete')
            {
                this.$emit('updateData')
            }
        },

        closeModal()
        {
            this.action = '';
            this.modal  = false;
            this.item   = {};
            this.list();
            this.$emit('updateData')
        },
   
    }
}
</script>

<style>
</style>