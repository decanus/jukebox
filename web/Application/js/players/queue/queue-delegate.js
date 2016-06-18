/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PlayQueue } from './play-queue'
import { UserQueue } from './user-queue'
import { RepeatMode } from '../repeat-mode'

/**
 * @todo implement repeat mode
 */
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
    if (this.playQueue.id === results.uniqueId) {
      this.playQueue.setCurrentTrack(track)
    } else {
      this.playQueue = PlayQueue.fromContext(track, results)
    }

    this._current = this.playQueue
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
    if (this._current === this.userQueue) {
      // pop the first track off the user queue
      this.userQueue.removeFirstTrack()
    }

    if (this._current === this.playQueue) {
      // move cursor in play queue
      this.playQueue.next()
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
   * @returns {Track}
   */
  get currentTrack () {
    if (this._current == null) {
      return null
    }

    return this._current.currentTrack
  }
}
