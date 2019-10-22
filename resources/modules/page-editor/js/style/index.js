import { kebabCase } from 'lodash';
import { getIframeDocument } from '../iframe';

const STYLESHEET_SELECTOR = 'page-css';

function removeStylesheet(selector) {
  const stylesheet = getIframeDocument().getElementById(selector);

  stylesheet.parentNode.removeChild(stylesheet);
}

function createStylesheet(selector) {
  const element = getIframeDocument().createElement('style');
  element.id = selector;

  getIframeDocument().head.appendChild(element);

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
  removeStylesheet(STYLESHEET_SELECTOR);
  createStylesheet(STYLESHEET_SELECTOR).insertRule(
    reduceMediaQueries(rules),
  );
}
