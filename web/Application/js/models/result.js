/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Result {
  /**
   *
   * @param {string} id
   * @param {Array<Track|Artist>} results
   * @param {{ size: number, page: number, pages: number }} pagination
   * @param {string} type
   */
  constructor ({ id, results, pagination, type }) {
    this.id = id
    this.results = results
    this.type = type

    /**
     * @type {{ size: number, page: number, pages: number }}
     */
    this.pagination = pagination

    Object.seal(this)
  }

  /**
   *
   * @returns {string}
   */
  get query () {
    return this.id
  }

  /**
   * 
   * @returns {boolean}
   */
  get isCompletelyLoaded () {
    return this.pagination.page === this.pagination.pages
  }
}
