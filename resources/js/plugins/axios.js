const axios = require('axios');

window.axios = axios.create();

/* let apiToken = `Bearer ${localStorage.getItem("token")}`
            
/* window.axios.defaults.headers.common['Authorization']= apiToken */ 


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.withCredentials = true;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token)
{
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
else
{
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


window.axiosAmolatina = axios.create();
