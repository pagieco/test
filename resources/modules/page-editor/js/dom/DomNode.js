import store from '../state/store';

export default class DomNode {
  constructor(htmlElement, index) {
    this.htmlElement = htmlElement;
    this.nodeType = String(htmlElement.nodeName).toLowerCase();
    this.index = index;

    this.bindEventHandlers();
  }

  bindEventHandlers() {
    this.htmlElement.addEventListener('click', e => this.onClick(e));
    this.htmlElement.addEventListener('dblclick', e => this.onDblClick(e));
  }

  onClick(e) {
    e.stopPropagation();

    store.dispatch('selection/setNodeSelection', {
      originalEvent: e,
      nodeIndex: this.index,
    });
  }

  onDblClick(e) {
    e.preventDefault();
    e.stopPropagation();

    store.dispatch('editingMode/enableFor', this.index);
  }
}
