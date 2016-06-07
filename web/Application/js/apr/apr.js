/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildQuery } from '../url/build-query'

/**
 *
 * @param {string} query
 * @returns {Promise}
 */
export function fetchSearch (query) {
  return _fetch('/search', [ [ 'query', query ] ])
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
