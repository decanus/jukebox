/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ViewRepository {
  /**
   *
   * @param {ModelRepository} modelRepository
   */
  constructor (modelRepository) {
    this._modelRepository = modelRepository
    this._releaseFns = []
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Function}
   */
  hold ({ type, id }) {
    this._releaseFns.push(this._modelRepository.hold({ type, id }))
  }
  
  releaseAll () {
    this._releaseFns.forEach((fn) => fn())
    this._releaseFns = []
  }
}
