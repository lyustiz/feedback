<template>

    <list-container :title="title" :head-color="$App.theme.headList" @onMenu="onMenu($event)">

        <template slot="HeadTools">
     
                <app-button :size="26" depressed icon="mdi-face" label="Agregar Suscriptor" color="blue" inner-class="mx-1" @click="dialogSuscriptor=true"></app-button>

                <app-button :size="26" depressed icon="mdi-face-agent" label="Agregar Vendedor" color="orange" inner-class="mx-1" @click="dialogVendedor=true"></app-button>

                <app-button :size="20" depressed icon="mdi-clipboard-check-multiple" label="Agregar Tipo Suscripcion" color="amber" inner-class="ml-1 mr-2" @click="dialogTipoSuscripcion=true"></app-button>

                <add-button @insItem="insertForm()" label="Agregar Nueva Suscripcion" ></add-button> 
        </template>

            <v-row dense>

            <v-col cols="12" md="3">
                <v-select
                :items="selects.vencimiento"
                    v-model="vencimiento"
                    label="Vencimiento"
                    clearable
                    hide-details
                    dense
                ></v-select>

            </v-col>

            <v-col cols="12" md="3">
                <v-select
                    :items="selects.tipoSuscripcion"
                    v-model="tipoSuscripcion"
                    label="Tipo Suscripcion"
                    clearable
                    hide-details
                    dense
                ></v-select>
            </v-col>

             <v-col cols="12" md="3">
                <v-autocomplete
                    :items="selects.suscriptor"
                    v-model="suscriptor"
                    label="Suscriptor"
                    clearable
                    hide-details
                    dense
                ></v-autocomplete>
            </v-col>

             <v-col cols="12" md="3">
                <v-autocomplete
                    :items="selects.vendedor"
                    v-model="vendedor"
                    label="Vendedor"
                    clearable
                    hide-details
                    dense
                ></v-autocomplete>
            </v-col>

            </v-row> 

            <v-data-table
                :headers="headers"
                :items  ="items"
                :search ="search"
                item-key="id"
                :loading="loading"
                sort-by=""
                dense
                class="mt-6"
                :items-per-page="20"
            >
                <template v-slot:item="{ item }">
                    <tr>
                        <td class="caption">
                            <v-row no-gutters>
                                <v-col>
                  
                                            {{ item.suscriptor.nb_suscriptor }}
                       
                                </v-col>
                                <v-col cols="auto">
                                     <v-edit-dialog
                                            :return-value.sync="item.tx_observaciones"
                                            large
                                            cancel-text="Cancelar"
                                            save-text="Actualizar"
                                            @save="updateObservaciones(item)"
                                            >
                                            <list-simple-icon 
                                                :size="20" class="mx"
                                                :label="(item.tx_observaciones) ? item.tx_observaciones : '-'" 
                                                icon="mdi-alert-circle" 
                                                :color="(item.tx_observaciones) ? 'red' : 'grey lighten-3' ">
                                            </list-simple-icon>
                                            <template v-slot:input>
                                                <v-text-field
                                                v-model="item.tx_observaciones"
                                                label="Obeservaciones"
                                                single-line
                                                counter
                                                clearable
                                                ></v-text-field>
                                            </template>
                                        </v-edit-dialog>    
                                    
                                </v-col>
                            </v-row>
                        </td>
                        <td class="caption">{{ item.suscriptor.tx_telefono }}</td>
						<td class="caption">{{ item.vendedor.nb_vendedor }}</td>
						<td class="caption">{{ item.tipo_suscripcion.nb_tipo_suscripcion }}</td>
						<td class="caption">{{ item.nu_dias }}</td>
						<td class="caption">{{ item.nu_monto | formatNumber}}</td>
						<td class="caption">{{ item.fe_suscripcion | formatDate}}</td>
						<td class="caption">{{ item.fe_vencimiento | formatDate }}</td>

						<td>
                            <v-chip small :color="item.vencimiento.tx_color">{{item.vencimiento.tx_vencido}}</v-chip>
                        </td>
                        <td>
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
                <AppSuscripcionForm
                    :action="action"
                    :item="item"
                    @closeModal="closeModal()"
                    v-if="modal"
                ></AppSuscripcionForm>

            </app-modal>

            <form-delete
                :dialog="dialog"
                :loading="loading"
                message="Desea eliminar el Registro Seleccionado?"
                @deleteItem="deleteItem()"
                @deleteCancel="deleteCancel()"
            ></form-delete>

            <v-dialog v-model="dialogSuscriptor" fullscreen >
                <AppSuscriptor v-if="dialogSuscriptor" @closeModal="closeDialog($event,'dialogSuscriptor')" @updateData="list()"></AppSuscriptor>
            </v-dialog>

            <v-dialog v-model="dialogVendedor" fullscreen >
                <AppVendedor v-if="dialogVendedor" @closeModal="closeDialog($event,'dialogVendedor')"  @updateData="list()"></AppVendedor>
            </v-dialog>

            <v-dialog v-model="dialogTipoSuscripcion" fullscreen >
                <AppTipoSuscripcion v-if="dialogTipoSuscripcion" @closeModal="closeDialog($event,'dialogTipoSuscripcion')"  @updateData="list()"></AppTipoSuscripcion>
            </v-dialog>
            
            <pre v-if="$App.debug">{{ $data }}</pre>

    </list-container>

