import http from '../../services/http';

export const state = {
  profiles: [],
  profileEvents: [],
};

export const getters = {
  profiles(state) {
    return state.profiles;
  },

  profileEvents(state) {
    return state.profileEvents;
  },
};

export const mutations = {
  SET_PROFILES(state, profiles) {
    state.profiles = profiles;
  },

  SET_PROFILE_EVENTS(state, events) {
    state.profileEvents = events;
  },
};

export const actions = {
  fetchProfiles({ commit }) {
    commit('SET_PROFILES', []);

    return http.get('/profiles')
      .then(({ status, data }) => {
        if (status === 204) {
          commit('SET_PROFILES', []);
        } else {
          commit('SET_PROFILES', data.data);
        }
      });
  },

  fetchProfileEvents({ commit }, profileId) {
    commit('SET_PROFILE_EVENTS', []);

    return http.get(`/profiles/${profileId}/events`)
      .then(({ status, data }) => {
        if (status === 204) {
          commit('SET_PROFILE_EVENTS', []);
        } else {
          commit('SET_PROFILE_EVENTS', data.data);
        }
      });
  },
};
