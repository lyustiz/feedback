import Vue    from 'vue'
import Router from 'vue-router'
Vue.use(Router)

 //secciones
import Welcome             from '@views/welcome/Welcome';
import Home                from '@views/home/Home';
import Admin               from '@views/admin/Admin';
import Login                 from '@views/login/login';
/*import Home                  from '@views/home/home';*/

//tools
import PageNotFound     from  '@views/404/NotFound'

/* import Suscripcion    from  '@views/suscripcion/AppSuscripcion' */
import Crud           from  '@views/crud/crud'

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
          component: Welcome,
        },
        
        {
          path:  '/admin',
          name:  'admin',
          label: 'Administrador',
          icon:  'mdi-home',
          profile: '',
          visible: true,
          component: Admin,
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
        } 
    ]
})


