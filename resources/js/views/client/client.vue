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
                        <td>{{ item.amolatina_id }}</td>
						<td>{{ item.name }}</td>
						<td>{{ item.birthday }}</td>
						<td>{{ item.age }}</td>
						<td>{{ item.photo }}</td>
						<td>{{ item.gender }}</td>
						<td>{{ item.preference }}</td>
						<td>{{ item.country }}</td>
						<td>{{ item.city }}</td>
						<td>{{ item.profit }}</td>
						<td>{{ item.crown }}</td>
						<td>{{ item.contacted_at }}</td>
						<td>{{ item.last_contact }}</td>
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
                <client-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></client-form>

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
import clientForm  from './clientForm';
export default {
    mixins:     [ Applist],
    components: { 'client-form': clientForm },
    data () {
    return {
        title:    'Client',
        resource: 'client',
        headers: [
            { text: 'Amolatina Id',   value: 'amolatina_id' },
			{ text: 'Name',   value: 'name' },
			{ text: 'Birthday',   value: 'birthday' },
			{ text: 'Age',   value: 'age' },
			{ text: 'Photo',   value: 'photo' },
			{ text: 'Gender',   value: 'gender' },
			{ text: 'Preference',   value: 'preference' },
			{ text: 'Country',   value: 'country' },
			{ text: 'City',   value: 'city' },
			{ text: 'Profit',   value: 'profit' },
			{ text: 'Crown',   value: 'crown' },
			{ text: 'Contacted At',   value: 'contacted_at' },
			{ text: 'Last Contact',   value: 'last_contact' },
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