import axios from 'axios';
import authHeader from './auth-header';
const API_URL = '/api/';
class BillService {
    getAllBills() {
        return axios.get(API_URL + 'bill/list', {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    getCustomerBills(id) {
        return axios.get(API_URL + 'customer/bill/list/' + id, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    getCustomerOption() {
        return axios.get(API_URL + 'bill/new', {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    billCreate(bill) {
        return axios.post(API_URL + 'bill/store', bill, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    loadBillInfo(id) {
        return axios.get(API_URL + 'bill/edit/' + id, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    billUpdate(bill) {
        return axios.post(API_URL + 'bill/update', bill, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
    deleteBill(id) {
        return axios.get(API_URL + 'bill/delete/' + id, {
                headers: authHeader()
            })
            .then(response => {
                return response;
            }).catch(function (error) {
                return Promise.reject(error);
            });
    }
}
export default new BillService();
