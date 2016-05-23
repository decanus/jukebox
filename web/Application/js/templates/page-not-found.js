/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchDom } from '../dom/fetch-dom'

/**
 *
 * @param {Document} doc
 */
export function renderPageNotFoundTemplate (doc) {
  return fetchDom(doc, '/html/404.html')
}
