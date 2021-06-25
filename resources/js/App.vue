<template>
<div>
    <component :is="layout"></component>
</div>
</template>

<script>
export default {
    created()
    {
        console.log(this.$route.name)
        
        let auth            = localStorage.getItem('auth');
        let user            = localStorage.getItem('user');
        let role            = localStorage.getItem('role');
        let menu            = localStorage.getItem('menu');
        let agency          = localStorage.getItem('agency');
        let agencyManage    = localStorage.getItem('agencyManage');
        let goalType        = localStorage.getItem('goalType');
        let amolatina_token = localStorage.getItem('amolatina_token');
        
        if(auth==='true') // TODO:check expire
        {
 
            const data ={
                            
                            
                            user: JSON.parse(user),
                            role: JSON.parse(role),
                            menu: JSON.parse(menu),
                            agency: JSON.parse(agency),
                            agencyManage:  (agencyManage) ? JSON.parse(agencyManage) : null,
                            goalType:    (goalType) ? JSON.parse(goalType) : [],
                            amolatina_token: amolatina_token
                        };
            
            this.$store.dispatch('autenticate', data)
            if(this.$route.name == 'login')
            {
                this.navigateToName('home');
            } 
        }
        else
        {
            this.$store.dispatch('unatenticate')
        }
        
    },
    computed: 
    {
        layout()
        {
           if(this.$route.name ==  'welcome')
           {
               return 'welcome-layout'
           }

           if(this.$route.name == 'login')
           {
               return 'login-layout'
           }

           return 'main-layout'
           

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

    .main-color{
        background: linear-gradient(107deg, rgb(37, 96, 159) 0%, rgb(20, 37, 54) 100%);
        }

    .card-background{
        background: rgba(0,0,0,0.4)
    }

    .v-application{
        background: linear-gradient(107deg, rgb(37, 96, 159) 0%, rgb(20, 37, 54) 100%) !important;
    }
    
    .pointer{
        cursor: pointer;
    }
    
    .no-drop {cursor: no-drop;}

    .custom-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(18, 41, 67, 0.8);
        /* border-radius: 7px; */
        border: 0.5px solid rgb(10, 23, 36);
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgb(10, 23, 36);
        border-radius: 7px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: black;
    }

    .custom-scroll-dark::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scroll-dark::-webkit-scrollbar-track {
        background: #202020;
        border-left: 1px solid #2c2c2c;
    }

    .custom-scroll-dark::-webkit-scrollbar-thumb {
        background: #3e3e3e;
        border: solid 3px #202020;
        border-radius: 7px;
    }

    .custom-scroll-dark::-webkit-scrollbar-thumb:hover {
        background: white;
    }

    .text-detail {
        font-size: .55rem!important;
        letter-spacing: .0333333333em!important;
        line-height: 1.25rem;
    }

    
</style>
