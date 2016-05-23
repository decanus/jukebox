/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchDom } from '../dom/fetch-dom'

/**
 *
 * @param {Document} doc
 * @returns {Promise<DocumentFragment>}
 */
export function renderHomeTemplate (doc) {
  return fetchDom(doc, '/html/homepage.html')
}
