/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchSearch } from '../apr/apr'
import { app } from '../app'
import { Page } from '../routing/page'

/**
 *
 * @param {string} query
 * @returns {Promise<Page>}
 */
export function searchHandler (query) {
  const loader = app.getModelLoader()

  return fetchSearch(query)
    .then((results) => {
      return results.map((result) => loader.load(result))
    })
    .then((results) => {
      return new Page({ title: 'Jukebox Ninja - Search', template: 'search', data: { results, query } })
    })
}
