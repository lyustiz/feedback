<template>
  <v-select
        :items="sexOptions"
        v-model="sex"
        label="Sex"
        item-text="name"
        hide-details
        outlined
        filled
        dense
  >
    <template v-slot:item="{item}">
        <v-row dense class="grey lighten-5 subtitle-1">
        <v-col>
            {{item.name}}
        </v-col>
        <v-col cols="auto">
            <v-icon :color="item.color">{{item.icon}}</v-icon>
        </v-col>
        <v-col cols="auto">
            <v-icon :color="item.color_alt">{{item.icon_alt}}</v-icon>
        </v-col>
        </v-row>
    </template>
  
  </v-select>
</template>

<script>
export default {

    data: () => ({
        sex: null,
        sexOptions: [
            { name: 'Hombre - > Mujer',  from: 'mal', to: 'fem', icon: 'mdi-human-male', icon_alt: 'mdi-human-female', color: 'blue', color_alt: 'pink' },
            { name: 'Mujer  - > Hombre', from: 'fem', to: 'mal', icon: 'mdi-human-female', icon_alt: 'mdi-human-male', color: 'pink', color_alt: 'blue' },
            { name: 'Hombre - > Hombre', from: 'mal', to: 'mal', icon: 'mdi-human-male', icon_alt: 'mdi-human-male', color: 'blue', color_alt: 'blue' },
            { name: 'Mujer  - > Mujer',  from: 'fem', to: 'fem', icon: 'mdi-human-female', icon_alt: 'mdi-human-female', color: 'pink', color_alt: 'pink' },
        ]
    })
}
</script>

<style>

</style>