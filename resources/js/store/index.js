import Vue  from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

//app
import AppMessage from '@store/app/AppMessage';
/* import AppLayout  from '@store/app/AppLayout';
import AppHelp    from '@store/app/AppHelp'; */

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        
        //app
       AppMessage,
        /*  AppLayout,
        AppHelp, */

    },
    strict: debug
})
