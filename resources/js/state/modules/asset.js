import http from '../../services/http';

export const state = {
  folders: [],
  assets: [],
};

export const getters = {
  folders(state) {
    return state.folders;
  },

  assets(state) {
    return state.assets;
  },
};

export const mutations = {
  SET_ASSET_FOLDERS(state, folders) {
    state.folders = folders;
  },

  SET_ASSETS(state, assets) {
    state.assets = assets;
  },
};

export const actions = {
  clearFolders({ commit }) {
    commit('SET_ASSET_FOLDERS', []);
  },

  clearAssets({ commit }) {
    commit('SET_ASSETS', []);
  },

  fetchFolders({ commit }) {
    return http.get('/asset-folders')
      .then(({ status, data }) => {
        if (status === 204) {
          commit('SET_ASSET_FOLDERS', []);
        } else {
          commit('SET_ASSET_FOLDERS', data.data);
        }
      });
  },

  fetchAssets({ commit }) {
    return http.get('/assets')
      .then(({ status, data }) => {
        if (status === 204) {
          commit('SET_ASSETS', []);
        } else {
          commit('SET_ASSETS', data.data);
        }
      });
  },
};
