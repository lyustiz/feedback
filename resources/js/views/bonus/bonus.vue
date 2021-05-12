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
                        <td>{{ item.bonus_id }}</td>
						<td>{{ item.service }}</td>
						<td>{{ item.fact }}</td>
						<td>{{ item.cllient_id }}</td>
						<td>{{ item.profile_id }}</td>
						<td>{{ item.points }}</td>
						<td>{{ item.profit }}</td>
						<td>{{ item.share }}</td>
						<td>{{ item.comments }}</td>
                        
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
                <bonus-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></bonus-form>

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
import bonusForm  from './bonusForm';
export default {
    mixins:     [ Applist],
    components: { 'bonus-form': bonusForm },
    data () {
    return {
        title:    'Bonus',
        resource: 'bonus',
        headers: [
            { text: 'Bonus Id',   value: 'bonus_id' },
			{ text: 'Service',   value: 'service' },
			{ text: 'Fact',   value: 'fact' },
			{ text: 'Cllient Id',   value: 'cllient_id' },
			{ text: 'Profile Id',   value: 'profile_id' },
			{ text: 'Points',   value: 'points' },
			{ text: 'Profit',   value: 'profit' },
			{ text: 'Share',   value: 'share' },
			{ text: 'Comments',   value: 'comments' },
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