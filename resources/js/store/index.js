import axios from 'axios';
import { createStore } from 'vuex'
import sharedMutations from 'vuex-shared-mutations';
import Swal from "sweetalert2";

export default createStore({
    state: {
        user: null,
    },
    getters: {
        user(state) {
            return state.user;
        },

        id(state) {
            if (state.user) return state.user.id
            return null
        }
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
    },

    actions: {
        async login({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie');

                await axios.post('/api/login', payload).then((res) => {
                    localStorage.setItem('token', res.data.data.access_token);
                    return dispatch('getUser');
                }).catch((err) => {
                    throw err.response;
                });
            } catch (e) {
                throw e
            }
        },

        async register({ dispatch }, payload) {
            try {
                await axios.post('/api/registration' , payload).then((res) => {
                    return dispatch('login' , { 'email' : payload.email , 'password' : payload.password})
                }).catch((err) => {
                    throw(err.response)
                })
            } catch (e) {
                throw (e)
            }
        },
        async logout({ commit }) {
            await axios.post('/api/logout').then((res) => {
                commit('setUser', null);
            }).catch((err) => {
                throw err.response;
            })
        },
        async getUser({commit}) {
            axios.defaults.headers.common['Authorization'] = `Bearer `+ localStorage.getItem('token');
            await axios.get('/api/user').then((res) => {
                commit('setUser', res.data.data);
            }).catch((err) => {
                //throw err.response
            })
        },
        async updateUser({commit},payload) {
            await axios.patch('/api/user/update', payload).then((res) => {
                commit('setUser', res.data.data);
                Swal.fire({
                    title: 'Success',
                    text:  res.data.message,
                    icon: 'success',
                });
            }).catch((err) => {
                throw err.response
            })
        },
    },
    plugins: [sharedMutations({ predicate: ['setUser'] })],


})
