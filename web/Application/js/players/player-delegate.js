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

    this.getTrackChange().forEach(() => {
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
      .forEach(() => {
        console.log('end')
        this.next()
      })
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
   * @returns {Promise}
   */
  next () {
    const next = this._queue.getNext()
    
    if (next === -1) {
      return this.stop()
    }
    
    return this.setCurrent(next).then(() => this.play())
  }

  stop () {
    const player = this.getCurrentPlayer()

    const result = player.ready()
      .then(() => player.stop())
      .then(() => {
        this._queue.setCurrent(-1)
        // todo: emit player update
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
        player.setTrack(this._queue.getCurrentTrack())
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
   * @returns {Observable<Track>}
   */
  getTrackChange () {
    return this._emitter.toObservable('trackChange')
      .map(() => this._queue.getCurrentTrack())
  }
}
