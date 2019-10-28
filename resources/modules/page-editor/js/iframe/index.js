function getIframeElement() {
  return document.getElementById('canvas-frame');
}

export function getIframeDocument(iframe = getIframeElement()) {
  return iframe.contentDocument || iframe.contentWindow.document;
}

export function replaceIframePlaceholder(placeholder) {
  placeholder.parentNode.replaceChild(getIframeElement(), placeholder);
}

export async function wrapPageIntoIframe() {
  const iframe = getIframeElement();
  const { head, body } = getIframeDocument(iframe);

  document.querySelectorAll('#page-contents > *')
    .forEach((el) => {
      body.appendChild(el);
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
