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
						<td>{{ item.progress_day }}</td>
						<td>{{ item.progress_month }}</td>
						<td>{{ item.progress_total }}</td>
						<td>{{ item.progress_max_day }}</td>
						<td>{{ item.progress_max_month }}</td>
						<td>{{ item.crowns }}</td>
						<td>{{ item.hearts }}</td>
						<td>{{ item.milestone_day }}</td>
						<td>{{ item.milestone_month }}</td>
						<td>{{ item.task_mails }}</td>
						<td>{{ item.task_photos }}</td>
						<td>{{ item.task_videos }}</td>
						<td>{{ item.comments }}</td>
						<td>{{ item.status_id }}</td>
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
                <profile-progress-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></profile-progress-form>

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
import profileProgressForm  from './profileProgressForm';
export default {
    mixins:     [ Applist],
    components: { 'profile-progress-form': profileProgressForm },
    data () {
    return {
        title:    'ProfileProgress',
        resource: 'profileProgress',
        headers: [
            { text: 'Profile Id',   value: 'profile_id' },
			{ text: 'Progress Day',   value: 'progress_day' },
			{ text: 'Progress Month',   value: 'progress_month' },
			{ text: 'Progress Total',   value: 'progress_total' },
			{ text: 'Progress Max Day',   value: 'progress_max_day' },
			{ text: 'Progress Max Month',   value: 'progress_max_month' },
			{ text: 'Crowns',   value: 'crowns' },
			{ text: 'Hearts',   value: 'hearts' },
			{ text: 'Milestone Day',   value: 'milestone_day' },
			{ text: 'Milestone Month',   value: 'milestone_month' },
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