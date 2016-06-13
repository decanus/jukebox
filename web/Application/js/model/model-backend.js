/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ModelBackend {
  /**
   *
   * @param {ModelStore} store
   * @param {ModelFetcher} fetcher
   * @param {ModelLoader} loader
   */
  constructor (store, fetcher, loader) {
    this._store = store
    this._fetcher = fetcher
    this._loader = loader
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  get ({ type, id }) {
    const key = { type, id }

    if (this._store.has(key)) {
      return Promise.resolve(this._store.get(key))
    }

    return this._fetcher
      .fetch(key)
      .then((data) => this._loader.load(data))
  }

  /**
   *
   * @param {{ type: string, id: number }} model
   */
  add (model) {
    this._loader.load(model)
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Function}
   */
  hold ({ type, id }) {
    const key = { type, id }

    this._store.hold(key)

    return () => this._store.release(key)
  }

  cleanup () {
    this._store.cleanup()
  }
}
