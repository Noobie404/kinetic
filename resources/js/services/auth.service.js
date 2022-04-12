import axios from 'axios';
import authHeader from './auth-header';
// const location = JSON.parse(localStorage.getItem('location'));

const API_URL = '/api/';
class AuthService {
  login(user) {
    axios.defaults.headers['Accept-Language'] = 'en';
    return axios
      .post(API_URL + 'login', {
        email: user.email,
        password: user.password,
      })
      .then(response => {
          console.log(response);
        if (response.data.data.access_token) {
         let user = localStorage.setItem('user', JSON.stringify(response.data.data));
        }
        return response.data.data.user;
      });
  }
  customerlogin(user) {
    axios.defaults.headers['Accept-Language'] = 'en';
    return axios
      .post(API_URL + 'customer/login', {
        email: user.email,
        password: user.password,
      })
      .then(response => {
          console.log(response);
        if (response.data.data.access_token) {
         let user = localStorage.setItem('user', JSON.stringify(response.data.data.user));
        }
        return response.data.data.user;
      });
  }
  logout() {
    localStorage.removeItem('user');
  }

}

export default new AuthService();
