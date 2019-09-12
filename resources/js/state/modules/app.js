import http from '../../services/http';

export const state = {

};

export const getters = {

};

export const mutations = {

};

export const actions = {
  init({ dispatch }) {
    dispatch('fetchCurrentUser');
  },

  fetchCurrentUser() {
    return http.get('/user');
  },
};
