/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildQuery } from '../library/url/query'

/**
 *
 * @param {string} type
 * @param {string|number} id
 * @param {number} page
 * @param {string} include
 * @returns {Promise}
 */
export function fetchResults (type, id, page = 1, include = 'everything') {
  switch (type) {
    case 'results':
      return fetchSearch(id, page, include)
    case 'artist-tracks':
      return fetchArtistTracks(id, page)
  }

  throw new Error(`unknown result type '${type}'`)
}

/**
 *
 * @param {string} query
 * @param {number} page
 * @param {string} include
 * @returns {Promise}
 */
export function fetchSearch (query, page = 1, include = 'everything') {
  return _fetch('/search', [ [ 'query', query ], [ 'page', page ], [ 'type', include ] ])
}

/**a
 *
 * @param {number} artistId
 * @returns {Promise}
 */
export function fetchArtist (artistId) {
  return _fetch('/artist', [ [ 'id', artistId ] ])
}

/**
 *
 * @param {number} trackId
 * @returns {Promise}
 */
export function fetchTrack (trackId) {
  return _fetch('/track', [ [ 'id', trackId ] ])
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
 * @returns {Promise<{ username: string, email: string }>}
 */
export function fetchUser () {
  return fetch('/apr/me', { credentials: 'same-origin' })
    .then((resp) => resp.json())
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
