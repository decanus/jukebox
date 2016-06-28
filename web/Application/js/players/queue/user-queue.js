/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { TrackList } from '../../value/track-list'
  
export class UserQueue {
  constructor () {
    this._queue = new TrackList()
  }

  /**
   *
   * @param {Track} track
   */
  appendTrack (track) {
    this._queue.append(track)
  }

  /**
   * 
   * @param {Track} track
   */
  setTrack (track) {
    const index = this._queue.indexOfTrack(track)
    const tracks = this.tracks.slice(index)

    this._queue.cleanup()

    this._queue = new TrackList(tracks)
  }

  removeFirstTrack () {
    this._queue.removeFirst()
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
    return this._queue.tracks
  }

  /**
   *
   * @returns {number}
   */
  get size () {
    return this._queue.tracks.length
  }

  /**
   *
   * @returns {Track}
   */
  get currentTrack () {
    return this._queue.get(0)
  }
}
