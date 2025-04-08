import axios from 'axios';

// You can configure Axios here, for example:
axios.defaults.baseURL = '/index.php/uz'; // Adjust the base URL as needed
axios.defaults.headers['X-Requested-With'] = 'XMLHttpRequest';

export default axios;