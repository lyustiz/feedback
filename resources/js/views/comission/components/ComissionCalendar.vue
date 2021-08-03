<template>

    <v-card>

        <v-date-picker 
            no-title
            scrollable
            full-width
            v-model="today"
            color="indigo"
            class="rounded-lg"
            elevation="3"
            :range="range"
            @change="$emit('onUpdateDate', $event)"
            :first-day-of-week="1"
            :max="maxDay"
            light
        ></v-date-picker>
        <v-row no-gutters justify="center">
            <v-col cols="auto">
                <v-switch color="blue" dense hide-details label="Seleccionar Rango" v-model="range" @change="days = null"></v-switch>
            </v-col>
        </v-row>
    </v-card>

</template>

<script>
export default {

    data()
    {
        return {
            today:  new Date().toISOString().substr(0, 10),
            days:   null,
            range: false,
            maxDay: new Date().toISOString().substr(0, 10),
        }
    },

}
</script>

<style>
.clase-calendar {
    height: 180px !important;
}

</style>