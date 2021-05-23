<template>
  <v-card dark class="rounded-lg " color="rgba(0,0,0,0.4)">
    <v-subheader>
      <v-row no-gutters>
        <v-col class="ml-2 title">
          Operadores
        </v-col>
        <v-col cols="auto">
          <v-btn icon><v-icon size="33" @click="addOperator()">mdi-account-plus</v-icon></v-btn>
          <v-btn icon @click="list()" :loading="loading"><v-icon size="32">mdi-reload</v-icon></v-btn>
        </v-col>
      </v-row>
      </v-subheader>
    <v-card-text class="pt-0 accounts-container custom-scroll">
      <v-list subheader two-line dense color="rgba(0,0,0,0.4)" class="rounded-lg"> 
        <v-list-item v-for="operator in operatos" :key="operator.id" > 
          <v-list-item-avatar color="blue" size="60" class="elevation-2">
              <v-img :src="`/storage/photo/operator/${operator.photo || 'nophoto.png'}`" ></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>
              <v-row no-gutters>
                  <v-col cols="auto">
                    <v-tooltip bottom color="blue">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ operator.presence_day_sum_bonus || 0 }}  /  {{ operator.goal_day || 0 }}</span>
                    </template>
                    <span>Meta Dia</span>
                    </v-tooltip>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col cols="auto">
                    <v-tooltip bottom color="green">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{ operator.presence_month_sum_bonus || 0 }}  /  {{ operator.goal_month || 0 }}</span>
                    </template>
                    <span>Meta Mes</span>
                    </v-tooltip>
                  </v-col>
              </v-row>
              <v-row no-gutters>
                  <v-col>
                    <v-progress-linear
                    :value="operator.presence_day_sum_bonus*100/operator.goal_day || 0"
                    color="blue"
                    height="8"
                    class="mb-2 mt-1"
                    ></v-progress-linear>
                  </v-col>
                  <v-col>
                    <v-progress-linear
                    :value="operator.presence_month_sum_bonus*100/operator.goal_month || 0"
                    color="green"
                    height="8"
                    class="mb-2 mt-1"
                    ></v-progress-linear>
                  </v-col>
              </v-row>
              
            </v-list-item-title>
            <v-list-item-subtitle class="pt-2">
              <v-row no-gutters>
                  <v-col class="caption">

                     <v-tooltip bottom color="blue">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-on="on" v-bind="attrs">{{operator.full_name}}</span>
                    </template>
                    <span>{{operator.username}}</span>
                    </v-tooltip>

                    
                  </v-col>

                  <v-col cols="auto" class="px-2">
                    <v-badge v-if="operator.penalty_month.length > 0" offset-x="10" offset-y="12" color="rgba(0,0,0,0.15)" :content="operator.penalty_month.length">  
                      <list-simple-icon icon="mdi-account-cancel" label="Multas del Mes" color="red"></list-simple-icon>
                    </v-badge> 
                  </v-col>

                  <v-col cols="auto" class="px-2">
                    <v-badge v-if="operator.table" offset-x="10" offset-y="12" color="rgba(0,0,0,0.15)" :content="operator.table.value">  
                      <list-simple-icon  v-if="operator.table" icon="mdi-table-furniture" :label="operator.table.name" color="amber"></list-simple-icon>
                    </v-badge> 
                  </v-col>

                
                  <v-col cols="auto" class="pr-3">

                    <v-menu right bottom offset-x :disabled="operator.profile.length<1">
                      <template v-slot:activator="{ on }">
                          <v-badge v-if="operator.profile.length > 0" :value="operator.profile.length > 0" offset-x="10" offset-y="12" color="rgba(0,0,0,0.15)" :content="operator.profile.length">  
                            <list-simple-icon v-on="on" icon="mdi-account-multiple-outline" label="perfiles" color="green"></list-simple-icon>
                          </v-badge>
                      </template>
                      <v-card>
                        <v-card-text>
                          <h4 v-for="profile in operator.profile" :key="profile.id" v-text="profile.name"></h4>
                        </v-card-text>
                      </v-card>
                    </v-menu>
                  </v-col>
              </v-row>
            </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-icon class="mt-3">
              <item-menu 
                  :menus="itemsMenu" 
                  iconColor="white" 
                  btnColor="transparent" 
                  :item="operator"
                  @onItemMenu="onItemMenu($event)"
              ></item-menu>
            </v-list-item-icon>
        </v-list-item>
      </v-list>
    </v-card-text>

    <v-dialog v-model="addProfileDialog" scrollable persistent width="600">
      <AppUserProfile v-if="addProfileDialog" :user="user" @closeDialog="closeDialog($event)" @onUpdateData="list()" />
    </v-dialog>

     <v-dialog v-model="addOperatorDialog" scrollable  width="600">
      <NewOperator v-if="addOperatorDialog" :user="user" @closeModal="closeDialog($event)" @onUpdateData="list()" />
    </v-dialog>

    <v-dialog v-model="editOperatorDialog" scrollable  width="600">
      <EditOperator v-if="editOperatorDialog" action="upd" :item="user" @closeModal="closeDialog($event)" @onUpdateData="list()" />
    </v-dialog>

    <v-dialog v-model="addGoalsDialog" scrollable  width="300">
      <UserGoals v-if="addGoalsDialog" action="upd" :item="user" @closeModal="closeDialog($event)" @onUpdateData="list()" />
    </v-dialog>

    <v-dialog v-model="addPenaltyDialog" scrollable  width="80vw">
      <UserPenalty v-if="addPenaltyDialog" :user="user" @closeModal="closeDialog($event)" @onUpdateData="list()" />
    </v-dialog>

    <v-dialog v-model="addAbsenceDialog" scrollable  width="80vw">
      <UserAbsence v-if="addAbsenceDialog" :user="user" @closeModal="closeDialog($event)" @onUpdateData="list()" />
    </v-dialog> 

  </v-card>
