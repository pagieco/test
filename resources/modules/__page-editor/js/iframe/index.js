import { getDomNodeSelector } from '../dom';

/**
 * Get the iframe element.
 *
 * @returns {HTMLElement}
 */
function getIframeElement() {
  return document.getElementById('canvas-frame');
}

/**
 * Get the iframe's document.
 *
 * @param   {HTMLElement | null} iframe
 * @returns {Document}
 */
export function getIframeDocument(iframe = null) {
  const element = iframe || getIframeElement();

  return element.contentDocument || element.contentWindow.document;
}

/**
 * Wrap the page into an iframe element.
 *
 * @param   {string} selector
 * @returns {Promise<unknown>}
 */
export function wrapPageIntoIframe(selector) {
  return new Promise((resolve) => {
    const iframe = document.createElement('iframe');

    iframe.id = 'canvas-frame';

    iframe.addEventListener('load', () => {
      const { head, body } = getIframeDocument(iframe);

      document.querySelectorAll('link.editor-asset').forEach((asset) => {
        head.appendChild(asset);
      });

      document.querySelectorAll(`#page-contents > ${getDomNodeSelector()}`).forEach((el) => {
        body.appendChild(el);
      });

      document.querySelectorAll('script.editor-asset').forEach((asset) => {
        body.appendChild(asset);
      });

      document.getElementById('page-contents').remove();

      setTimeout(() => {
        resolve();
      }, 1000);
    });

    document.querySelector(selector).appendChild(iframe);
  });
}
