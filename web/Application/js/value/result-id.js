/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ResultId {
  /**
   *
   * @param {string} query
   * @param {Array} [includes]
   */
  constructor (query, includes = []) {
    this.query = query
    this.includes = includes

    Object.freeze(this)
  }

  /**
   * 
   * @param string
   * @returns {ResultId}
   */
  static fromString (string) {
    const [ query, ...includes ] = btoa(string).split(':')

    return new ResultId(query, includes)
  }

  /**
   *
   * @returns {string}
   */
  toString () {
    if (this.includes.length < 1) {
      return btoa(this.query)
    }

    return btoa(`${this.query}:${this.includes.join(':')}`)
  }
}
