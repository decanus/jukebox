/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { YoutubePlayer } from './youtube-player'
import { Emitter } from '../event/emitter'
import { Observable } from '../observable'
import { PlayerState } from './player-state'
import { PlayerQueue } from './player-queue'

/**
 *
 * @param {string} method
 * @todo search word if currently searching in field
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

export class PlayerDelegate {
  constructor () {
    /**
     *
     * @type {PlayerQueue}
     * @private
     */
    this._queue = new PlayerQueue()

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
   * @returns {Promise}
   */
  play () {
    if (this._queue.isEmpty()) {
      return Promise.reject()
    }
    
    if (!this._queue.hasCurrentTrack()) {
      return this.setCurrent(0)
        .then(() => this.play())
    }
    
    const player = this.getCurrentPlayer()
    
    player.ready().then(() => {
      this._emitter.emit('loading')
      player.play()
    })
  }

  /**
   * @returns {Promise}
   */
  pause() {
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
  next (automatic = false) {
    return this._playTrackByIndex(this._queue.getNext(automatic))
  }

  /**
   *
   * @returns {Promise}
   */
  prev () {
    return this._playTrackByIndex(this._queue.getPrev())
  }

  /**
   * 
   * @param {number} index
   * @returns {Promise}
   * @private
   */
  _playTrackByIndex(index) {
    if (index === -1) {
      return this.stop()
    }

    return this.setCurrent(index).then(() => this.play())
  }

  stop () {
    const player = this.getCurrentPlayer()

    const result = player.ready()
      .then(() => player.stop())
      .then(() => {
        this._queue.setCurrent(-1)
        this._emitter.emit('stop')
      })

    return result
  }

  /**
   *
   * @param {number} index
   * @returns {Promise}
   */
  setCurrent (index) {
    const pause = this.pause()

    this._queue.setCurrent(index)

    const player = this.getCurrentPlayer()

    const result = pause
      .then(() => player.ready())
      .then(() => {
        // todo: we have to pick the right track here
        player.setTrack(this._queue.getCurrentTrack().youtubeTrack)
        player.setVolume(this._volume)

        this._emitter.emit('trackChange')
      })

    return result
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
   */
  addTrack (track) {
    this._queue.addTrack(track)
    this._emitter.emit('queueChange')
  }

  /**
   *
   * @param {Track} track
   */
  removeTrack (track) {
    this._queue.removeTrack(track)
    this._emitter.emit('queueChange')
  }

  /**
   * 
   * @returns {Promise}
   */
  removeAllTracks () {
    return this.stop().then(() => {
      this._queue.empty()
      this._emitter.emit('queueChange')
    })
  }

  /**
   *
   * @returns {Observable<Track>}
   */
  getTrack () {
    return this._emitter.toObservable('trackChange')
      .map(() => this._queue.getCurrentTrack())
  }

  /**
   * 
   * @returns {Track}
   */
  getCurrentTrack () {
    return this._queue.getCurrentTrack()
  }

  /**
   * 
   * @returns {Array<Track>}
   */
  getTracks () {
    return this._queue.getTracks()
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
    this._queue.setRepeatMode(mode)
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
    return this._queue.getRepeatMode()
  }

  /**
   *
   * @returns {Observable}
   */
  getQueueChange () {
    return this._emitter.toObservable('queueChange')
  }

  /**
   * 
   * @returns {Number}
   */
  getQueueSize () {
    return this._queue.getSize()
  }
}
