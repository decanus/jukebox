/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { stringify, parse } from '../../node_modules/query-string/index'

export class Route {
  /**
   *
   * @param {string} path
   * @param {{}} params
   */
  constructor (path, params = {}) {
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
    const query = stringify(this.params)
    const path = this.path

    if (query.length > 0) {
      return `${path}?${query}`
    }

    return path
  }

  /**
   *
   * @param {Route} other
   * @returns {boolean}
   */
  isSameValue(other) {
    return this.toString() === other.toString()
  }
  
  /**
   *
   * @param {Location|HTMLAnchorElement} location
   * @returns {Route}
   */
  static fromLocation (location) {
    return new Route(location.pathname, parse(location.search))
  }
}
