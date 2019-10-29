import { forOwn } from 'lodash';
import store from '../state/store';
import { getIframeDocument } from '../iframe';
import event, { HIGHLIGHTER_RECALCPOS } from '../services/event';

function onMouseMove(e) {
  const { startPosition, currentHandle, selectionDimensions } = store.getters['highlighter/resizingProperties'];

  forOwn(selectionDimensions, ({ width, height }) => {
    if (currentHandle === 'width') {
      store.dispatch('style/setStyleProp', {
        selectionSet: store.getters['selection/selectionSet'],
        property: currentHandle,
        value: width + e.clientX - startPosition.x,
      });
    }

    if (currentHandle === 'height') {
      store.dispatch('style/setStyleProp', {
        selectionSet: store.getters['selection/selectionSet'],
        property: currentHandle,
        value: height + e.clientY - startPosition.y,
      });
    }
  });

  event.$emit(HIGHLIGHTER_RECALCPOS);
}

function onMouseUp() {
  // If the user was resizing (the stop resizing action isn't yet dispatched).
  if (store.getters['highlighter/isResizing']) {
    store.dispatch('highlighter/stopResizing');
  }
}

export function bindResizeEventHandlers() {
  getIframeDocument()
    .addEventListener('mousemove', (e) => {
      if (store.getters['highlighter/isResizing']) {
        onMouseMove(e);
      }
    });

  // Handle the mouse-up event on both the page document and the iframe's document.
  // This is because when the user moves the mouse faster then the event gets triggered,
  // the mouse-up event will trigger on the page document instead of the iframe's document.
  [document, getIframeDocument()].forEach((doc) => {
    doc.addEventListener('mouseup', () => {
      onMouseUp();
    });
  });
}
