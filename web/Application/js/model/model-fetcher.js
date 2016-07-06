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

import { ResultId } from '../value/result-id'

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
      case 'artist-images':
        return this.fetchArtistImage(id)
      case 'artists':
        return this.fetchArtist(id)
      case 'tracks':
        return this.fetchTrack(id)
    }

    return Promise.reject(new Error(`unable to fetch model with type ${type}`))
  }

  /**
   *
   * @param {ResultId} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  async fetchResult (id) {
    // todo: add support for multiple includes
    const result = await fetchSearch(id.query, 1, id.includes[ 0 ])

    if (Array.isArray(result)) {
      return { type: 'results', id, results: [], includes: [], pagination: { size: 20, page: 1, pages: 1 } }
    }

    result.type = 'results'
    result.id = new ResultId(id.query, Array.from(id.includes))

    return result
  }

  /**
   *
   * @param {ResultId} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  async fetchArtistTracks (id) {
    const result = await fetchArtistTracks(id.query)

    result.type = 'artist-tracks'
    result.id = id

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
   * @param {number} artistId
   * @returns {{ id: number, name: string }}
   */
  async fetchArtistImage (artistId) {
    const artist = await this.fetchArtist(artistId)

    return {
      id: artistId,
      type: 'artist-images',
      name: artist[ 'image' ]
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
