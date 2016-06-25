/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { TrackList } from '../../value/track-list'
import { RepeatMode } from '../repeat-mode'

export class PlayQueue {
  /**
   *
   * @param {TrackList} [tracks]
   */
  constructor (tracks = null) {
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
    const queue = new PlayQueue(tracks)

    queue.current = tracks.indexOfTrack(track)

    return queue
  }

  /**
   *
   * @param {number} repeatMode
   */
  next (repeatMode) {
    this._current = this._getNext(repeatMode)
  }

  /**
   *
   * @param {number} repeatMode
   */
  prev (repeatMode) {
    this._current = this._getPrev(repeatMode)
  }

  /**
   *
   * @param {number} repeatMode
   * @returns {number}
   * @private
   */
  _getNext (repeatMode) {
    const isLast = this.isLast()

    if (isLast && repeatMode === RepeatMode.QUEUE) {
      return 0
    }

    if (isLast) {
      return -1
    }

    return this._current + 1
  }

  /**
   *
   * @param {number} repeatMode
   * @returns {number}
   * @private
   */
  _getPrev (repeatMode) {
    if (this.isFirst() && repeatMode === RepeatMode.QUEUE) {
      return this.size - 1
    }

    return this._current - 1
  }

  /**
   *
   * @param {Track} track
   */
  setTrack (track) {
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
  isStopped () {
    return this._current === -1
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
   * @returns {boolean}
   */
  isFirst () {
    return this._current === 0
  }

  /**
   *
   * @returns {Array<Track>}
   */
  getNextTracks () {
    if (this.current === -1) {
      return []
    }

    return this.tracks.tracks.slice(this.current + 1)
  }

  /**
   *
   * @returns {TrackList}
   */
  get tracks () {
    return this._tracks
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