</template>
 
<script>
import listHelper from '@mixins/Applist';
import AppSuscripcionForm  from './AppSuscripcionForm';
import AppSuscriptor       from '@views/suscriptor/AppSuscriptor';
import AppVendedor         from '@views/vendedor/AppVendedor';
import AppTipoSuscripcion  from '@views/tipoSuscripcion/AppTipoSuscripcion';

export default {

    mixins:     [ listHelper],

    components: { 
        AppSuscripcionForm,
        AppSuscriptor,
        AppVendedor,
        AppTipoSuscripcion
    },

    watch:
    {
        items(items)
        {
            if(items.length>0)
            {
                items.forEach( (item) => {
                    this.selects.vencimiento.push(item.vencimiento.tx_vencido)
                    this.selects.tipoSuscripcion.push(item.tipo_suscripcion.nb_tipo_suscripcion)
                    this.selects.suscriptor.push(item.suscriptor.nb_suscriptor)
                    this.selects.vendedor.push(item.vendedor.nb_vendedor)
                }, this)
            }
        }
    },

    data () 
    {
        return {
            title:    'Suscripcion',
            resource: 'suscripcion',
            suscriptor:             null,
            vencimiento:            null,
            vendedor:               null,
            tipoSuscripcion:        null,
            dialogSuscriptor:       null,
            dialogVendedor:         null,
            dialogTipoSuscripcion:  null,
            headers: [
                { text: 'Suscriptor',       value: 'suscriptor.nb_suscriptor', filter: this.filterSuscriptor },
                { text: 'Telefono',         value: 'suscriptor.tx_telefono' },
                { text: 'Vendedor',         value: 'vendedor.nb_vendedor', filter: this.filterVendedor },
                { text: 'Tipo',             value: 'tipo_suscripcion.nb_tipo_suscripcion', filter: this.filterTipoSuscripcion },
                { text: 'Dias',             value: 'nu_dias' },
                { text: 'Monto',            value: 'nu_monto' },
                { text: 'Suscripcion',      value: 'fe_suscripcion' },
                { text: 'Vencimiento',      value: 'fe_vencimiento' },
                { text: 'Status',           value: 'vencimiento.tx_vencido' , filter: this.filterVencimiento },
                { text: 'Acciones',         value: 'actions', sortable: false, filterable: false },
            ], 
            selects:{
                vencimiento:     [],
                tipoSuscripcion: [],
                suscriptor:      [],
                vendedor:        [],
            }
        }
    },
    methods:
    {
        filterVencimiento(value, search, item )
        {
            if(!this.vencimiento) return true
            
            return value == this.vencimiento
        },

        filterTipoSuscripcion(value, search, item )
        {
            if(!this.tipoSuscripcion) return true
            
            return value == this.tipoSuscripcion
        },

        filterSuscriptor(value, search, item )
        {
            if(!this.suscriptor) return true
            
            return value == this.suscriptor
        },
        
        filterVendedor(value, search, item )
        {
            if(!this.vendedor) return true
            
            return value == this.vendedor
        },

        updateObservaciones(item)
        {
            console.log(item ,this.userId)
            
            this.loading = true;

            let form = { user_id: this.userId, tx_observaciones: item.tx_observaciones, ddd:1}
            
            axios.put(`${this.apiUrl}suscripcion/${item.id}/observaciones`, form)
            .then(response => 
            {
                this.showMessage(response.data.msj)
            })
            .catch(error =>
            {
                this.showError(error);
            })
            .finally( () =>
            {
                this.loading = false
            }); 
        },

        closeDialog(refresh, dialog)
        {
            this[dialog]   = false

            if(refresh)    this.list()
        }
   
    }
}
</script>

<style>
</style>