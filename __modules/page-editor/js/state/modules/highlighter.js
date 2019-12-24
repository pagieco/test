import { pick } from 'lodash';
import { getNodeRect } from '../../dom';

export const state = {
  isResizing: false,
  resizingProperties: {},
};

export const getters = {
  isResizing(state) {
    return state.isResizing;
  },

  resizingProperties(state) {
    return JSON.parse(JSON.stringify(state.resizingProperties));
  },
};

export const mutations = {
  HIGHLIGHTER_IS_RESIZING(state, isResizing) {
    state.isResizing = isResizing;
  },

  HIGHLIGHTER_RESIZE(state, resizingProperties) {
    state.resizingProperties = resizingProperties;
  },
};

export const actions = {
  startResizing({ commit, rootGetters }, { startPosition, currentHandle }) {
    const selectionDimensions = {};

    rootGetters['selection/selectionSet'].forEach((nodeIndex) => {
      selectionDimensions[nodeIndex] = pick(getNodeRect(nodeIndex), ['width', 'height']);
    });

    commit('HIGHLIGHTER_IS_RESIZING', true);
    commit('HIGHLIGHTER_RESIZE', {
      startPosition,
      currentHandle,
      selectionDimensions,
    });
  },

  stopResizing({ commit }) {
    commit('HIGHLIGHTER_IS_RESIZING', false);
  },
};
