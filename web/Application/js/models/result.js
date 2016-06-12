/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Result {
  /**
   *
   * @param {string} id
   * @param {Array<Track|Artist>} results
   * @param {{ size: number, page: number, pages: number }} pagination
   */
  constructor ({ id, results, pagination }) {
    this.id = id
    this.results = results

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
  get type () {
    return 'results'
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
