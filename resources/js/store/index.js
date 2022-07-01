import axios from 'axios';
import { createStore } from 'vuex'
import sharedMutations from 'vuex-shared-mutations';
import Swal from "sweetalert2";

export default createStore({
    state: {
        user: null,
        articles: [],
        article: [],
    },
    getters: {
        user(state) {
            return state.user;
        },
        id(state) {
            if (state.user) return state.user.id
            return null;
        },
        articles(state) {
            return state.articles;
        },
        articleById: (state) => (id) => {
            return state.articles.find(articles => articles.id === id);
        },
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
        setArticles(state,payload){
            state.articles = payload;
        },
        setArticle(state,payload){
            state.articles.push(payload);
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
                    return dispatch('login' , { 'email' : payload.email , 'password' : payload.password});
                }).catch((err) => {
                    throw(err.response);
                })
            } catch (e) {
                throw (e);
            }
        },
        async verifyResend({dispatch} , payload){
            await axios.post('/api/verify-resend' , payload).then((res) => {
                Swal.fire({
                    title: 'Success',
                    text:  res.data.message,
                    icon: 'success',
                });
            }).catch((err) => {
                throw(err.response);
            })
        },
        async verifyEmail({dispatch} , payload){
            await axios.post('/api/verify-email/' + payload.id + '/' + payload.hash)
                .then((res) => {
                    Swal.fire({
                        title: 'Success',
                        text:  res.data.message,
                        icon: 'success',
                    });
                }).catch((err) => {
                    throw(err.response);
                })
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
            }).catch((err) => {})
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
                throw err.response;
            })
        },
        async getAllArticles({commit}){
            await axios.get('/api/articles')
                .then((response)=>{
                    commit('setArticles',response.data.data);
                }).catch((err) => {
                    throw(err.response);
                })
        },
        async addArticle({ dispatch }, payload) {
            try {
                await axios.post('/api/articles' , payload).then((res) => {
                    dispatch("getAllArticles");
                    Swal.fire({
                        title: 'Success',
                        text:  res.data.message,
                        icon: 'success',
                    });
                }).catch((err) => {
                    throw(err.response);
                })
            } catch (e) {
                throw (e);
            }
        },
        async updateArticle({dispatch}, payload) {
            await axios.patch('/api/articles/'+payload.id, payload).then((res) => {
                dispatch("getAllArticles");
                Swal.fire({
                    title: 'Success',
                    text:  res.data.message,
                    icon: 'success',
                });
            }).catch((err) => {
                throw err.response;
            })
        },
        async deleteArticle({dispatch},payload) {
            await axios.delete('/api/articles/'+payload.id).then((res) => {
                dispatch("getAllArticles");
                Swal.fire({
                    title: 'Success',
                    text:  res.data.message,
                    icon: 'success',
                });
            }).catch((err) => {
                throw err.response;
            })
        },

    },
    plugins: [sharedMutations({ predicate: ['setUser'] })],
})
