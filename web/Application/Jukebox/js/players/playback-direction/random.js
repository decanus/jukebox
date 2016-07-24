/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { shuffleArray } from '../../library/std/array'

export class Random {
  constructor () {
    this._tracks = []
    this._current = -1
  }

  /**
   *
   * @param {Array<Track>} tracks
   */
  onSetTracks (tracks) {
    this._tracks = shuffleArray(tracks.map((_, i) => i))
  }

  /**
   *
   * @param {number} current
   */
  onSetCurrent (current) {
    this._current = current
  }

  /**
   *
   * @param {Track} track
   */
  onAddTrack (track) {

  }

  /**
   *
   * @param {Track} track
   */
  onRemoveTrack (track) {
    
  }

  getNext(i) {
    const currentIndex = this._tracks.indexOf(i)
  }

  getFirst () {

  }

  /**
   *
   * @returns {number}
   */
  getLast () {
    return this._tracks[this._tracks.length - 1]
  }
}
