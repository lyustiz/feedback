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
						<td>{{ item.label }}</td>
						<td>{{ item.component }}</td>
						<td>{{ item.path }}</td>
						<td>{{ item.icon }}</td>
						<td>{{ item.color }}</td>
						<td>{{ item.hidden }}</td>
						<td>{{ item.module_id }}</td>
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
                <menu-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></menu-form>

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
import menuForm  from './menuForm';
export default {
    mixins:     [ Applist],
    components: { 'menu-form': menuForm },
    data () {
    return {
        title:    'Menu',
        resource: 'menu',
        headers: [
            { text: 'Name',   value: 'name' },
			{ text: 'Label',   value: 'label' },
			{ text: 'Component',   value: 'component' },
			{ text: 'Path',   value: 'path' },
			{ text: 'Icon',   value: 'icon' },
			{ text: 'Color',   value: 'color' },
			{ text: 'Hidden',   value: 'hidden' },
			{ text: 'Module Id',   value: 'module_id' },
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