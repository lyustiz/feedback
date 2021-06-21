<template>
 
    <v-card color="main-color" dark>
        <v-card-title class="py-1 px-3">
            <v-row>
                <v-col>Metas Agencia: {{ agency.name }}</v-col>
                <v-col cols="auto">
                    <v-btn icon dark x-small @click="$emit('closeDialog')"><v-icon>mdi-close-circle-outline</v-icon></v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text>

            <v-row v-for="item in items" :key="item.id" class="mt-4">
                <v-col cols="3">{{ item.goal_type.name }}</v-col>
                <v-col cols="auto">
                    <list-simple-icon :icon="item.goal_type.icon" :label="item.goal_type.name" :color="item.goal_type.color" :size="30"></list-simple-icon>
                </v-col>
                <v-col>
                    <v-text-field
                        :rules="[rules.required, rules.minNum(1)]"
                        v-model="item.value"
                        type="number"
                        label="Value"
                        class="my-0"
                        dense
                        outlined
                        filled
                        hide-details=""
                        :loading="loading"
                    ></v-text-field>
                </v-col>
                <v-col cols="auto">
                    <v-btn fab dark color="warning" x-small @click="updateItem(item)" :loading="loading"><v-icon>mdi-lead-pencil</v-icon></v-btn>
                </v-col>
            </v-row>
            
            <pre v-if="$App.debug">{{ $data }}</pre>

       </v-card-text>
    </v-card>

</template>

<script>
import AppData from '@mixins/AppData';
export default {

    props:{
        agency: {
            type: Object
        }
    },

    mixins:     [ AppData],

    created()
    {
        this.list()
    },

    data:  () => ({
        form:{
            id:      null,
            value:   null,
            user_id: null
        }
    }),
    methods:
    {
        list()
        {
            this.getResource(`agencyGoal/agency/${this.agency.id}`).then( data => {
                this.items = data
            })
        },

        updateItem(item)
        {
            console.log('update',item)
            this.form.id = item.id
            this.form.value = item.value
            this.form.user_id = this.userId
            
            this.updateResource(`agencyGoal/${item.id}`, this.form).then( data => {
                this.showMessage(data.msj)
            })
        }
    }
}
</script>

<style>
</style>