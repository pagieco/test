import http from '../../services/http';

export const state = {
  assets: [],
};

export const getters = {
  assets(state) {
    return state.assets;
  },
};

export const mutations = {
  SET_ASSETS(state, assets) {
    state.assets = assets;
  },

  SORT_ASSETS(state, direction) {
    state.assets.sort((a, b) => (
      direction === 'desc'
        ? b.id - a.id
        : a.id - b.id
    ));
  },
};

export const actions = {
  fetchAssets({ commit }) {
    return http.get('/assets')
      .then(({ data }) => data)
      .then(({ data }) => {
        commit('SET_ASSETS', data);
      });
  },

  sortAssets({ commit }, direction) {
    commit('SORT_ASSETS', direction);
  },
};
