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
						<td class="text-xs-left">{{ item.name_alt }}</td>
						<td class="text-xs-left">{{ item.code }}</td>
						<td class="text-xs-left">{{ item.group }}</td>
						<td class="text-xs-left">{{ item.icon }}</td>
						<td class="text-xs-left">{{ item.color }}</td>
						<td class="text-xs-left">{{ item.parent }}</td>
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
                <status-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></status-form>

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
import statusForm  from './statusForm';
export default {
    mixins:     [ listHelper],
    components: { 'status-form': statusForm },
    data () {
    return {
        title:    'Status',
        resource: 'status',
        headers: [
            { text: 'Name',   value: 'name' },
			{ text: 'Name Alt',   value: 'name_alt' },
			{ text: 'Code',   value: 'code' },
			{ text: 'Group',   value: 'group' },
			{ text: 'Icon',   value: 'icon' },
			{ text: 'Color',   value: 'color' },
			{ text: 'Parent',   value: 'parent' },
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