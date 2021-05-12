<template>

    <v-tooltip bottom color="sucess">
        <template v-slot:activator="{ on }">
            <v-btn icon dark x-small v-on="on" @click="insItem()" :class="innerClass" :loading="loading">
                <v-icon dark size="32" color="green" >mdi-plus-circle-outline</v-icon>
            </v-btn>
        </template>
        <span>{{ label }}</span>
    </v-tooltip>

</template>

<script>
export default {
    props:
    {
        label: {
            type:     String,
            default:  'Nuevo Item'
        },

        loading: {
            type:     Boolean,
            default:  false
        },

        innerClass: {
            type:     String,
            default:  'elevation-5'
        }
    },
    methods:
    {
        insItem()
        {
            this.$emit('insItem')
        }
    }
}
</script>

<style>
</style>
