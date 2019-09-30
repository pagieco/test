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
  fetchFolders({ commit }) {
    return http.get('/asset-folders')
      .then(({ data }) => data)
      .then(({ data }) => {
        commit('SET_ASSET_FOLDERS', data);
      });
  },

  fetchAssets({ commit }) {
    console.log('yes');
    return http.get('/assets')
      .then(({ data }) => data)
      .then(({ data }) => {
        commit('SET_ASSETS', data);
      });
  },
};
