import http from '../../services/http';

export const state = {
  collections: [],
  collection: null,
};

export const getters = {
  collections(state) {
    return state.collections;
  },

  collection(state) {
    return state.collection;
  },
};

export const mutations = {
  SET_COLLECTIONS(state, collections) {
    state.collections = collections;
  },

  SET_COLLECTION(state, collection) {
    state.collection = collection;
  },
};

export const actions = {
  fetchCollections({ commit }) {
    commit('SET_COLLECTIONS', []);

    return http.get('/collections')
      .then(({ status, data }) => {
        if (status === 200) {
          commit('SET_COLLECTIONS', data.data);
        }
      });
  },

  fetchCollection({ commit }, collectionId) {
    commit('SET_COLLECTION', null);

    return http.get(`/collections/${collectionId}`)
      .then(({ status, data }) => {
        if (status === 200) {
          commit('SET_COLLECTION', data.data);
        }
      });
  },
};
