/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { YoutubePlayer } from './youtube-player'
import { Emitter } from '../event/emitter'
import { Observable } from '../event/observable'
import { PlayerState } from './player-state'
import { QueueDelegate } from './queue/queue-delegate'

/**
 *
 * @param {string} method
 */
function delegateToCurrentPlayer (method) {
  return new Observable((observer) => {
    let subscription

    this.getTrack().forEach(() => {
      if (subscription) {
        subscription.unsubscribe()
      }

      subscription = this.getCurrentPlayer()[ method ]()
        .subscribe({
          next: (value) => observer.next(value),
          error: (error) => observer.error(error)
        })
    })

    return () => {
      if (!subscription) {
        return
      }

      subscription.unsubscribe()
    }
  })
}

export class PlayerDelegator {
  constructor () {
    /**
     *
     * @type {QueueDelegate}
     * @private
     */
    this._queue = new QueueDelegate()

    /**
     *
     * @type {Emitter}
     * @private
     */
    this._emitter = new Emitter()

    /**
     *
     * @type {YoutubePlayer}
     * @todo: this needs changing
     * @private
     */
    this._youtubePlayer = new YoutubePlayer()

    /**
     *
     * @type {number}
     * @private
     */
    this._volume = 100

    // todo: move this out of the constructor
    delegateToCurrentPlayer.call(this, 'getEnd')
      .forEach(() => this.next(true))
  }

  /**
   *
   * @param {Track} track
   * @param {Result} result
   */
  async playTrack (track, result) {
    await this.pause()
    
    this._queue.playTrack(track, result)
    this._emitter.emit('queueChange')
    
    await this._loadCurrentTrack()

    return await this.play()
  }

  /**
   *
   * @param {Track} track
   */
  queueTrack (track) {
    this._queue.queueTrack(track)
    this._emitter.emit('queueChange')
  }

  /**
   * 
   * @param {string} queue
   * @param {Track} track
   */
  async setTrack (queue, track) {
    this._queue.setTrack(queue, track)
    this._emitter.emit('queueChange')

    await this._loadCurrentTrack()

    return await this.play()
  }

  async play () {
    if (this._queue.isEmpty()) {
      throw new Error('queue is empty')
    }

    if (!this._queue.hasCurrentTrack()) {
      this._queue.next()
      await this._loadCurrentTrack()
      // await this.setCurrent(0)
    }

    const player = this.getCurrentPlayer()

    await player.ready()
    this._emitter.emit('loading')
    await player.play()
  }

  /**
   * @returns {Promise}
   */
  pause () {
    if (!this._queue.hasCurrentTrack()) {
      return Promise.resolve()
    }

    return this.getCurrentPlayer().pause()
  }

  /**
   *
   * @param {boolean} automatic
   * @returns {Promise}
   */
  async next (automatic = false) {
    this._queue.next(automatic)

    if (!this._queue.hasCurrentTrack()) {
      return await this.stop()
    }
    
    await this._loadCurrentTrack()

    return await this.play()
  }

  /**
   *
   * @returns {Promise}
   */
  async prev () {
    
    if (!this._queue.isFirst()) {
      this._queue.prev()
    }

    await this._loadCurrentTrack()

    return await this.play()
  }

  async stop () {
    const player = this.getCurrentPlayer()

    await player.ready()
    await player.stop()

    this._queue.onStop()
    this._emitter.emit('stop')
  }

  async _loadCurrentTrack () {
    const pause = this.pause()
    const player = this.getCurrentPlayer()

    await pause
    await player.ready()

    player.setTrack(this._queue.currentTrack.youtubeTrack)
    player.setVolume(this._volume)

    this._emitter.emit('trackChange')
  }

  /**
   *
   * @returns {number}
   */
  getCurrent () {
    return this._queue.getCurrent()
  }

  /**
   *
   * @returns {YoutubePlayer}
   */
  getCurrentPlayer () {
    return this._youtubePlayer
  }

  /**
   *
   * @param {Track} track
   * @todo implement
   */
  removeTrack (track) {

  }

  /**
   *
   * @returns {Observable<Track>}
   */
  getTrack () {
    return this._emitter.toObservable('trackChange')
      .map(() => this._queue.currentTrack)
  }

  /**
   *
   * @returns {Track}
   */
  getCurrentTrack () {
    return this._queue.currentTrack
  }

  /**
   *
   * @returns {QueueDelegate}
   */
  getQueue () {
    return this._queue
  }

  /**
   *
   * @returns {number}
   */
  getCurrentVolume () {
    return this._volume
  }

  /**
   *
   * @returns {Observable<number>}
   */
  getVolume () {
    return this._emitter.toObservable('volumeChange').map(() => this._volume)
  }

  /**
   *
   * @param {number} volume
   */
  setVolume (volume) {
    this._volume = volume
    this.getCurrentPlayer().setVolume(volume)
    this._emitter.emit('volumeChange')
  }

  /**
   * @returns {Observable<number>}
   */
  getPosition () {
    return delegateToCurrentPlayer.call(this, 'getPosition')
  }

  /**
   *
   * @param {number} position
   */
  setPosition (position) {
    this.getCurrentPlayer().setPosition(position)
  }

  /**
   * @returns {Observable<number>}
   */
  getDuration () {
    return delegateToCurrentPlayer.call(this, 'getDuration')
  }

  /**
   * @returns {Observable<number>}
   */
  getState () {
    const play = delegateToCurrentPlayer.call(this, 'getPlay')
      .map(() => PlayerState.PLAYING)
    const pause = delegateToCurrentPlayer.call(this, 'getPause')
      .map(() => PlayerState.PAUSED)
    const stop = this._emitter.toObservable('stop')
      .map(() => PlayerState.STOPPED)
    const loading = this._emitter.toObservable('loading')
      .map(() => PlayerState.LOADING)

    return Observable.merge(play, pause, loading, stop)
  }

  /**
   *
   * @param {number} mode
   */
  setRepeatMode (mode) {
    this._queue.repeatMode = mode
    this._emitter.emit('repeatModeChange', mode)
  }

  /**
   *
   * @returns {Observable}
   */
  getRepeatMode () {
    return this._emitter.toObservable('repeatModeChange')
  }

  /**
   *
   * @returns {number}
   */
  getCurrentRepeatMode () {
    return this._queue.repeatMode
  }

  /**
   *
   * @returns {Observable}
   */
  getQueueChange () {
    return this._emitter.toObservable('queueChange')
  }
}
