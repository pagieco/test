import router from '../router';
import { pick, mapValues } from 'lodash';
import { getIframeDocument } from '../iframe';

/**
 * Create a selector string for selecting a node.
 *
 * @param   {string | null} id
 * @returns {string}
 */
export function getDomNodeSelector(id = null) {
  return id ? `[data-p="${id}"]` : '[data-p]';
}

/**
 * Collect all nodes matching the given selector.
 *
 * @param   {string} selector
 * @param   {Document | null} document
 * @returns {NodeListOf<Element>}
 */
export function collectDomNodes(selector = getDomNodeSelector(), document = null) {
  return (document || getIframeDocument()).querySelectorAll(selector);
}

/**
 * Get the html instance of a node by the given node id.
 *
 * @param   {string} id
 * @param   {Document} document
 * @returns {Element | any}
 */
function getNodeElementById(id, document = getIframeDocument()) {
  return document.querySelector(getDomNodeSelector(id));
}

/**
 * Reflect the current node selection.
 *
 * @param   {Array} selectionSet
 * @param   {string} selectedClassName
 * @returns {void}
 */
export function reflectNodeSelection(selectionSet, selectedClassName = 'selected') {
  // If nothing is selected then force the sidebar to go to the home route.
  if (selectionSet.length === 0) {
    router.push({ name: 'root-panel' });
  }

  // Select all selected nodes from the dom and remove the selected classname.
  getIframeDocument().querySelectorAll(`.${selectedClassName}`).forEach((node) => {
    node.classList.remove(selectedClassName);
  });

  // Add the selected classname to the selected node(s).
  selectionSet.forEach((node) => {
    getNodeElementById(node).classList.add(selectedClassName);
  });
}

/**
 * Get the id of the given HTMLElement.
 *
 * @param   {HTMLElement} el
 * @returns {string | null}
 */
export function getNodeId(el) {
  return el.dataset.p || null;
}

/**
 * Create a random node id.
 *
 * @param   {Number} len
 * @returns {string}
 */
export function createNodeId(len = 20) {
  const arr = new Uint8Array(len / 2);

  (window.crypto || window.msCrypto).getRandomValues(arr);

  return Array.from(arr, dec => (`0${dec.toString(16)}`).substr(-2)).join('');
}

function getNodeRect(id, document = getIframeDocument()) {
  const element = getNodeElementById(id, document);

  return element ? element.getBoundingClientRect() : null;
}

export function getNodePosition(id, document = getIframeDocument()) {
  return pick(
    mapValues(getNodeRect(id, document).toJSON(), rect => `${rect}px`),
    'top', 'left', 'width', 'height',
  );
}

/**
 * Get the node's text contents.
 *
 * @param   {HTMLElement} node
 * @returns {string}
 */
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

/**
 *
 * @param   {Array} attributes
 * @returns {unknown}
 */
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
    textContent: getTextContents(rootNode),
    nodeAttributes: getNodeAttributes(rootNode.attributes),
    children: [],
  };

  const childNodes = rootNode.querySelectorAll(`:scope > ${getDomNodeSelector()}`);

  tree.children = [...childNodes].map(child => serialize(child));

  return tree;
}
