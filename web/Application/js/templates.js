/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { renderHomeTemplate } from './templates/home'
import { renderPageNotFoundTemplate } from './templates/page-not-found'
import { renderLoremTemplate } from './templates/lorem'

/**
 *
 * @type {{}}
 */
const TEMPLATES = {
  home: renderHomeTemplate,
  pageNotFound: renderPageNotFoundTemplate,
  lorem: renderLoremTemplate
}

/**
 *
 * @param {string} templateName
 * @returns {Function}
 */
export function resolveTemplate (templateName) {
  if (typeof TEMPLATES[ templateName ] === 'function') {
    return TEMPLATES[ templateName ]
  }

  throw new Error(`could not find template ${templateName}`)
}

/**
 *
 * @param {string} templateName
 * @param {Document} document
 * @param {{}} data
 */
export function renderTemplate (templateName, document, data) {
  return resolveTemplate(templateName)(document, data)
}