</template>

<script>
import AppData from '@mixins/AppData';
import AppUserProfile from '@views/userProfile/AppUserProfile'
import NewOperator from '@views/user/NewOperator'
import EditOperator from '@views/user/EditOperator'
import UserGoals from '@views/user/UserGoals'
import UserPenalty from '@views/penalty/UserPenalty'
import UserAbsence from '@views/absence/UserAbsence'
export default {

  mixins: [AppData],

  components:{
    AppUserProfile,
    NewOperator,
    EditOperator,
    UserGoals,
    UserPenalty,
    UserAbsence
  },

  created() {
    this.list()
  },

  data: () => ({
    operatos: [],
    itemsMenu: [
      { action: 'editOperator', icon: 'mdi-account-edit-outline', label: 'Editar Usuario', iconColor: 'orange' },
      { action: 'addGoals',     icon: 'mdi-flag-checkered', label: 'Definir Metas', iconColor: 'green' },
      { action: 'addProfiles',  icon: 'mdi-account-multiple-outline', label: 'Agregar Perfiles', iconColor: 'green' },
      { action: 'addPenalty',   icon: 'mdi-account-cancel-outline', label: 'Multas', iconColor: 'red' },
      { action: 'addAbcense',   icon: 'mdi-account-arrow-right-outline', label: 'Ausencias/permisos', iconColor: 'red' },
      { action: 'delOperator',  icon: 'mdi-account-off',   label: 'Eliminar Operador', iconColor: 'red', class: 'red' },
    ],
    addOperatorDialog:  false,
    addProfileDialog:   false,
    editOperatorDialog: false,
    addGoalsDialog:     false,
    addPenaltyDialog:   false,
    addAbsenceDialog:   false,
    user: null
  }),

  methods: {

    list() {
        this.getResource('user/list?operator=true').then( data => {
          this.operatos = data
        })
    },

    addProfiles(user)
    {
      this.user = user
      this.addProfileDialog = true
    },

    addOperator()
    {
      this.addOperatorDialog = true
    },

    editOperator(user)
    {
      this.user = user
      this.editOperatorDialog = true
    },

    addGoals(user)
    {
      this.user = user
      this.addGoalsDialog = true
    },
    
    addPenalty(user)
    {
      this.user = user
      this.addPenaltyDialog = true
    },

    addAbcense(user)
    {
      this.user = user
      this.addAbsenceDialog = true
    },

    delOperator(user)
    {
      this.deleteResource(`user/${user.id}`).then( data => {
        this.showMessage(data.msj)
        this.list()
      })
    },

    closeDialog(reload)
    {
      this.list()
      this.user = null
      this.addProfileDialog   = false
      this.addOperatorDialog  = false
      this.editOperatorDialog = false
      this.addGoalsDialog     = false
      this.addAbsenceDialog   = false
    },

   

  }

}

</script>

<style>
.accounts-container{
  height: 83vh;
  overflow-y: auto;
}
</style>