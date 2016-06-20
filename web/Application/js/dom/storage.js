/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class StorageWrapper {
  /**
   *
   * @param {Storage} storage
   */
  constructor (storage) {
    /**
     *
     * @type {Storage}
     */
    this._storage = storage
  }

  /**
   *
   * @param {string} key
   */
  get (key) {
    let item = this._storage.getItem(key)

    return JSON.parse(item)
  }

  /**
   *
   * @param {string} key
   * @param {*} value
   */
  set (key, value) {
    this._storage.setItem(key, JSON.stringify(value))
  }

  /**
   *
   * @param {string} key
   */
  remove (key) {
    this._storage.removeItem(key)
  }

  /**
   *
   * @param {string} key
   * @returns {boolean}
   */
  has (key) {
    try {
      this.get(key)
      return true
    } catch (_) {
      return false
    }
  }

  clear () {
    this._storage.clear()
  }

  /**
   *
   * @param {(function({ key: string, value: * }))} fn
   * @returns {Function}
   */
  listen (fn) {
    /** @param {{ storageArea: Storage, key: string, newValue: string }} event */
    const listener = (event) => {
      if (event.storageArea !== this._storage) {
        return
      }

      let value = event.newValue

      if (value !== null) {
        value = JSON.parse(value)
      }

      fn({ key: event.key, value })
    }

    window.addEventListener('storage', listener)

    return () => {
      window.removeEventListener('storage', listener)
    }
  }

  /**
   *
   * @returns {number}
   */
  get size () {
    return this[ native ].length
  }
}
