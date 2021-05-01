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
                        <td class="text-xs-left">{{ item.uuid }}</td>
						<td class="text-xs-left">{{ item.connection }}</td>
						<td class="text-xs-left">{{ item.queue }}</td>
						<td class="text-xs-left">{{ item.payload }}</td>
						<td class="text-xs-left">{{ item.exception }}</td>
						<td class="text-xs-left">{{ item.failed_at }}</td>
                        
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
                <failed-jobs-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></failed-jobs-form>

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
import failedJobsForm  from './failedJobsForm';
export default {
    mixins:     [ listHelper],
    components: { 'failed-jobs-form': failedJobsForm },
    data () {
    return {
        title:    'FailedJobs',
        resource: 'failedJobs',
        headers: [
            { text: 'Uuid',   value: 'uuid' },
			{ text: 'Connection',   value: 'connection' },
			{ text: 'Queue',   value: 'queue' },
			{ text: 'Payload',   value: 'payload' },
			{ text: 'Exception',   value: 'exception' },
			{ text: 'Failed At',   value: 'failed_at' },
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