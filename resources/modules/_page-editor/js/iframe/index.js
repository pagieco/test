import { getDomNodeSelector } from '../dom';

export function getIframeElement() {
  return document.getElementById('canvas-frame');
}

export function getIframeDocument(iframe = null) {
  const element = iframe || getIframeElement();

  return element.contentDocument || element.contentWindow.document;
}

export function replaceIframePlaceholder(placeholder) {
  const iframe = getIframeElement();

  placeholder.parentNode.replaceChild(iframe, placeholder);
}

export async function wrapPageIntoIframe() {
  const iframe = getIframeElement();

  const { head, body } = getIframeDocument(iframe);

  document.querySelectorAll(`#page-contents > ${getDomNodeSelector()}`)
    .forEach((el) => {
      iframe.contentDocument.body.appendChild(el);
    });

  body.appendChild(document.getElementById('local-app'));

  document.querySelectorAll('link.editor-asset')
    .forEach((asset) => {
      head.appendChild(asset);
    });

  document.getElementById('page-contents')
    .remove();

  return Promise.resolve(iframe);
}
