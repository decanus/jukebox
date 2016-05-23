/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createFragmentFromString } from '../dom/fragment'

/**
 *
 * @param {Document} doc
 * @param {string} url
 * 
 * @returns {Promise<DocumentFragment>}
 */
export function fetchDom (doc, url) {
  return fetch(url, {mode: 'same-origin'})
    .then((response) => response.text())
    .then((html) => createFragmentFromString(doc, html))
}
