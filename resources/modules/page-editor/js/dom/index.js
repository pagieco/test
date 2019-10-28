import { mapValues, pick } from 'lodash';
import { getIframeDocument } from '../iframe';
import store from '../state/store';

export function getNodeByIndex(index) {
  return store.getters['dom/nodes'][index];
}

function getNodeElementByIndex(index) {
  return getNodeByIndex(index).htmlElement;
}

function getNodeRect(index) {
  return getNodeElementByIndex(index)
    .getBoundingClientRect();
}

export function getNodePosition(index) {
  const nodeRect = getNodeRect(index)
    .toJSON();

  return pick(mapValues(nodeRect, r => `${r}px`), ['top', 'left', 'width', 'height']);
}

export function getDomNodeSelector(index) {
  return getNodeByIndex(index).nodeType;
}

export function reflectNodeSelection(selectionSet, selectedClassName = 'selected') {
  getIframeDocument()
    .querySelectorAll(`.${selectedClassName}`)
    .forEach((node) => {
      node.classList.remove(selectedClassName);
    });

  selectionSet.forEach((index) => {
    getNodeElementByIndex(index)
      .classList
      .add(selectedClassName);
  });
}

export function collectDomNodes(document) {
  const { body } = document;

  // Collect all nodes from the body including the body itself.
  return [body, ...body.querySelectorAll(':not(.skip-collection)')];
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
    // ...
  ];

  return Array.from(attributes)
    .filter(attr => !skipAttributes.includes(attr.name))
    .reduce((obj, param) => {
      obj[param.name] = param.value;

      return obj;
    }, {});
}

export function serialize(rootNode) {
  let nodeIndex = 0;

  function serializeNode(node) {
    const tree = {
      nodeIndex,
      nodeType: node.nodeName,
      nodeAttributes: getNodeAttributes(node.attributes),
      textContents: getTextContents(node),
      children: [],
    };

    nodeIndex += 1;

    tree.children = [
      ...node.querySelectorAll(':scope > :not(.skip-collection)'),
    ].map(child => serializeNode(child));

    return tree;
  }

  return serializeNode(rootNode);
}
