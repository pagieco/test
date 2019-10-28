export const state = {
  editingNode: null,
};

export const getter = {
  editingNode(state) {
    return state.editingNode;
  },
};

export const mutations = {
  SET_EDITING_NODE(state, nodeId) {
    state.editingNode = nodeId;
  },
};

export const actions = {
  setEditingNode({ commit }, nodeId) {
    commit('SET_EDITING_NODE', nodeId);
  },
};
