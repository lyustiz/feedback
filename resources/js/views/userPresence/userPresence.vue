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
                        <td>{{ item.profile_id }}</td>
						<td>{{ item.start_at }}</td>
						<td>{{ item.end_at }}</td>
						<td>{{ item.bonus }}</td>
						<td>{{ item.writeoff }}</td>
						<td>{{ item.shared }}</td>
						<td>{{ item.profit }}</td>
						<td>{{ item.comments }}</td>
						<td>{{ item.active }}</td>
						<td>
                            <status-switch 
                                :loading="loading" 
                                :resource="resource" 
                                :item="item" 
                                @onChangeStatus="changeStatus($event)">
                            </status-switch>
                        </td>
						<td>{{ item.user_id_ed }}</td>
                        
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
                <user-presence-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></user-presence-form>

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
import userPresenceForm  from './userPresenceForm';
export default {
    mixins:     [ Applist],
    components: { 'user-presence-form': userPresenceForm },
    data () {
    return {
        title:    'UserPresence',
        resource: 'userPresence',
        headers: [
            { text: 'Profile Id',   value: 'profile_id' },
			{ text: 'Start At',   value: 'start_at' },
			{ text: 'End At',   value: 'end_at' },
			{ text: 'Bonus',   value: 'bonus' },
			{ text: 'Writeoff',   value: 'writeoff' },
			{ text: 'Shared',   value: 'shared' },
			{ text: 'Profit',   value: 'profit' },
			{ text: 'Comments',   value: 'comments' },
			{ text: 'Active',   value: 'active' },
			{ text: 'Status Id',   value: 'status_id' },
			{ text: 'User Id Ed',   value: 'user_id_ed' },
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