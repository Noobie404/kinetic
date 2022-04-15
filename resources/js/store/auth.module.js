import AuthService from '../services/auth.service';
var user = JSON.parse(localStorage.getItem('user'));
var initialState = user
  ? { status: { loggedIn: user.user.is_admin == 1 ? true : false,CustomerloggedIn: user.user.is_admin == 1 ? false : true }, user }
  : { status: { loggedIn: false,CustomerloggedIn:false }, user: {access_token:null,user:null} };
export const auth = {
    namespaced: true,
    state:{
            initialState,
        },
    actions: {
        login({ commit }, user) {
            return AuthService.login(user).then(
                user => {
                commit('loginSuccess', user);
                return Promise.resolve(user);
                },
                error => {
                commit('loginFailure');
                return Promise.reject(error);
                }
            );
        },
        customerlogin({ commit }, user) {
            return AuthService.customerlogin(user).then(
                user => {
                commit('CustomerloginSuccess', user);
                return Promise.resolve(user);
                },
                error => {
                commit('loginFailure');
                return Promise.reject(error);
                }
            );
        },
        logout({ commit }) {
            AuthService.logout();
            commit('logout');
        },
    },
    mutations: {
        loginSuccess(state, user) {
            state.initialState.status.loggedIn = true;
            state.initialState.status.CustomerloggedIn = false;
            state.initialState.user.user = user;
        },
        CustomerloginSuccess(state, user) {
            state.initialState.status.CustomerloggedIn = true;
            state.initialState.status.loggedIn = false;
            state.initialState.user.user = user;
        },
        loginFailure(state) {
            state.initialState.status.loggedIn = false;
            state.user = null;
        },
        logout(state) {
            state.initialState.status.loggedIn = false;
            state.initialState.status.CustomerloggedIn = false;
            state.user = null;
        },
        forgot(state) {
            state.initialState.status.loggedIn = false;
        },
        unauthorized(state){
            state.initialState.status.loggedIn = false;
            state.initialState.status.CustomerloggedIn = false;
            state.initialState.user.user = null;
            state.initialState.user.access_token = null;
        },
    }
};
