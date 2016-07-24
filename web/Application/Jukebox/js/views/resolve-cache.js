/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ResolveCache {
  constructor () {
    /**
     *
     * @type {Object}
     * @private
     */
    this._cache = Object.create(null)
  }

  /**
   *
   * @param {string} path
   * @param {{ id: number, type: string }} model
   */
  add (path, model) {
    this._cache[ path ] = model
  }

  /**
   *
   * @param {string} path
   * @returns {boolean}
   */
  has (path) {
    return Object.prototype.hasOwnProperty.call(this._cache, path)
  }

  /**
   *
   * @param {string} path
   * @returns {{ id: number, type: string }}
   */
  get (path) {
    return this._cache[ path ]
  }
}
