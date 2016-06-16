/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class SharedPort {
  /**
   *
   * @param {string} name
   * @param {StorageWrapper} storage
   */
  constructor (name, storage) {
    this._key = `__$port_message_${name}`
    this._storage = storage
  }

  /**
   *
   * @param {function(*)} fn
   * @returns {Function}
   */
  listen(fn) {
    const key = this._key

    return this._storage.listen((event) => {
      if (key !== event.key) {
        return
      }

      if (!event.value) {
        return
      }

      fn(event.value)
    })
  }

  /**
   * 
   * @param {*} message
   */
  push (message) {
    this._storage.set(this._key, message)
    this._storage.remove(this._key)
  }
}
