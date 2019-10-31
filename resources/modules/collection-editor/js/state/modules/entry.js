import http from '../../services/http';

export const state = {
  entries: [],
};

export const getters = {
  entries(state) {
    return state.entries;
  },
};

export const mutations = {
  SET_ENTRIES(state, entries) {
    state.entries = entries;
  },
};

export const actions = {
  fetchEntries({ commit }, collectionId) {
    commit('SET_ENTRIES', []);

    return http.get(`/collections/${collectionId}/entries`)
      .then(({ status, data }) => {
        if (status === 200) {
          commit('SET_ENTRIES', data.data);
        }
      });
  },
};
