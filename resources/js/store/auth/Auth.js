export default
{
	state(){
		return{
			token:  		null,
			amolatinaToken: null,
			expire:     	null,
			auth: 			false,
			user: 			null,
			userid: 		null,
			username: 		null,
			name:       	null,
			role:			null,
			modules:    	[],
			menu:       	[],
			agency:     	null,
			agencyManage:   null,
			goalType:       []
		}
	},

	getters:
	{
		getToken:   	    state => state.token,
		getAmolatinaToken:  state => state.token,
		getExpire:   	    state => state.expire,
		getAuth: 		    state => state.auth,
		getUser:  		    state => state.user,
		getUserid:  	    state => state.userid,
		getUsername:  	    state => state.username,
		getName:  	        state => state.name,
		getRole:   	        state => state.role,
		getUserPhoto:   	state => (state.user) ? state.user.photo : null,
		getModules:   	    state => state.modules,
		getMenu:   	    	state => state.menu,
		getAgency:   	    state => state.agency,
		getAgencyManage:   	state => state.agencyManage,
		getGoalType:   	    state => state.goalType,
		
	},

	mutations:
	{
		setToken (state, token)
        {
			state.token		= token
			localStorage.setItem("token", 	token)
		},

		setAmolatinaToken (state, token)
        {
			state.token		= token
			localStorage.setItem("amolatina_token", 	token)
		},

		setExpire (state, expire)
		{
			state.expire 	= expire
			localStorage.setItem("expire", 	expire)
		},
		
		setAuth (state, auth)
        {
			state.auth 		= auth
			localStorage.setItem("auth", 	auth)
		},
		
		setUser(state, user)
		{
			state.user  	=  user
			state.userid   	= (user) ? user.id : null
			state.username 	= (user) ? user.username : null 
			state.name 	    = (user) ? user.name : null
			state.photo     = (user) ? user.photo : null
			localStorage.setItem("user", (user)  ? JSON.stringify(user): null)			
		},

		setRole (state, role)
        {
			state.role  = role
			localStorage.setItem("role", (role)  ? JSON.stringify(role): null)
		},

		setPhoto (state, foto)
		{
			state.user.foto  = foto
			localStorage.setItem("user", state.user)
		},

		setMenu (state, menu)
        {
			state.menu	= menu
			localStorage.setItem("menu", (menu)  ? JSON.stringify(menu): [])
		},

		setAgency (state, agency)
        {
			state.agency	= agency
			localStorage.setItem("agency", (agency)  ? JSON.stringify(agency): [])
		},

		setAgencyManage( state, agency )
		{
			state.agencyManage	= agency
			localStorage.setItem("agencyManage", (agency)  ? JSON.stringify(agency): [])
		},

		setGoalType( state, goalType )
		{
			state.goalType	= goalType
			localStorage.setItem("goalType", (goalType)  ? JSON.stringify(goalType): [])
		},

		updateAgencyManage( state, agency )
		{
			for (const [key, _agency] of state.agencyManage.entries()) {
				if(_agency.id == agency.id)
				{
					state.agencyManage[key] = agency
				}
			}
			localStorage.setItem("agencyManage", (state.agencyManage)  ? JSON.stringify(state.agencyManage): [])
		},

		updateGoalType( state, goalType )
		{
			for (const [key, _goalType] of state.goalType.entries()) {
				if(_goalType.id == goalType.id)
				{
					state.goalType[key] = goalType
				}
			}
			localStorage.setItem("goalType", (state.goalType)  ? JSON.stringify(state.goalType): [])
		}

    },
    
    actions:
    {
        login( { dispatch }, credentials )
		{
			return new Promise((resolve, reject) => 
			{
				document.cookie = "XSRF-TOKEN= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
				axios.get('/sanctum/csrf-cookie').then((tokenresp) => {
					/* console.log('sactum', tokenresp) */
						axios.post('/' + 'login', credentials).then(response => 
							{
								/* console.log('login',response) */
								if (response.status == 200)
								{
									const data = {
										user: response.data.user,
										role: response.data.role,
										menu: response.data.menu,
										agency: response.data.user.agency,
										agencyManage: response.data.user.agency_manage,
										goalType: response.data.user.goal_type
									};
	
									dispatch('autenticate', data)
									resolve( { status: 200, path: response.data.role.path } )
								}
								else{
									dispatch('unatenticate')
									reject(response)
								}
								
							})
							.catch(error => 
							{
								dispatch('unatenticate')
								reject(error)
							})

					
				});
			})
        },
		
		verify( { commit }, form )
		{
			return new Promise((resolve, reject) => 
			{
				axios.post('/api/' + 'verify', form)
				.then(response => 
				{
					resolve(response)
				})
				.catch(error => 
				{
					reject(error)
				})
			})
		},
		
		resendEmail( { commit }, form )
		{
			return new Promise((resolve, reject) => 
			{
				axios.post('/api/' + 'email/resend', form)
				.then(response => 
				{
					resolve(response)
				})
				.catch(error => 
				{
					reject(error)
				})
			})
        },
        
        logout( { dispatch } )
		{
			return new Promise((resolve, reject) => 
			{
				axios.post('/' + 'logout')
				.then(response => 
				{
					resolve(response)
				})
				.catch(error => 
				{
					reject(error)
				})
				.then()
				{
					dispatch('unatenticate')
				}
			})
        },
        
        recoverPassword( { commit }, form )
		{
			return new Promise((resolve, reject) => 
			{
				axios.post('/api/' + 'recover/password', form)
				.then(response => 
				{
					resolve(response)
				})
				.catch(error => 
				{
					reject(error)
				})
			})
        },
        
        resetPassword( { commit }, form )
		{
			return new Promise((resolve, reject) => 
			{
				axios.post('/api/' + 'reset/password' , form) 
				.then( response =>
				{
					resolve(response)
				})
				.catch( error =>
				{
					reject(error)
				})
			})
		},

		updateEmail( { commit, state  }, form )
		{
			return new Promise((resolve, reject) => 
			{
				axios.put(`/api/v1/usuario/${form.user_id}/email` , form) 
				.then( response =>
				{
					let user      =  JSON.parse(JSON.stringify(state.user));

					user.tx_email = form.tx_new_email
												
					commit('setUser' , user);
					
					resolve(response)
				})
				.catch( error =>
				{
					reject(error)
				})
			})
		},

		autenticate({ commit }, data)
		{
			commit('setUser'  	 		, data.user);
			commit('setRole'  	 		, data.role);
			commit('setMenu'  	 		, data.menu);
			commit('setAgency'   		, (data.agency.length > 0) ? data.agency : data.agencyManage);
			commit('setAgencyManage'    , data.agencyManage);
			commit('setGoalType'        , data.goalType);
			
			commit('setAmolatinaToken'  , (data.agency.length > 0) ? data.agency[0].token : data.agencyManage[0].token)
			commit('setAuth'  	 		, true);
		},

		unatenticate({ commit })
		{
			commit('setUser'  	 , null);
			commit('setAuth'  	 , false);
			commit('setRole'  	 , null);
			commit('setMenu'  	 , null);
			commit('setAgency'   , null);
			commit('setAgencyManage', null);
			localStorage.clear()
			localStorage.setItem("auth", 	false)
		}

    }
}
