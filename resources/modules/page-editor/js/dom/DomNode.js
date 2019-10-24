import store from '../state/store';
import { getNodeId } from './index';

export default class DomNode {
  constructor(htmlElement) {
    this.htmlElement = htmlElement;
    this.id = getNodeId(htmlElement);

    this.bindEventHandlers();
  }

  bindEventHandlers() {
    this.htmlElement.addEventListener('click', e => this.onClick(e));
  }

  onClick(e) {
    e.stopPropagation();

    store.dispatch('selection/setNodeSelection', {
      originalEvent: e,
      nodeId: this.id,
    });
  }
}
