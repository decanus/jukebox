/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildQuery, parseQuery } from '../url/query'

export class Uri {
  /**
   *
   * @param {string} path
   * @param {Map} params
   */
  constructor (path, params = new Map()) {
    this.path = path
    this.params = params

    Object.freeze(this)
  }

  /**
   *
   * @returns {Array.<string>}
   */
  get pathParts () {
    return this.path.split('/').slice(1)
  }

  /**
   *
   * @returns {string}
   */
  toString () {
    const query = buildQuery(this.params)
    const path = this.path

    if (query.length > 0) {
      return `${path}?${query}`
    }
    

    return path
  }

  /**
   *
   * @param {Uri} other
   * @returns {boolean}
   */
  isSameValue(other) {
    return this.toString() === other.toString() && other instanceof Uri
  }
  
  /**
   *
   * @param {Location|HTMLAnchorElement} location
   * @returns {Uri}
   */
  static fromLocation (location) {
    return new Uri(location.pathname, parseQuery(location.search))
  }
}
