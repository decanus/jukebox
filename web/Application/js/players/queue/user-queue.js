/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class UserQueue {
  constructor () {
    this._queue = []
  }

  /**
   *
   * @param {Track} track
   */
  appendTrack (track) {
    this._queue.push(track)
  }

  removeFirstTrack () {
    this._queue.shift()
  }

  /**
   *
   * @returns {boolean}
   */
  isEmpty () {
    return this.size === 0
  }

  /**
   *
   * @returns {Array<Track>}
   */
  get tracks () {
    return this._queue
  }

  /**
   *
   * @returns {number}
   */
  get size () {
    return this._queue.length
  }

  /**
   *
   * @returns {Track}
   */
  get currentTrack () {
    return this._queue[ 0 ]
  }
}
