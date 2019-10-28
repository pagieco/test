import { reflectNodeSelection } from '../../dom';

export const state = {
  selectionSet: [],
};

export const getters = {
  // Get the selectionset array.
  selectionSet(state) {
    return state.selectionSet;
  },

  // Determine if something is selected.
  hasSelection(state) {
    return state.selectionSet.length > 0;
  },

  // Determine if the given node is selected.
  isSelected(state) {
    return nodeIndex => state.selectionSet.indexOf(nodeIndex) > -1;
  },
};

export const mutations = {
  // Clear the selectionset.
  SELECTIONSET_CLEAR(state) {
    state.selectionSet.length = 0;
  },

  // Delete an item from the selectionset.
  SELECTIONSET_REMOVE(state, nodeIndex) {
    const index = state.selectionSet.indexOf(nodeIndex);

    if (index > -1) {
      state.selectionSet.splice(index, 1);
    }
  },

  // Replace the selectionset with the given item.
  SELECTIONSET_SET(state, nodeIndex) {
    state.selectionSet.length = 0;
    state.selectionSet.push(nodeIndex);
  },

  // Add an item to the selectionset.
  SELECTIONSET_ADD(state, nodeIndex) {
    if (!state.selectionSet.includes(nodeIndex)) {
      state.selectionSet.push(nodeIndex);
    }
  },
};

export const actions = {
  setNodeSelection({ getters, commit }, { originalEvent, nodeIndex }) {
    // If the meta-key is pressed and the node is already in the
    // selection set then the user wants to de-select the node
    // so we need to delete it from the selection if it exists.
    if (originalEvent.metaKey) {
      if (getters.selectionSet.includes(nodeIndex)) {
        commit('SELECTIONSET_REMOVE', nodeIndex);
      } else {
        commit('SELECTIONSET_ADD', nodeIndex);
      }
    } else {
      // Otherwise just one node needs to be selected so
      // we need to clear out the whole selection first.
      commit('SELECTIONSET_SET', nodeIndex);
    }

    reflectNodeSelection(getters.selectionSet);
  },

  deselectAllNodes({ commit, getters }) {
    getters.selectionSet.forEach((nodeIndex) => {
      commit('SELECTIONSET_REMOVE', nodeIndex);
    });
  },
};
