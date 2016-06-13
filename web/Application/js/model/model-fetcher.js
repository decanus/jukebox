/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchSearch } from '../app/apr'

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
      .then((result) => {
        if (Array.isArray(result)) {
          // todo: should this be done in php?
          return { type: 'results', id: query, results: [], pagination: { size: 20, page: 1, pages: 1}}
        }

        return result
      })
      .then((result) => {
        result.type = 'results'
        result.id = query
        
        return result
      })
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
