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
                        <td>{{ item.username }}</td>
						<td>{{ item.password }}</td>
						<td>{{ item.name }}</td>
						<td>{{ item.surname }}</td>
						<td>{{ item.role_id }}</td>
						<td>{{ item.agency_id }}</td>
						<td>{{ item.group_id }}</td>
						<td>{{ item.photo }}</td>
						<td>{{ item.email }}</td>
						<td>{{ item.verification }}</td>
						<td>{{ item.email_verified_at }}</td>
						<td>{{ item.remember_token }}</td>
						<td>{{ item.api_token }}</td>
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
                <user-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></user-form>

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
import userForm  from './userForm';
export default {
    mixins:     [ Applist],
    components: { 'user-form': userForm },
    data () {
    return {
        title:    'User',
        resource: 'user',
        headers: [
            { text: 'Username',   value: 'username' },
			{ text: 'Password',   value: 'password' },
			{ text: 'Name',   value: 'name' },
			{ text: 'Surname',   value: 'surname' },
			{ text: 'Role Id',   value: 'role_id' },
			{ text: 'Agency Id',   value: 'agency_id' },
			{ text: 'Group Id',   value: 'group_id' },
			{ text: 'Photo',   value: 'photo' },
			{ text: 'Email',   value: 'email' },
			{ text: 'Verification',   value: 'verification' },
			{ text: 'Email Verified At',   value: 'email_verified_at' },
			{ text: 'Remember Token',   value: 'remember_token' },
			{ text: 'Api Token',   value: 'api_token' },
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