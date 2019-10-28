import store from '../state/store';
import { getNodeId } from './index';

export default class DomNode {
  /**
   * Create a new dom-node instance.
   *
   * @param htmlElement
   */
  constructor(htmlElement) {
    this.htmlElement = htmlElement;
    this.id = getNodeId(htmlElement);w

    this.bindEventHandlers();
  }

  /**
   * Bind the node's event handlers.
   *
   * @returns {void}
   */
  bindEventHandlers() {
    this.htmlElement.addEventListener('click', e => this.onClick(e));
    this.htmlElement.addEventListener('dblclick', e => this.onDblClick(e));
  }

  /**
   * Handle the node's onClick event.
   *
   * @param   {Event} e
   * @returns {void}
   */
  onClick(e) {
    e.stopPropagation();

    store.dispatch('selection/setNodeSelection', {
      originalEvent: e,
      nodeId: this.id,
    });
  }

  /**
   * Handle the node's dblClick event.
   *
   * @param   {Event} e
   * @returns {void}
   */
  onDblClick(e) {
    e.stopPropagation();

    store.dispatch('editor/setEditingNode', {
      nodeId: this.id,
    });
  }
}
