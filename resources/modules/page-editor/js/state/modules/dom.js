import { head, kebabCase } from 'lodash';
import DomNode from '../../dom/DomNode';
import { getNodeByIndex } from '../../dom';

export const state = {
  nodes: [],
};

export const getters = {
  nodes(state) {
    return state.nodes;
  },

  selector() {
    return function (selectionSet) {
      const selectorList = selectionSet.map(nodeIndex => getNodeByIndex(nodeIndex).selector);

      // Count the uniqueness of the retrieved selectors.
      // If there are more than one unique selectors in the list it means that we're
      // not able to retrieve a selector. Otherwise, just return the value.
      if (new Set(selectorList).size <= 1) {
        return head(selectorList);
      }

      return null;
    };
  },
};

export const mutations = {
  DOM_NODES_REPLACE(state, newNodes) {
    state.nodes = newNodes;
  },

  SET_SELECTOR(state, { nodeIndex, selector }) {
    getNodeByIndex(nodeIndex)
      .setSelector(kebabCase(selector));
  },
};

export const actions = {
  collectNodes({ commit }, collectedNodes) {
    commit('DOM_NODES_REPLACE', [...collectedNodes].map((n, i) => new DomNode(n, i)));
  },

  setSelector({ commit }, { selectionSet, selector }) {
    if (selectionSet.length === 0) {
      return;
    }

    selectionSet.forEach((nodeIndex) => {
      commit('SET_SELECTOR', {
        nodeIndex,
        selector,
      });
    });
  },
};
