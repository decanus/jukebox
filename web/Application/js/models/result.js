/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Result {
  /**
   *
   * @param {string} id
   * @param {Array<Track|Artist>} results
   */
  constructor ({ id, results }) {
    this.id = id
    this.results = results

    Object.freeze(this)
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
}
