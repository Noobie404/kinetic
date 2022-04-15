import axios from 'axios';
import authHeader from './auth-header';
const API_URL = '/api/';
class UserService {
    getAllCustomers() {
        return axios.get(API_URL + 'customer/list', {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    customerCreate(customer) {
        return axios.post(API_URL + 'customer/store', customer, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    loadCustomerInfo(id) {
        return axios.get(API_URL + 'customer/edit/' + id, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    deleteCustomer(id) {
        return axios.get(API_URL + 'customer/delete/' + id, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
}
export default new UserService();
