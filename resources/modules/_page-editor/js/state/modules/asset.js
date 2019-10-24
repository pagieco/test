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
};

export const actions = {
  fetchAssets({ commit }) {
    commit('SET_ASSETS', []);

    return http.get('/assets')
      .then(({ status, data }) => {
        if (status === 200) {
          commit('SET_ASSETS', data.data);
        }
      });
  },
};
