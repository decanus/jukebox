/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createFragmentFromString } from '../dom/fragment'

/**
 *
 * @param {Document} doc
 */
export function renderPageNotFoundTemplate (doc) {
  return fetch('/html/404.html')
    .then((response) => response.text())
    .then((text) => createFragmentFromString(doc, text))
}
