export default 
{
    computed: 
    {
        userId()
        {
            return this.$store.getters['getUserid']
        },
        
        baseUrl() 
        {
            return 'https://api.amolatina.com/';
        },

        amolatinaToken()
        {
            return this.$store.getters['getAmolatinaToken']
        }
       
    },

    data() 
    {
        return {
            axios:   null,
        }
    },

    methods:
    {
        axiosInstance()
        {
            
            this.axios = axiosAmolatina

            delete this.axios.defaults.headers.common["authorization"];
            
            this.axios.defaults.headers.common['authorization'] = 'Token token="'+this.amolatinaToken+'"';
        },

        getDataAmolatina(url)
        {
            this.loading = true

            this.axiosInstance()
      
            return new Promise((resolve, reject) => 
			{
				this.axios.get(this.baseUrl + url)
				.then(response => 
				{
                    resolve(response.data)
				})
				.catch(error => 
				{
                    this.showError(error)
                    reject(error)
                })
                .finally( () => 
                {
                    this.loading = false
                });
			})

        },

        sendMessageAmolatina(url, payload)
        {
            this.loading = true

            this.axiosInstance()
      
            return new Promise((resolve, reject) => 
			{
				this.axios.post(this.baseUrl + url, payload)
				.then(response => 
				{
                    resolve(response)
				})
				.catch(error => 
				{
                    this.showError(error)
                    reject(error)
                })
                .finally( () => 
                {
                    this.loading = false
                });
			})

        },

        getAmolatinaFile(resource, data, type, filename)
        {
           if(!this.preFormActions('download')) {
                return new Promise(() => 
                {
                    this.showError('Favor validar los datos')
                    this.loading = false
                })  
            } 
            
            return new Promise((resolve, reject) => 
			{
                axios({
                    method: 'post',
                    url: this.apiUrl + resource,
                    responseType: 'arraybuffer',
                    data: data
                })
                .then(function(response) {
                        let blob      = new Blob([response.data], { type })
                        let link      = document.createElement('a')
                        link.href     = window.URL.createObjectURL(blob)
                        link.download = filename
                        link.click()
                        resolve('Descargando Archivo ...')
                })
                .catch(error => 
                {
                    this.showError(error)
                })
                .finally( () => 
                {
                    this.loading = false
                });
			})
        },
    }

       
}

