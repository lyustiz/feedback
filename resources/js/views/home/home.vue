<template>
 <!--  <div>
    <AdminBoard></AdminBoard>
    <OperatorBoard></OperatorBoard>
  </div> -->
  <component :is="board"></component>
</template>

<script>
import AdminBoard from '@views/boards/admin/AdminBoard.vue'
import OperatorBoard from '@views/boards/operator/OperatorBoard.vue'
export default {
 
  name: 'Home',

  components:{
    AdminBoard,
    OperatorBoard
  },

  computed: 
    {
      role()
      {
        return this.$store.getters['getRole']
      },

      board()
      {
          console.log(this.role.name)
          
          if(this.role.name ==  'Administrador')
          {
              return 'admin-board'
          }

          if(this.role.name == 'Operador')
          {
              return 'operator-board'
          }

          return false
      },
    },

  }
</script>

<style>
</style>