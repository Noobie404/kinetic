import UserService from '../services/user.service';
export const user = {
    namespaced: true,
    state: {
        toastMessage : '',
        toastType : '',
        CustomerList : {},
        CustomerInfo : {},
    },
    actions: {
        getAllCustomers({ state, commit, rootState }) {
            return UserService.getAllCustomers().then(
                res => {
                    commit('getAllCustomers',res);
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
        deleteCustomer({ state, commit, rootState },id) {
            return UserService.deleteCustomer(id).then(
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
        getAllCustomers(state,res) {
            if (res.data.status == 1) {
                state.CustomerList = res.data.data;
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
