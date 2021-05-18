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
                        <td>{{ formatDate(item.day) }}</td>
                        <td><v-icon large label  :color="item.absence_type.color">{{item.absence_type.icon}}</v-icon> {{item.absence_type.name}} </td> 
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
                <UserAbsenceForm :action="action" :user="user" :item="item" @closeModal="closeModal()" />

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
import UserAbsenceForm  from './UserAbsenceForm';
export default {
    mixins:     [ Applist],
    components: { UserAbsenceForm },

    props:
    {
        user: {
            type: Object,
            default: () => {}
        }
    },

    data () {
    return {
        title:    'Permisos y Faltas',
        resource: 'absence',
        headers: [
            { text: 'Fecha',   value: 'day' },
            { text: 'Tipo Ausencia',  value: 'absence_type.name' },
			{ text: 'Descripcion',   value: 'comments' },
            { text: 'Acciones', value: 'actions', sortable: false, filterable: false },
        ],
    }
    },
    methods:
    {
        listUrl()
        {
            return this.fullUrl + '/user/' + this.user.id
        },
    }
}
</script>

<style>
</style>