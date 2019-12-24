import Vue from 'vue';
import { head, kebabCase } from 'lodash';
import { getDomNodeSelector } from '../../dom';
import { reflectStylesheet } from '../../style';
import { getMediaQuery } from '../../style/media-query';

export const state = {
  currentMediaQuery: 'desktop',
  rules: {},
};

export const getters = {
  currentMediaQuery(state) {
    return state.currentMediaQuery;
  },

  rules(state) {
    return state.rules;
  },

  styleRule(state, getters) {
    return (selection, prop) => {
      const query = getMediaQuery(getters.currentMediaQuery);

      // If the mediaQuery isn't used before in the ruleset,
      // create an empty object for that ruleset.
      if (!state.rules[query]) {
        state.rules[query] = {};
      }

      // Map trough each element in selectionList and try
      // to retrieve the property in the css rules list.
      const styleList = selection.map((nodeIndex) => {
        const selector = getDomNodeSelector(nodeIndex);

        // If the selector isn't used before in the mediaquery,
        // create an empty object for that selector.
        if (!state.rules[query][selector]) {
          state.rules[query][selector] = {};
        }

        const rule = state.rules[query][selector];

        return rule[kebabCase(prop)] || null;
      });

      // Count the uniques of the retrieved style properties.
      // If there are more then one unique elements in the list it means that we're
      // not able to retrieve the style value. Otherwise, just return the value.
      if (new Set(styleList).size <= 1) {
        return head(styleList);
      }

      return null;
    };
  },
};

export const mutations = {
  SET_STYLE_PROP(state, { nodeIndex, property, value }) {
    const mq = getMediaQuery(state.currentMediaQuery);
    const selector = getDomNodeSelector(nodeIndex);

    if (!state.rules[mq]) {
      state.rules[mq] = {};
    }

    if (Array.isArray(state.rules[mq][selector])) {
      state.rules[mq][selector] = {};
    }

    if (!state.rules[mq][selector]) {
      state.rules[mq][selector] = {};
    }

    Vue.set(state.rules[mq][selector], property, value);

    reflectStylesheet(
      JSON.parse(JSON.stringify(state.rules)),
    );
  },

  SET_MEDIA_QUERY(state, mediaQuery) {
    state.currentMediaQuery = mediaQuery;
  },
};

export const actions = {
  setStyleProp({ commit }, style) {
    const { selectionSet } = style;

    if (selectionSet.length === 0) {
      return;
    }

    selectionSet.forEach((nodeIndex) => {
      commit('SET_STYLE_PROP', { nodeIndex, ...style });
    });
  },

  setMediaQuery({ commit }, mediaQuery) {
    commit('SET_MEDIA_QUERY', mediaQuery);
  },
};
