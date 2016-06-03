/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'
import { removeElement } from '../std/array'
import { REPEAT_MODE } from './repeat-mode'

class PlayerQueue {
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

    /**
     *
     * @type {Emitter}
     * @private
     */
    this._emitter = new Emitter()
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
   * @returns {Track}
   */
  get currentTrack () {
    if (this._current == -1) {
      return null
    }

    return this._tracks[this._current]
  }

  /**
   *
   * @returns {Observable<Track>}
   */
  getCurrentTrack () {
    return this._emitter
      .toObservable('currentTrackUpdate')
      .map(() => this.currentTrack)
  }

  /**
   * 
   * @returns {Array<Track>}
   */
  get tracks () {
    return this._tracks
  }

  /**
   *
   * @returns {Observable<Array<Track>>}
   */
  getTracks () {
    return this._emitter
      .toObservable('queueUpdate')
      .map(() => this._tracks)
  }

  next () {
    // todo
  }

  prev () {
    // todo
  }
}
