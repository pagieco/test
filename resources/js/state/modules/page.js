import http from '../../services/http';

export const state = {
  pages: [],
};

export const getters = {
  pages(state) {
    return state.pages;
  },
};

export const mutations = {
  SET_PAGES(state, pages) {
    state.pages = pages;
  },
};

export const actions = {
  fetchPages({ commit }) {
    return http.get('/pages')
      .then(({ data }) => data)
      .then(({ data }) => {
        commit('SET_PAGES', data);
      });
  },
};
