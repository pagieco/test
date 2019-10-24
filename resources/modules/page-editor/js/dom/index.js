import { mapValues, pick } from 'lodash';
import { getIframeDocument } from '../iframe';

export function getDomNodeSelector(id = null) {
  return id ? `[data-p="${id}"]` : '[data-p]';
}

export function getNodeId(el) {
  return el.dataset.p || null;
}

function getNodeElementById(id, document = getIframeDocument()) {
  return document.querySelector(getDomNodeSelector(id));
}

function getNodeRect(id, document = getIframeDocument()) {
  const element = getNodeElementById(id, document);

  return element ? element.getBoundingClientRect() : null;
}

export function getNodePosition(id, document = getIframeDocument()) {
  const nodeRect = getNodeRect(id, document)
    .toJSON();

  return pick(mapValues(nodeRect, r => `${r}px`), ['top', 'left', 'width', 'height']);
}

export function reflectNodeSelection(selectionSet, selectedClassName = 'selected') {
  if (selectionSet.length === 0) {
    // ...
  }

  getIframeDocument()
    .querySelectorAll(`.${selectedClassName}`)
    .forEach((node) => {
      node.classList.remove(selectedClassName);
    });

  selectionSet.forEach((nodeId) => {
    getNodeElementById(nodeId)
      .classList
      .add(selectedClassName);
  });
}

export function collectDomNodes(selector = getDomNodeSelector(), document = null) {
  return (document || getIframeDocument()).querySelectorAll(selector);
}

function getTextContents(node) {
  let textContent = '';

  for (let i = 0; i < node.childNodes.length; i++) {
    const currNode = node.childNodes[i];

    if (currNode.nodeName === '#text') {
      textContent = currNode.nodeValue.trim();
      break;
    }
  }

  return textContent;
}

function getNodeAttributes(attributes) {
  const skipAttributes = [
    'data-id', 'class',
  ];

  return Array.from(attributes)
    .filter(attr => !skipAttributes.includes(attr.name))
    .reduce((obj, param) => {
      obj[param.name] = param.value;

      return obj;
    }, {});
}

export function serialize(rootNode) {
  const tree = {
    uuid: getNodeId(rootNode),
    nodeType: rootNode.nodeName,
    textContents: getTextContents(rootNode),
    nodeAttributes: getNodeAttributes(rootNode.attributes),
    children: [],
  };

  tree.children = [
    ...rootNode.querySelectorAll(`:scope > ${getDomNodeSelector()}`),
  ].map(child => serialize(child));

  return tree;
}
