import CustomerService from '../services/customer.service';
export const customer = {
    namespaced: true,
    state: {
        toastMessage : '',
        toastType : '',
        CustomerList : {},
        CustomerInfo : {},
    },
    actions: {
        getAllCustomers({ commit,dispatch }) {
            return CustomerService.getAllCustomers().then(
                res => {
                    commit('getAllCustomers',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                return Promise.reject(error);
            });
        },
        customerCreate({ commit,dispatch },customer) {
            return CustomerService.customerCreate(customer).then(
                res => {
                    commit('successAction',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                return Promise.reject(error);
            });
        },
        customerUpdate({ commit,dispatch },customer) {
            return CustomerService.customerUpdate(customer).then(
                res => {
                    commit('successAction',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                return Promise.reject(error);
            });
        },
        loadCustomerInfo({ commit,dispatch },id) {
            return CustomerService.loadCustomerInfo(id).then(
                res => {
                    commit('loadCustomerInfo',res);
                    return res;
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                return Promise.reject(error);
            });
        },
    },
    mutations: {
        getAllCustomers(state,res) {
            if (res.data.status == 1) {
                state.CustomerList = res.data.data;
            }
        },
        loadCustomerInfo(state,res) {
            if (res.data.status == 1) {
                state.CustomerInfo = res.data.data;
            }
        },
        fetchFailure(state, res) {
            state.toastMessage = res.response.statusText;
            state.toastType = 'error';
        },
        successAction(state, res) {
            state.toastMessage = res.data.msg;
            state.toastType = 'success';
        },
    }
};
