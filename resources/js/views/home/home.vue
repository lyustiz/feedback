<template>
<div class="home-holder pt-8">
   
   
<v-container>
    <v-row dense>
        <v-col cols="12" md="7">
            general
        </v-col>
        <v-col cols="12" md="5"> 
            detalle
        </v-col>
    </v-row>

    
</v-container>



</div>
</template>

<script>

import AppData from '@mixins/AppData';
export default 
{

    
    
    mixins:     [ AppData],

    created()
    {
        this.list()
    },

    data () 
	{
        return {
            Showfilter: true,

        }
    },

    methods:
    {
       
    }
}
</script>

<style>
.home-holder{
    min-height: 96vh;
}
.vertical-text{
    writing-mode: vertical-rl;
    transform: rotate(-180deg);
    height: 25vh;
}
.promocion-color{
    background-color: #8D70FF !important;
}
.resultados-color{
    background-color: #FCC02E !important;
}
.sorteo-color{
    background-color:#33CC33 !important;
}

</style>
