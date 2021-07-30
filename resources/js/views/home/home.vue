<template>
  <component :is="board"></component>
</template>

<script>
import AdminBoard from '@views/boards/admin/AdminBoard.vue'
import OperatorBoard from '@views/boards/operator/OperatorBoard.vue'
import CoordinatorBoard from '@views/boards/coordinator/CoordinatorBoard.vue'
import ManagerBoard from '@views/boards/manager/ManagerBoard.vue'
import AccountManagerBoard from '@views/boards/accountManager/AccountManagerBoard.vue'
export default {
 
  name: 'Home',

  components:{
    AdminBoard,
    OperatorBoard,
    CoordinatorBoard,
    ManagerBoard,
    AccountManagerBoard
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

          if(this.role.name == 'Gerente')
          {
            return 'manager-board'
          }

          if(this.role.name == 'Admin Cuentas')
          {
            return 'account-manager-board'  
          }

          return false
      },
    },

  }
</script>

<style>
</style>