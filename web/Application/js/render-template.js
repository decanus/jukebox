/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createFragmentFromString } from './dom/fragment'

/**
 *
 * @param {string} templateName
 * @param {Document} document
 * @param {{}} data
 * @returns {DocumentFragment}
 */
export function renderTemplate (templateName, document, data) {
  //noinspection JSUnresolvedVariable
  return createFragmentFromString(
    document,
    Handlebars.templates[templateName](data, {})
  )
}
