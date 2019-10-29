import store from '../state/store';

export default class DomNode {
  constructor(htmlElement, index) {
    this.nodeType = String(htmlElement.nodeName).toLowerCase();
    this.htmlElement = htmlElement;
    this.index = index;

    this.bindEventHandlers();
  }

  bindEventHandlers() {
    this.htmlElement.addEventListener('click', this.onClick.bind(this));
    this.htmlElement.addEventListener('dblclick', this.onDblClick.bind(this));
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

  setSelector(selector) {
    this.selector = selector;
    this.htmlElement.dataset.style = selector;
  }
}
