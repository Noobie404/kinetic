import BillService from '../services/bill.service';
export const bill = {
    namespaced: true,
    state: {
        toastMessage : '',
        toastType : '',
        CustomerList : {},
        BillList : {},
        CustomerBillList : {},
        BillInfo : {},
        CustomerOptions : {},
    },
    actions: {
        getCustomerBills({ state, commit, rootState },id) {
            return BillService.getCustomerBills(id).then(
                res => {
                    commit('getCustomerBills',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                commit('auth/unauthorized', null, { root: true });
                return Promise.reject(error);
            });
        },
        getAllBills({ state, commit, rootState }) {
            return BillService.getAllBills().then(
                res => {
                    commit('getAllBills',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                commit('auth/unauthorized', null, { root: true });
                return Promise.reject(error);
            });
        },
        getCustomerOption({ state, commit, rootState }) {
            return BillService.getCustomerOption().then(
                res => {
                    commit('getCustomerOption',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                commit('auth/unauthorized', null, { root: true });
                return Promise.reject(error);
            });
        },
        billCreate({ state, commit, rootState },bill) {
            return BillService.billCreate(bill).then(
                res => {
                    commit('successAction',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                commit('auth/unauthorized', null, { root: true });
                return Promise.reject(error);
            });
        },
        loadBillInfo({ commit,dispatch },id) {
            return BillService.loadBillInfo(id).then(
                res => {
                    commit('loadBillInfo',res);
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
        billUpdate({ commit,dispatch },bill) {
            return BillService.billUpdate(bill).then(
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
        deleteCustomer({ state, commit, rootState },id) {
            return BillService.deleteCustomer(id).then(
                res => {
                    commit('successAction',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                commit('auth/unauthorized', null, { root: true });
                return Promise.reject(error);
            });
        },
    },
    mutations: {
        getCustomerOption(state,res) {
            if (res.data.status == 1) {
                state.CustomerOptions = res.data.data;
            }
        },
        getAllBills(state,res) {
            if (res.data.status == 1) {
                state.BillList = res.data.data;
            }
        },
        getCustomerBills(state,res) {
            if (res.data.status == 1) {
                state.CustomerBillList = res.data.data;
            }
        },
        loadBillInfo(state,res) {
            if (res.data.status == 1) {
                state.BillInfo = res.data.data;
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
