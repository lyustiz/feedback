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
						<td>{{ item.name_alt }}</td>
						<td>{{ item.code }}</td>
						<td>{{ item.group }}</td>
						<td>{{ item.icon }}</td>
						<td>{{ item.color }}</td>
						<td>{{ item.parent }}</td>
						<td>{{ item.comments }}</td>
						<td>{{ item.active }}</td>
                        
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
import Applist from '@mixins/Applist';
import statusForm  from './statusForm';
export default {
    mixins:     [ Applist],
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