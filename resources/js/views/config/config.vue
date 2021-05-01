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
                        <td class="text-xs-left">{{ item.name }}</td>
						<td class="text-xs-left">{{ item.type }}</td>
						<td class="text-xs-left">{{ item.group }}</td>
						<td class="text-xs-left">{{ item.value }}</td>
						<td class="text-xs-left">{{ item.start_at }}</td>
						<td class="text-xs-left">{{ item.end_at }}</td>
						<td class="text-xs-left">{{ item.comments }}</td>
						<td class="text-xs-left">{{ item.active }}</td>
						<td class="text-xs-left">{{ item.user_id }}</td>
                        
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
                <config-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></config-form>

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
import configForm  from './configForm';
export default {
    mixins:     [ listHelper],
    components: { 'config-form': configForm },
    data () {
    return {
        title:    'Config',
        resource: 'config',
        headers: [
            { text: 'Name',   value: 'name' },
			{ text: 'Type',   value: 'type' },
			{ text: 'Group',   value: 'group' },
			{ text: 'Value',   value: 'value' },
			{ text: 'Start At',   value: 'start_at' },
			{ text: 'End At',   value: 'end_at' },
			{ text: 'Comments',   value: 'comments' },
			{ text: 'Active',   value: 'active' },
			{ text: 'User Id',   value: 'user_id' },
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