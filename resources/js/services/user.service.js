import axios from 'axios';
import authHeader from './auth-header';
const API_URL = '/api/';
class UserService {
  getAllCustomers() {
    return axios.get(API_URL + 'customer/list', { headers: authHeader() });
  }
}
export default new UserService();
