import Vue  from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)



//app
import Auth from '@store/auth/Auth'
import AppMessage from '@store/app/AppMessage';

import Profile from '@store/data/Profile';
/* import AppLayout  from '@store/app/AppLayout';
import AppHelp    from '@store/app/AppHelp'; */

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        Auth,
        //app
       AppMessage,
        /*  AppLayout,
        AppHelp, */

        Profile,

    },
    strict: debug
})
