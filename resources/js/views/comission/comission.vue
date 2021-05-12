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
                        <td>{{ item.comission_id }}</td>
						<td>{{ item.fact }}</td>
						<td>{{ item.service }}</td>
						<td>{{ item.points }}</td>
						<td>{{ item.profit }}</td>
						<td>{{ item.share }}</td>
						<td>{{ item.agency_id }}</td>
						<td>{{ item.curator_id }}</td>
						<td>{{ item.profile_id }}</td>
						<td>{{ item.cllient_id }}</td>
						<td>{{ item.comments }}</td>
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
                <comission-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></comission-form>

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
import comissionForm  from './comissionForm';
export default {
    mixins:     [ Applist],
    components: { 'comission-form': comissionForm },
    data () {
    return {
        title:    'Comission',
        resource: 'comission',
        headers: [
            { text: 'Comission Id',   value: 'comission_id' },
			{ text: 'Fact',   value: 'fact' },
			{ text: 'Service',   value: 'service' },
			{ text: 'Points',   value: 'points' },
			{ text: 'Profit',   value: 'profit' },
			{ text: 'Share',   value: 'share' },
			{ text: 'Agency Id',   value: 'agency_id' },
			{ text: 'Curator Id',   value: 'curator_id' },
			{ text: 'Profile Id',   value: 'profile_id' },
			{ text: 'Cllient Id',   value: 'cllient_id' },
			{ text: 'Comments',   value: 'comments' },
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