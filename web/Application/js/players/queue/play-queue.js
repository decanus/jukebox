/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { TrackList } from '../../value/track-list'

export class PlayQueue {
  /**
   *
   * @param {string} [id]
   * @param {TrackList} [tracks]
   */
  constructor (id = '', tracks = null) {
    this._id = id
    this._tracks = tracks || new TrackList()
    this._current = 0
  }

  /**
   *
   * @param {Track} track
   * @param {Result} result
   */
  static fromContext (track, result) {
    const tracks = TrackList.fromResult(result)
    const queue = new PlayQueue(result.uniqueId, tracks)

    queue.current = tracks.indexOfTrack(track)

    return queue
  }

  next () {

    if (this.isLast()) {
      // todo: repeat mode
      this._current = -1
    } else {
      this._current += 1
    }
  }

  prev () {

  }

  /**
   *
   * @param {Track} track
   */
  setCurrentTrack (track) {
    this.current = this._tracks.indexOfTrack(track)
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
   * @returns {boolean}
   */
  isLast () {
    return this._current === (this.size - 1)
  }

  /**
   *
   * @returns {Track}
   */
  get currentTrack () {
    return this._tracks.get(this._current)
  }

  /**
   *
   * @returns {number}
   */
  get size () {
    return this._tracks.size
  }

  /**
   *
   * @returns {string}
   */
  get id () {
    return this._id
  }

  /**
   *
   * @param {number} value
   */
  set current (value) {
    this._current = value
  }

  /**
   *
   * @returns {number}
   */
  get current () {
    return this._current
  }
}
