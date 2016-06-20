/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PlayQueue } from './play-queue'
import { UserQueue } from './user-queue'
import { RepeatMode } from '../repeat-mode'

export class QueueDelegate {
  constructor () {
    /**
     *
     * @type {PlayQueue|UserQueue}
     * @private
     */
    this._current = null

    /**
     *
     * @type {PlayQueue}
     */
    this.playQueue = new PlayQueue()

    /**
     *
     * @type {UserQueue}
     */
    this.userQueue = new UserQueue()

    /**
     * 
     * @type {number}
     * @private
     */
    this._repeatMode = RepeatMode.NONE
  }

  /**
   *
   * @param {Track} track
   * @param {Result} results
   */
  playTrack (track, results) {
    this.playQueue = PlayQueue.fromContext(track, results)
    this._current = this.playQueue
  }

  /**
   *
   * @param {string} queue
   * @param {Track} track
   */
  setTrack (queue, track) {
    switch(queue) {
      case 'user':
        this.userQueue.setTrack(track)
        this._current = this.userQueue
        return
      case 'play':
        this.playQueue.setTrack(track)
        this._current = this.playQueue
        return
    }
  }

  /**
   *
   * @param {Track} track
   */
  queueTrack (track) {
    this.userQueue.appendTrack(track)
  }

  /**
   *
   * @param {boolean} automatic
   */
  next (automatic = false) {

    if (this._repeatMode === RepeatMode.TRACK && automatic) {
      return
    }

    if (this._current === this.userQueue) {
      // pop the first track off the user queue
      this.userQueue.removeFirstTrack()
    }

    if (this._current === this.playQueue) {
      // move cursor in play queue
      this.playQueue.next(this.repeatMode)
    }

    // if there's a track in the user queue we play that one
    if (!this.userQueue.isEmpty()) {
      this._current = this.userQueue
      return
    }

    if (!this.playQueue.isEmpty()) {
      this._current = this.playQueue
    }
  }

  prev () {
    this._current = this.playQueue
    this.playQueue.prev(this._repeatMode)
  }
  
  onStop () {
    this._current = null
  }

  /**
   *
   * @returns {boolean}
   */
  isEmpty () {
    return this.playQueue.isEmpty() && this.userQueue.isEmpty()
  }

  /**
   *
   * @returns {boolean}
   */
  hasCurrentTrack () {
    return this.currentTrack !== null
  }

  /**
   *
   * @returns {Array<Track>}
   */
  getNextUserQueueTracks () {
    if (this._current === this.userQueue) {
      return this.userQueue.tracks.slice(1)
    }

    return this.userQueue.tracks
  }

  /**
   *
   * @returns {Array<Track>}
   */
  getNextPlayQueueTracks () {
    return this.playQueue.getNextTracks()
  }

  /**
   *
   * @returns {Track}
   */
  get currentTrack () {
    if (this._current == null) {
      return null
    }

    return this._current.currentTrack
  }

  /**
   *
   * @param {number} value
   */
  set repeatMode (value) {
    this._repeatMode = value
  }

  /**
   *
   * @returns {number}
   */
  get repeatMode () {
    return this._repeatMode
  }
}
