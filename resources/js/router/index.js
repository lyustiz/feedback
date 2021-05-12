import Vue    from 'vue'
import Router from 'vue-router'
Vue.use(Router)

//secciones
import Welcome         from '@views/welcome/Welcome';
import Home            from '@views/home/Home';


import AdminBoard    from '@views/boards/admin/AdminBoard.vue'
import OperatorBoard from '@views/boards/operator/OperatorBoard.vue'

import Login           from '@views/login/login';

//tools
import PageNotFound    from  '@views/404/NotFound'
import Crud            from  '@views/crud/crud'


//boards



//data
import Agency          from '@views/agency/agency.vue';
import AgencyProgress  from '@views/agencyProgress/agencyProgress.vue';
import Bonus           from '@views/bonus/bonus.vue';
import BonusType       from '@views/bonusType/bonusType.vue';
import Config          from '@views/config/config.vue';
import FailedJobs      from '@views/failedJobs/failedJobs.vue';
import FreeDay         from '@views/freeDay/freeDay.vue';
import MissedDay       from '@views/missedDay/missedDay.vue';
import Payment         from '@views/payment/payment.vue';
import PaymentClass    from '@views/paymentClass/paymentClass.vue';
import PaymentType     from '@views/paymentType/paymentType.vue';
import Penalty         from '@views/penalty/penalty.vue';
import PenaltyType     from '@views/penaltyType/penaltyType.vue';
import Profile         from '@views/profile/profile.vue';
import ProfileProgress from '@views/profileProgress/profileProgress.vue';
import Role            from '@views/role/role.vue';
import Status          from '@views/status/status.vue';
import User            from '@views/user/user.vue';
import UserProgress    from '@views/userProgress/userProgress.vue';
import WriteoffType    from '@views/writeoffType/writeoffType.vue';
import Spending        from '@views/spending/spending.vue';
import Present         from '@views/present/present.vue';
import Turn            from '@views/turn/turn.vue';
import Table           from '@views/table/table.vue';
import Curator         from '@views/curator/curator.vue';
import Comission       from '@views/comission/AppComission.vue';

import Menu            from '@views/menu/menu.vue';
import Permission      from '@views/permission/permission.vue';
import UserProfile     from '@views/userProfile/userProfile.vue';
import Group  from '@views/group/group.vue';
import Country  from '@views/country/country.vue';
//newImport

let isAuthenticated = true;
export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
    routes: [
        {
          path:  '/',
          name:  'welcome',
          label: 'Welcome',
          icon:  'mdi-home',
          profile: '',
          visible: false,
          component: Welcome,
        },
        {
          path:  '/home',
          name:  'home',
          label: 'Home',
          icon:  'mdi-home',
          profile: '',
          visible: false,
          component: Home,
        },
        
        {
          path:  '/admin',
          name:  'admin',
          label: 'Administrador',
          icon:  'mdi-home',
          profile: '',
          visible: true,
          component: AdminBoard,
        },

        {
            path:  '/operator',
            name:  'operator',
            label: 'Operator',
            icon:  'mdi-home',
            profile: 'mdi-monitor-dashboard',
            visible: true,
            component: OperatorBoard,
          },



        

       /*  {
          path:  '/suscripcion',
          name:  'suscripcion',
          label: 'suscripcion',
          icon:  'mdi-home',
          profile: '',
          visible: true,
          component: Suscripcion,
        }, */

        {
          path:  '/crud',
          name:  'crud',
          label: 'crud',
          icon:  'mdi-home',
          profile: '',
          visible: true,
          component: Crud,
        },
        {
          path: '/login',
          name: 'login',
          label: 'Login',
          icon: 'mdi-account',
          profile: '*',
          visible: false,
          color: 'black',
          component: Login,
        },
        { 
            path: "*", 
            name: 'notfound',
            label: 'Not Found',
            profile: '*',
            visible: false,
            component: PageNotFound 
        } ,
        {
            path: '/agency',
            name: 'agency',
            icon: 'bubble_chart',
            component: Agency,
        },
        {
            path: '/agencyProgress',
            name: 'agencyProgress',
            icon: 'bubble_chart',
            component: AgencyProgress,
        },
        {
            path: '/bonus',
            name: 'bonus',
            icon: 'bubble_chart',
            component: Bonus,
        },
        {
            path: '/bonusType',
            name: 'bonusType',
            icon: 'bubble_chart',
            component: BonusType,
        },
        {
            path: '/config',
            name: 'config',
            icon: 'bubble_chart',
            component: Config,
        },
        {
            path: '/failedJobs',
            name: 'failedJobs',
            icon: 'bubble_chart',
            component: FailedJobs,
        },
        {
            path: '/freeDay',
            name: 'freeDay',
            icon: 'bubble_chart',
            component: FreeDay,
        },
        {
            path: '/missedDay',
            name: 'missedDay',
            icon: 'bubble_chart',
            component: MissedDay,
        },
        {
            path: '/payment',
            name: 'payment',
            icon: 'bubble_chart',
            component: Payment,
        },
        {
            path: '/paymentClass',
            name: 'paymentClass',
            icon: 'bubble_chart',
            component: PaymentClass,
        },
        {
            path: '/paymentType',
            name: 'paymentType',
            icon: 'bubble_chart',
            component: PaymentType,
        },
        {
            path: '/penalty',
            name: 'penalty',
            icon: 'bubble_chart',
            component: Penalty,
        },
        {
            path: '/penaltyType',
            name: 'penaltyType',
            icon: 'bubble_chart',
            component: PenaltyType,
        },
        {
            path: '/profile',
            name: 'profile',
            icon: 'bubble_chart',
            component: Profile,
        },
        {
            path: '/profileProgress',
            name: 'profileProgress',
            icon: 'bubble_chart',
            component: ProfileProgress,
        },
        {
            path: '/role',
            name: 'role',
            icon: 'bubble_chart',
            component: Role,
        },
        {
            path: '/status',
            name: 'status',
            icon: 'bubble_chart',
            component: Status,
        },
        {
            path: '/user',
            name: 'user',
            icon: 'bubble_chart',
            component: User,
        },
        {
            path: '/userProgress',
            name: 'userProgress',
            icon: 'bubble_chart',
            component: UserProgress,
        },
        {
            path: '/writeoffType',
            name: 'writeoffType',
            icon: 'bubble_chart',
            component: WriteoffType,
        },
        {
            path: '/spending',
            name: 'spending',
            icon: 'bubble_chart',
            component: Spending,
        },
        {
            path: '/present',
            name: 'present',
            icon: 'bubble_chart',
            component: Present,
        },
        {
            path: '/turn',
            name: 'turn',
            icon: 'bubble_chart',
            component: Turn,
        },
        {
            path: '/table',
            name: 'table',
            icon: 'bubble_chart',
            component: Table,
        },
        {
            path: '/curator',
            name: 'curator',
            icon: 'bubble_chart',
            component: Curator,
        },
        {
            path: '/comission',
            name: 'comission',
            icon: 'bubble_chart',
            component: Comission,
        },
        {
            path: '/menu',
            name: 'menu',
            icon: 'bubble_chart',
            component: Menu,
        },
        {
            path: '/permission',
            name: 'permission',
            icon: 'bubble_chart',
            component: Permission,
        },

        {
            path: '/userProfile',
            name: 'userProfile',
            icon: 'bubble_chart',
            component: UserProfile,
        },

{
    path: '/group',
    name: 'group',
    icon: 'bubble_chart',
    component: Group,
},
{
    path: '/country',
    name: 'country',
    icon: 'bubble_chart',
    component: Country,
},
//newRoutes






    ]
})


