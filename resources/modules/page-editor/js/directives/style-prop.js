import Vue from 'vue';
import { debounce, kebabCase } from 'lodash';
import event, { HIGHLIGHTER_RECALCPOS } from '../services/event';

const INPUT_DEBOUNCE_WAIT_TIME = 100;

Vue.directive('style-prop', {
  bind(el, binding, vnode) {
    const store = vnode.context.$store;

    el.addEventListener('input', debounce((e) => {
      const selectionSet = store.getters['selection/selectionSet'];

      event.$emit(HIGHLIGHTER_RECALCPOS, { selectionSet });

      return store.dispatch('style/setStyleProp', {
        selectionSet,
        property: kebabCase(binding.value),
        value: e.target.value,
      });
    }, INPUT_DEBOUNCE_WAIT_TIME));
  }
});
