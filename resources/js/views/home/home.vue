<template>
  <component :is="board"></component>
</template>

<script>
import AdminBoard from '@views/boards/admin/AdminBoard.vue'
import OperatorBoard from '@views/boards/operator/OperatorBoard.vue'
import CoordinatorBoard from '@views/boards/coordinator/CoordinatorBoard'
export default {
 
  name: 'Home',

  components:{
    AdminBoard,
    OperatorBoard,
    CoordinatorBoard
  },

  computed: 
    {
      role()
      {
        return this.$store.getters['getRole']
      },

      board()
      {
          console.log(this.role.name, 'rol')
          
          if(this.role.name ==  'Administrador')
          {
              return 'admin-board'
          }

          if(this.role.name == 'Operador')
          {
              return 'operator-board'
          }

          if(this.role.name == 'Coordinador')
          {
            return 'coordinator-board'
          }

          return false
      },
    },

  }
</script>

<style>
</style>