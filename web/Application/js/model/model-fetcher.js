/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import {
  fetchSearch,
  fetchArtistTracks,
  fetchArtistProfiles,
  fetchArtist,
  fetchTrack
} from '../app/apr'

export class ModelFetcher {
  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  fetch ({ type, id }) {
    switch (type) {
      case 'results':
        return this.fetchResult(id)
      case 'artist-tracks':
        return this.fetchArtistTracks(id)
      case 'artist-profiles':
        return this.fetchArtistProfiles(id)
      case 'artists':
        return this.fetchArtist(id)
      case 'tracks':
        return this.fetchTrack(id)
    }

    return Promise.reject(new Error(`unable to fetch model with type ${type}`))
  }

  /**
   *
   * @param {string} query
   * @returns {Promise<{ type: string, id: number }>}
   */
  async fetchResult (query) {
    const result = await fetchSearch(query)

    if (Array.isArray(result)) {
      return { type: 'results', id: query, results: [], pagination: { size: 20, page: 1, pages: 1 } }
    }

    result.type = 'results'
    result.id = query

    return result
  }

  /**
   *
   * @param {number} artistId
   * @returns {Promise<{ type: string, id: number }>}
   */
  async fetchArtistTracks (artistId) {
    const result = await fetchArtistTracks(artistId)

    result.type = 'artist-tracks'
    result.id = artistId

    return result
  }

  /**
   *
   * @param {number} artistId
   * @returns {Promise<{type: string, id: number, profiles: Promise}>}
   */
  async fetchArtistProfiles (artistId) {
    const profiles = await fetchArtistProfiles(artistId)

    return {
      type: 'artist-profiles',
      id: artistId,
      profiles
    }
  }

  /**
   *
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  fetchArtist (id) {
    return fetchArtist(id)
  }

  /**
   *
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  fetchTrack (id) {
    return fetchTrack(id)
  }
}
