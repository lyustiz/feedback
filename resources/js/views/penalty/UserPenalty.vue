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
						<td><v-icon small label :color="item.penalty_type.color">{{item.penalty_type.icon}}</v-icon> {{item.penalty_type.name}} </td> 
						<td>{{ item.penalty_type.amount }}</td> 
                        
                        
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
                <UserPenaltyForm :action="action" :item="item" :user="user" @closeModal="closeModal()" />

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
import UserPenaltyForm  from './UserPenaltyForm';
export default {

    props:
    {
        user: {
            type: Object,
            default: () => {}
        }
    },

    mixins:     [ Applist],

    components: { UserPenaltyForm },
    
    data () {
    return {
        title:    `Multas  (${this.user.full_name})` ,
        resource: 'penalty',
        headers: [
            { text: 'Fecha',       value: 'day' },
			{ text: 'Tipo Falta',  value: 'penalty_type.name' },
            { text: 'Monto',       value: 'penalty_type.amount' },
			{ text: 'Descripcion', value: 'comments' },
            { text: 'Acciones',    value: 'actions', sortable: false, filterable: false },
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