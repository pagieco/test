import http from '../../services/http';

export const state = {
  workflows: [],
};

export const getters = {
  workflows(state) {
    return state.workflows;
  },
};

export const mutations = {
  SET_WORKFLOWS(state, workflows) {
    state.workflows = workflows;
  },
};

export const actions = {
  fetchWorkflows({ commit }) {
    return http.get('/workflows')
      .then(({ data }) => data)
      .then(({ data }) => {
        commit('SET_WORKFLOWS', data);
      });
  },
};
