import axios from 'axios';

//module.exports = function() { 
    //export default function () {
        
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['Content-type'] = 'application/json';

    //return axios;
//};

export default axios;