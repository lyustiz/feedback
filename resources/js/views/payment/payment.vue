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
						<td>{{ item.grupo }}</td>
						<td>{{ item.profile_id }}</td>
						<td>{{ item.bonus_type_id }}</td>
						<td>{{ item.start_at }}</td>
						<td>{{ item.end_at }}</td>
						<td>{{ item.payment_class_id }}</td>
						<td>{{ item.ammount }}</td>
						<td>{{ item.times }}</td>
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
                <payment-form
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                ></payment-form>

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
import paymentForm  from './paymentForm';
export default {
    mixins:     [ Applist],
    components: { 'payment-form': paymentForm },
    data () {
    return {
        title:    'Payment',
        resource: 'payment',
        headers: [
            { text: 'Name',   value: 'name' },
			{ text: 'Grupo',   value: 'grupo' },
			{ text: 'Profile Id',   value: 'profile_id' },
			{ text: 'Bonus Type Id',   value: 'bonus_type_id' },
			{ text: 'Start At',   value: 'start_at' },
			{ text: 'End At',   value: 'end_at' },
			{ text: 'Payment Class Id',   value: 'payment_class_id' },
			{ text: 'Ammount',   value: 'ammount' },
			{ text: 'Times',   value: 'times' },
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