
export default {
    data() 
    {
        return{

        }
    },
    methods:
    { 
        fillSelects()
        {
            Promise.all(this.selectRequests(this.selects))
            .then(results => {
                
                for (const select of Object.keys(this.selects)) {
                    
                    let response = results.find( result  => result.config.url.includes(select))

                    this.selects[select] = response.data
                }
            })
            .catch(error =>{
            
                this.showError(error);

            })
            .finally( () =>
            {
                this.loading = false;
            }); 
        },

        selectRequests(selects) 
        {
            let requests = [];

            for(var select in selects) 
            {
                let param = (selects[select]) ? selects[select] : '';

                requests.push(axios.get(this.$App.apiUrl + select + param));
            }

            return requests
            
        },
    } 
}