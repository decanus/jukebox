/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchSearch } from '../apr/apr'

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
    }

    return Promise.reject(new Error(`unable to fetch model with type ${type}`))
  }

  /**
   *
   * @param {string} query
   * @returns {Promise<{ type: string, id: number }>}
   */
  fetchResult (query) {
    return fetchSearch(query)
  }

  /**
   *
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   * @todo: implement
   */
  fetchArtist (id) {

  }

  /**
   *
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   * @todo: implement
   */
  fetchTrack (id) {

  }
}
