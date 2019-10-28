export const state = {
  count: 0,
};

export const getters = {
  count(state) {
    return state.count;
  },
};

export const mutations = {
  INCREMENT(state) {
    state.count += 1;
  },
};

export const actions = {
  increment({ commit }) {
    commit('INCREMENT');
  },
};
