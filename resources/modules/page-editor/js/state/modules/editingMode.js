export const state = {
  editingNodeIndex: null,
};

export const getters = {
  // Determine whether the editing mode is enabled.
  enabled(state) {
    return state.editingNodeIndex !== null;
  },

  // Get the index of the editing node.
  editingNodeIndex(state) {
    return state.editingNodeIndex;
  },
};

export const mutations = {
  // Set the current editing node index. The index refers
  // to the dom node's index in the selection-set.
  SET_EDITING_NODE_INDEX(state, nodeIndex) {
    state.editingNodeIndex = nodeIndex;
  },
};

export const actions = {
  enableFor({ commit }, nodeIndex) {
    commit('SET_EDITING_NODE_INDEX', nodeIndex);
  },

  disable({ commit }) {
    commit('SET_EDITING_NODE_INDEX', null);
  },
};
