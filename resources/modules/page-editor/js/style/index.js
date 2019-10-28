import { kebabCase } from 'lodash';
import { getIframeDocument } from '../iframe';

const STYLESHEET_SELECTOR = 'page-css';

function removeStylesheet() {
  const stylesheet = getIframeDocument()
    .getElementById(STYLESHEET_SELECTOR);

  stylesheet.parentNode.removeChild(stylesheet);
}

function createStylesheet() {
  const element = getIframeDocument()
    .createElement('style');

  element.id = STYLESHEET_SELECTOR;

  getIframeDocument()
    .head
    .appendChild(element);

  return element.sheet;
}

function reduceProperties(properties) {
  return Object
    .entries(properties)
    .reduce((string, [property, value]) => `${string}${kebabCase(property)}:${value};`, '');
}

function reduceRules(rules) {
  return Object
    .entries(rules)
    .reduce((string, [selector, properties]) => `${string}${selector}{${reduceProperties(properties)}}`, '');
}

function reduceMediaQueries(mediaQueries) {
  return Object
    .entries(mediaQueries)
    .reduce((string, [query, rules]) => `${string} @media ${query}{${reduceRules(rules)}`, '');
}

export function reflectStylesheet(rules) {
  removeStylesheet();
  createStylesheet()
    .insertRule(reduceMediaQueries(rules));
}
