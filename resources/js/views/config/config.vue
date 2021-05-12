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
						<td>{{ item.type }}</td>
						<td>{{ item.group }}</td>
						<td>{{ item.value }}</td>
						<td>{{ item.start_at }}</td>
						<td>{{ item.end_at }}</td>
						<td>{{ item.comments }}</td>
						<td>{{ item.active }}</td>
						<td>{{ item.user_id }}</td>
                        
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
import Applist from '@mixins/Applist';
import configForm  from './configForm';
export default {
    mixins:     [ Applist],
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