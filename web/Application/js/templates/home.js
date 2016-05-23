/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createFragmentFromString } from '../dom/fragment'

/**
 *
 * @param {Document} doc
 * @returns {Promise<DocumentFragment>}
 */
export function renderHomeTemplate (doc) {
  return fetch('/html/homepage.html')
    .then((response) => response.text())
    .then((text) => createFragmentFromString(doc, text))
}
