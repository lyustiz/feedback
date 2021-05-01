import Vue      from 'vue';
import router   from './router';
import store    from './store';

/** Plugins **/
import './plugins/axios';
import vuetify from './plugins/vuetify';

/** Componente Ppal   **/
import App from './App.vue'
Vue.component('app', App)
 
/** Config **/
Vue.prototype.$App = Object.freeze({
    title:    process.env.MIX_APP_NAME,
    version:  '0.1',
    baseUrl:  '/api/',
    apiUrl:   '/api/v1/',
    debug:    false,
    theme:{
            headApp:    'indigo',
            textTitle:  'white--text',
            headForm:   'deep-orange',
            titleForm:  'red lighten-4',
            headList:   'grey lighten-3',
            titleList:  'black--text',
            headModal:  'deep-orange',
            titleModal: 'white--text',
            button: {
                        insert:  'success',
                        update:  'warning',
                        delete:  'error',
                        reset:   'info',
                        cancel:  'error',
                        new:     'primary',
                        actions: 'primary'
                    }
        }
})

/* service wordker */
import './registerServiceWorker'


/** Components Autoload **/
import './components/components'

/** Minxins Autoload **/
import AppMessage from '@mixins/AppMessage'
import AppGlobals from '@mixins/AppGlobals'
Vue.mixin(AppMessage)
Vue.mixin(AppGlobals) 

/** Componente Principal */
const app = new Vue({
    el: '#app',
    mixins:[ AppMessage ],
    store,
    router,
    vuetify,
});
