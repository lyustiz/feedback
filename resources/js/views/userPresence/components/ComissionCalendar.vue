<template>

        <v-date-picker 
            no-title
            scrollable
            full-width
            v-model="today"
            :events="events"
            color="indigo"
            class="rounded-lg"
            elevation="3"
            @change="$emit('onUpdateDate', $event)"
            :first-day-of-week="1"
            :max="maxDay"
            light
        ></v-date-picker>

</template>

<script>
export default {

    props:
    {
        month: {
            type:     Array,
            default: () => [] 
        },
    },

    /*created()
    {
         if(this.clases)
        {
            this.setEvents()
        } 
    },*/

    /*watch:
    { 
        clases()
        {
            if(this.clases)
            {
                this.setEvents()
            }
        }
    }, */

    data()
    {
        return {
            today:      new Date().toISOString().substr(0, 10),
            events:     [],
            maxDay:     new Date().toISOString().substr(0, 10),
        }
    },

     /*methods: 
    {
        setEvents()
        {
            for (const clase of this.clases) {

                this.events.push(clase.fe_clase.substr(0, 10)

                  /*   {
                        id:    clase.id,
                        name:  `${clase.materia.nb_materia} - ${clase.grupo.nb_grupo}`,
                        date:  clase.fe_clase.substr(0, 10),
                        color: clase.materia.area_estudio.tx_color,
                    }  
                )
            }
        } 
          
            
    } */ 

}
</script>

<style>
.clase-calendar {
    height: 180px !important;
}

</style>