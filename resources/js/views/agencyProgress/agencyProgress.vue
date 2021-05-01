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
                        <td class="text-xs-left">{{ item.agency_id }}</td>
						<td class="text-xs-left">{{ item.day_positive }}</td>
						<td class="text-xs-left">{{ item.day_negative }}</td>
						<td class="text-xs-left">{{ item.month_positive }}</td>
						<td class="text-xs-left">{{ item.month_negative }}</td>
						<td class="text-xs-left">{{ item.total_positive }}</td>
						<td class="text-xs-left">{{ item.total_negative }}</td>
						<td class="text-xs-left">{{ item.task_mails }}</td>
						<td class="text-xs-left">{{ item.task_photos }}</td>
						<td class="text-xs-left">{{ item.task_videos }}</td>
						<td class="text-xs-left">{{ item.comments }}</td>
						<td class="text-xs-left">{{ item.status_id }}</td>
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
                <agency-progress-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></agency-progress-form>

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
import agencyProgressForm  from './agencyProgressForm';
export default {
    mixins:     [ listHelper],
    components: { 'agency-progress-form': agencyProgressForm },
    data () {
    return {
        title:    'AgencyProgress',
        resource: 'agencyProgress',
        headers: [
            { text: 'Agency Id',   value: 'agency_id' },
			{ text: 'Day Positive',   value: 'day_positive' },
			{ text: 'Day Negative',   value: 'day_negative' },
			{ text: 'Month Positive',   value: 'month_positive' },
			{ text: 'Month Negative',   value: 'month_negative' },
			{ text: 'Total Positive',   value: 'total_positive' },
			{ text: 'Total Negative',   value: 'total_negative' },
			{ text: 'Task Mails',   value: 'task_mails' },
			{ text: 'Task Photos',   value: 'task_photos' },
			{ text: 'Task Videos',   value: 'task_videos' },
			{ text: 'Comments',   value: 'comments' },
			{ text: 'Status Id',   value: 'status_id' },
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