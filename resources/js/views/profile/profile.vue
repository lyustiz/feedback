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
                        <td class="text-xs-left">{{ item.amolatina_id }}</td>
						<td class="text-xs-left">{{ item.name }}</td>
						<td class="text-xs-left">{{ item.birthday }}</td>
						<td class="text-xs-left">{{ item.age }}</td>
						<td class="text-xs-left">{{ item.photo }}</td>
						<td class="text-xs-left">{{ item.gender }}</td>
						<td class="text-xs-left">{{ item.preference }}</td>
						<td class="text-xs-left">{{ item.country }}</td>
						<td class="text-xs-left">{{ item.city }}</td>
						<td class="text-xs-left">{{ item.minage }}</td>
						<td class="text-xs-left">{{ item.maxage }}</td>
						<td class="text-xs-left">{{ item.comments }}</td>
						<td class="text-xs-left">{{ item.status_id }}</td>
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
                <profile-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></profile-form>

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
import profileForm  from './profileForm';
export default {
    mixins:     [ listHelper],
    components: { 'profile-form': profileForm },
    data () {
    return {
        title:    'Profile',
        resource: 'profile',
        headers: [
            { text: 'Amolatina Id',   value: 'amolatina_id' },
			{ text: 'Name',   value: 'name' },
			{ text: 'Birthday',   value: 'birthday' },
			{ text: 'Age',   value: 'age' },
			{ text: 'Photo',   value: 'photo' },
			{ text: 'Gender',   value: 'gender' },
			{ text: 'Preference',   value: 'preference' },
			{ text: 'Country',   value: 'country' },
			{ text: 'City',   value: 'city' },
			{ text: 'Minage',   value: 'minage' },
			{ text: 'Maxage',   value: 'maxage' },
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