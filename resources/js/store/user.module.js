import UserService from '../services/user.service';
export const user = {
    namespaced: true,
    state: {
        toastMessage : '',
        toastType : '',
    },
    actions: {
        getAllCustomers({ commit,dispatch }) {
            return UserService.getAllCustomers().then(
                res => {
                    console.log(res);
                    commit('getAllCustomers',res);
                },
                error => {
                    commit('fetchFailure',error);
                    return Promise.reject(error);
                }
            ).catch(function (error) {
                console.log('errorqwqwqw: ', error.response.status);
                return Promise.reject(error);
            });
        },
    },
    mutations: {
        getAllCustomers(state,res) {
            if (res.data.status == 1) {
                state.is_product        = 1;
                state.product           = res.data.data.product_data;
                state.galleries         = res.data.data.galleries;
                state.title             = 'Easybazar-'+ state.product.VARIANT_NAME;
            }else{
                state.is_product        = 0;
            }
        },
        fetchFailure(state, res) {
            // state.status.CustomerloggedIn = true;
            // state.status.loggedIn = false;
            state.toastMessage = res.response.statusText;
            state.toastType = 'error';

            console.log(state.toastMessage);
        },
    }
};
