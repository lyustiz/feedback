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
                        <td>{{ item.name }}</td>
						<td>{{ item.traslate }}</td>
						<td>{{ item.value }}</td>
						<td>{{ item.type }}</td>
						<td>{{ item.positive }}</td>
						<td>{{ item.ammount }}</td>
						<td>{{ item.icon }}</td>
						<td>{{ item.color }}</td>
						<td>{{ item.comments }}</td>
						<td>
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
                <service-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></service-form>

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
import Applist from '@mixins/Applist';
import serviceForm  from './serviceForm';
export default {
    mixins:     [ Applist],
    components: { 'service-form': serviceForm },
    data () {
    return {
        title:    'Service',
        resource: 'service',
        headers: [
            { text: 'Name',   value: 'name' },
			{ text: 'Traslate',   value: 'traslate' },
			{ text: 'Value',   value: 'value' },
			{ text: 'Type',   value: 'type' },
			{ text: 'Positive',   value: 'positive' },
			{ text: 'Ammount',   value: 'ammount' },
			{ text: 'Icon',   value: 'icon' },
			{ text: 'Color',   value: 'color' },
			{ text: 'Comments',   value: 'comments' },
			{ text: 'Status Id',   value: 'status_id' },
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