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
 */
function delegateToCurrentPlayer (method) {
  return new Observable((observer) => {
    let subscription

    this.getTrack().forEach(() => {
      console.log('track changed')
      
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
    
    player.ready().then(() => player.play())
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
  }

  /**
   * 
   * @returns {Promise}
   */
  removeAllTracks () {
    return this.stop().then(() => this._queue.empty())
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
    
    return Observable.merge(play, pause, stop)
  }
}
