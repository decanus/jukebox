/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @todo implement
 */
export class ModelFetcher {
  /**
   *
   * @param {ModelLoader} loader
   */
  constructor (loader) {
    this.loader = loader
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  fetch (type, id) {
    return Promise.resolve({ type, id })
  }
}
