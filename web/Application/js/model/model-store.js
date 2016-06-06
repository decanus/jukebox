/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ModelStore {
  constructor () {
    /**
     *
     * @type {Object}
     * @private
     */
    this._store = Object.create(null)
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {{ id: number }}
   */
  get ({ type, id }) {
    const key = `${type}-${id}`

    if (this._store[ key ]) {
      return this._store[ key ].model
    }
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {boolean}
   */
  has ({ type, id }) {
    return !!this._store[ `${type}-${id}` ]
  }

  /**
   *
   * @param {{ type: string, id: number }} model
   */
  put (model) {
    const key = `${model.type}-${model.id}`

    if (this._store[ key ]) {
      console.warn('model already loaded ', { type: model.type, id: model.id })
      return
    }

    this._store[ key ] = { model, count: 0 }
  }

  /**
   *
   * @param {{ type: string, id: number }} model
   */
  release (model) {
    this._store[ `${model.type}-${model.id}` ].count -= 1
  }

  /**
   *
   * @param {{ type: string, id: number }} model
   */
  hold (model) {
    this._store[ `${model.type}-${model.id}` ].count += 1
  }

  cleanup () {
    for (let key in this._store) {
      //noinspection JSUnfilteredForInLoop
      const refs = this._store[ key ].count

      if (refs < 1) {
        //noinspection JSUnfilteredForInLoop
        delete this._store[ key ]
      }
    }
  }
}
