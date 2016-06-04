/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { removeElement } from '../std/array'
import { REPEAT_MODE } from './repeat-mode'

export class PlayerQueue {
  constructor () {
    /**
     *
     * @type {Array<Track>}
     * @private
     */
    this._tracks = []

    /**
     *
     * @type {number}
     * @private
     */
    this._current = -1

    /**
     *
     * @type {number}
     * @private
     */
    this._repeatMode = REPEAT_MODE.NONE
  }

  /**
   *
   * @param {number} repeatMode
   */
  setRepeatMode(repeatMode) {
    this._repeatMode = repeatMode
  }

  /**
   * 
   * @returns {number}
   */
  getRepeatMode () {
    return this._repeatMode
  }

  /**
   *
   * @param {Track} track
   */
  addTrack (track) {
    this._tracks.push(track)
  }

  /**
   *
   * @param {Track} track
   */
  removeTrack (track) {
    this._tracks = removeElement(this._tracks, track)
  }

  empty () {
    this._tracks = []
  }

  /**
   * 
   * @returns {boolean}
   */
  isEmpty () {
    return this._tracks.length === 0
  }

  /**
   *
   * @param {number} trackId
   */
  removeTrackById (trackId) {
    this._tracks
      .filter((track) => track.id === trackId)
      .forEach((track) => this.removeTrack(track))
  }

  /**
   * 
   * @param {number} current
   */
  setCurrent (current) {
    this._current = current
  }

  /**
   *
   * @returns {Track}
   */
  getCurrentTrack () {
    if (!this.hasCurrentTrack()) {
      return null
    }

    return this._tracks[this._current]
  }

  /**
   * 
   * @returns {boolean}
   */
  hasCurrentTrack () {
    return this._current !== -1
  } 

  /**
   * 
   * @returns {Array<Track>}
   */
  getTracks () {
    return this._tracks
  }

  /**
   *
   * @returns {boolean}
   */
  isLast () {
    return this._current === this._tracks.length - 1
  }

  /**
   *
   * @returns {number}
   */
  getNext () {
    const isLast = this.isLast()
    const current = this._current

    if (this._repeatMode === REPEAT_MODE.TRACK) {
      return current
    }

    if (!isLast) {
      return current + 1
    }

    if (this._repeatMode === REPEAT_MODE.QUEUE) {
      return 0
    }

    return -1
  }

  getPrev () {
    // todo
  }
}
