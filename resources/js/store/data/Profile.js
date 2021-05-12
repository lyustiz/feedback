export default
{
	state(){
		return	{

			profile: null,

			profiles: [],

		}
	},

	getters:
	{
		getProfile: state => state.profile,
		
		getProfiles: state => state.profiles,

	},

	mutations:
	{
		setProfile (state, profile)
        {
            state.profile 	= profile
        },

        setProfiles (state, profiles)
        {
            state.profiles 	= profiles
        },

	},

    actions:
    {
        fetchProfiles({ commit }, data) {
            return new Promise((resolve, reject) => {
                commit('setLoading', true)
                ipcRenderer.invoke('database', 'Game', 'fetch', data, 'find')
                    .then((result) => {
                        result = JSON.parse(result)
                        console.log('RESPONSE GAME', result)
                        commit('setGame', result)
                        resolve(result)
                    })
                    .catch((error) => {
                        reject(error)
                    })
                    .finally(() => {
                        commit('setLoading', false)
                    });
            })
        },
    }
}