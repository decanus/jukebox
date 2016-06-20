/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildQuery } from '../url/query'

/**
 *
 * @param {string} type
 * @param {string|number} id
 * @param {number} page
 * @returns {Promise}
 */
export function fetchResults (type, id, page = 1) {
  switch (type) {
    case 'results':
      return fetchSearch(id, page)
    case 'artist-tracks':
      return fetchArtistTracks(id, page)
  }

  throw new Error(`unknown result type '${type}'`)
}

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
 * @param {number} artistId
 * @returns {Promise}
 */
export function fetchArtistProfiles (artistId) {
  return _fetch('/artist-web-profiles', [ [ 'artistId', artistId ] ])
}

/**
 *
 * @param {number} artistId
 * @param {number} page
 * @returns {Promise}
 */
export async function fetchArtistTracks (artistId, page = 1) {
  const resp = await _fetch('/artist-tracks', [ [ 'artistId', artistId ], [ 'page', page ] ])

  if (resp.status === 404) {
    return { type: 'artist-tracks', id: artistId, results: [], pagination: { size: 20, page: 1, pages: 1 } }
  }

  return resp
}

/**
 * @param {string} path
 */
export function resolvePath (path) {
  return _fetch('/resolve', [ [ 'path', path ] ])
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
