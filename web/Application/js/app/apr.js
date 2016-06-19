/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildQuery } from '../url/query'

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
 * @returns {Promise}
 */
export async function fetchArtistTracks (artistId) {
  const resp = await _fetch('/artist-tracks', [ [ 'artistId', artistId ] ])

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
