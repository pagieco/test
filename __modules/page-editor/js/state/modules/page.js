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
    commit('SET_PAGES', []);

    return http.get('/pages')
      .then(({ status, data }) => {
        if (status === 200) {
          commit('SET_PAGES', data.data);
        }
      });
  },
};
