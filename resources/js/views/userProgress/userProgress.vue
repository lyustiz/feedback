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
                        <td class="text-xs-left">{{ item.user_id }}</td>
						<td class="text-xs-left">{{ item.progress_day }}</td>
						<td class="text-xs-left">{{ item.progress_month }}</td>
						<td class="text-xs-left">{{ item.progress_total }}</td>
						<td class="text-xs-left">{{ item.progress_max_day }}</td>
						<td class="text-xs-left">{{ item.progress_max_month }}</td>
						<td class="text-xs-left">{{ item.rank }}</td>
						<td class="text-xs-left">{{ item.milestone_day }}</td>
						<td class="text-xs-left">{{ item.milestone_month }}</td>
						<td class="text-xs-left">{{ item.comments }}</td>
						<td class="text-xs-left">{{ item.status_id }}</td>
						<td class="text-xs-left">{{ item.user_id_ed }}</td>
                        
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
                <user-progress-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></user-progress-form>

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
import userProgressForm  from './userProgressForm';
export default {
    mixins:     [ listHelper],
    components: { 'user-progress-form': userProgressForm },
    data () {
    return {
        title:    'UserProgress',
        resource: 'userProgress',
        headers: [
            { text: 'User Id',   value: 'user_id' },
			{ text: 'Progress Day',   value: 'progress_day' },
			{ text: 'Progress Month',   value: 'progress_month' },
			{ text: 'Progress Total',   value: 'progress_total' },
			{ text: 'Progress Max Day',   value: 'progress_max_day' },
			{ text: 'Progress Max Month',   value: 'progress_max_month' },
			{ text: 'Rank',   value: 'rank' },
			{ text: 'Milestone Day',   value: 'milestone_day' },
			{ text: 'Milestone Month',   value: 'milestone_month' },
			{ text: 'Comments',   value: 'comments' },
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