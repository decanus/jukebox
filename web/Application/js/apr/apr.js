/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildQuery } from '../url/build-query'

/**
 *
 * @param {string} query
 * @param {number} page
 * @returns {Promise}
 */
export function fetchSearch (query, page = 1) {
  return _fetch('/search', [ [ 'query', query ], [ 'page', page ] ])
}

/**
 *
 * @param {string} path
 * @param {Array<Array<string>>} queryParams
 * @returns {Promise}
 * @private
 */
function _fetch (path, queryParams) {
  let url = `/apr${path}`
  const query = buildQuery(queryParams)

  if (query.length > 0) {
    url += `?${query}`
  }

  return fetch(url).then((resp) => resp.json())
}
