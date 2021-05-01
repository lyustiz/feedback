<template>
<div>
    <component :is="layout"></component>
</div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    created()
    {
      //this.$route.name = 'welcome';
      /*   let auth     = localStorage.getItem('auth');
        let token    = localStorage.getItem('token');
        let user     = localStorage.getItem('user');
        let expire   = localStorage.getItem('expire');
        let profiles = localStorage.getItem('profiles');
        let modules  = localStorage.getItem('modules');
        
        if(auth==='true') // TODO:check expire
        {
            console.log('log')
            const data ={
                            user: JSON.parse(user),
                            token,
                            expire,
                            profiles: JSON.parse(profiles),
                        };
            
            this.$store.dispatch('autenticate', data)
        }
        else
        {
            this.$store.dispatch('unatenticate')
            this.navegateTo('/')
        }*/
        
    },
    computed: 
    {
        layout()
        {
           if(this.$route.name == 'admin')
           {
               return 'main-layout'
           }

           if(this.$route.name == 'login')
           {
               return 'login-layout'
           }

           return 'welcome-layout'
           

          /*  return this.$store.getters['getLayout'] */
        },
        
        /* async accept() {
            this.showUpgradeUI = false
            await this.$workbox.messageSW({ type: "SKIP_WAITING" });
        } */
    },

    methods: 
    {
        /* ...mapActions(['apiColegioUsuario']), */
    }
  }

</script>
<style>

    /* Transicion Contenido */
    .fade-enter-active, .fade-leave-active {
        transition:  opacity 0.4s ease;
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }
	
    .v-btn--floating {
        padding: 10px !important;
    }
    .v-btn--floating .v-btn__content {
        flex: 1 0 auto;
    }
    .v-application {
        background-color: var(--v-background-base) !important;
    }
    .pointer{
        cursor: pointer;
    }

</style>
